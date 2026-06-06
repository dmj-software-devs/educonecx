<?php

namespace App\Http\Controllers;

use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Models\AcademyUserAvatarSetting;
use App\Models\PracticeCreditTransaction;
use App\Models\UserPracticeCredit;
use App\Services\HeyGenLiveAvatarService;
use App\Services\OpenAIEvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EduconecxAcademyController extends Controller
{
    public function index(HeyGenLiveAvatarService $heyGenService)
    {
        $missingHeyGenConfig = $heyGenService->getMissingConfigurationKeys();
        $avatarSetting = AcademyUserAvatarSetting::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
        $currentCoachConfig = $this->currentAvatarConfig($avatarSetting);
        $creditAccount = $this->ensureCreditAccount(auth()->id());
        $recentPracticeSessions = AcademySession::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->take(4)
            ->get();
        $practiceStats = [
            'total_sessions' => AcademySession::where('user_id', auth()->id())->count(),
            'average_overall_score' => round((float) (AcademySession::where('user_id', auth()->id())->whereNotNull('overall_score')->avg('overall_score') ?? 0), 1),
            'last_practice_date' => optional(AcademySession::where('user_id', auth()->id())->latest()->first()?->created_at)->format('M d, Y'),
            'completed_reviews' => AcademySession::where('user_id', auth()->id())->whereNotNull('overall_score')->count(),
        ];
        $creditSummary = [
            'balance' => $creditAccount->balance,
            'practice_cost' => $this->creditCost('practice'),
            'exam_cost' => $this->creditCost('exam'),
            'lifetime_used' => $creditAccount->lifetime_used,
            'lifetime_granted' => $creditAccount->lifetime_granted,
        ];

        return view('educonecx-academy.index', compact('missingHeyGenConfig', 'avatarSetting', 'currentCoachConfig', 'recentPracticeSessions', 'practiceStats', 'creditSummary'));
    }

    public function createLiveAvatarToken(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
            'session_type' => ['nullable', 'in:practice,exam'],
        ]);

        $scenario = ! empty($validated['scenario_slug'])
            ? AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail()
            : null;

        try {
            $user = auth()->user();
            $tokenData = $heyGenService->generateSessionToken($scenario, $user);

            return response()->json([
                'success' => true,
                'token' => $tokenData['token'],
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to prepare your speaking session right now. Please try again later.',
            ], 422);
        }
    }


    public function createLiveAvatarEmbed(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
            'session_type' => ['nullable', 'in:practice,exam'],
        ]);

        $scenario = ! empty($validated['scenario_slug'])
            ? AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail()
            : null;

        try {
            $user = $request->user();
            abort_unless($user, 401);

            $sessionType = $validated['session_type'] ?? 'practice';
            $creditCost = $this->creditCost($sessionType);
            $creditAccount = $this->ensureCreditAccount($user->id);

            if ($creditAccount->balance < $creditCost) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have enough Practice Room credits to start this session.',
                    'credits_required' => $creditCost,
                    'credits_available' => $creditAccount->balance,
                ], 402);
            }

            $avatarSetting = $this->activeAvatarSetting($user->id);
            $currentConfig = $this->currentAvatarConfig($avatarSetting);
            $embed = $heyGenService->createLiveAvatarEmbed($scenario, $user);
            $embedUrl = $embed['embed_url'];
            $resolved = data_get($embed, 'resolved', []);

            $session = AcademySession::create([
                'user_id' => $user->id,
                'academy_category_id' => $scenario?->academy_category_id,
                'academy_scenario_id' => $scenario?->id,
                'liveavatar_embed_id' => $this->extractLiveAvatarEmbedId($embedUrl, $embed['response'] ?? []),
                'liveavatar_embed_url' => $embedUrl,
                'heygen_avatar_id' => data_get($resolved, 'avatar_id'),
                'heygen_voice_id' => data_get($resolved, 'voice_id'),
                'heygen_context_id' => data_get($resolved, 'context_id'),
                'avatar_name' => $currentConfig['avatar_name'],
                'avatar_image_url' => $currentConfig['avatar_image_url'],
                'context_name' => $currentConfig['context_name'],
                'dynamic_instructions' => $heyGenService->buildDynamicInstructions($scenario, $user),
                'config_source' => data_get($resolved, 'source'),
                'status' => 'started',
                'session_type' => $sessionType,
                'credit_used' => $creditCost,
                'started_at' => now(),
                'raw_response' => $embed['response'] ?? [],
            ]);

            $this->consumeCredits($user->id, $creditCost, $session, $sessionType);

            return response()->json([
                'success' => true,
                'academy_session_id' => $session->id,
                'embed_url' => $embedUrl,
                'embed_script' => $embed['embed_script'],
                'session_type' => $sessionType,
                'is_exam' => $sessionType === 'exam',
                'credits_remaining' => $this->ensureCreditAccount($user->id)->balance,
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to prepare your speaking session right now. Please try again later.',
            ], 422);
        }
    }


    public function evaluateSession(Request $request, OpenAIEvaluationService $service): JsonResponse
    {
        $validated = $request->validate([
            'academy_session_id' => ['nullable', 'integer', 'exists:academy_sessions,id'],
            'transcript' => ['required', 'string', 'min:10'],
        ]);

        $session = $this->resolveEvaluationSession($validated, $request);

        $session->update([
            'transcript' => $validated['transcript'],
            'status' => 'evaluating',
        ]);

        try {
            $evaluation = $service->evaluateSession($session, $validated['transcript']);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() === 'Performance review service is not configured.' ? 'Performance review service is not configured.' : $exception->getMessage(),
            ], $exception->getMessage() === 'Performance review service is not configured.' ? 422 : 500);
        }

        $this->saveEvaluationToSession($session, $evaluation);

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation,
        ]);
    }

    public function evaluateAudioSession(Request $request, OpenAIEvaluationService $service): JsonResponse
    {
        $validated = $request->validate([
            'audio' => ['required', 'file', 'max:20480', 'mimes:webm,mp3,mp4,mpeg,mpga,m4a,wav,ogg'],
            'academy_session_id' => ['nullable', 'integer', 'exists:academy_sessions,id'],
        ]);

        $session = $this->resolveEvaluationSession($validated, $request);
        $audioPath = $request->file('audio')->store('academy-audio', 'public');
        $absoluteAudioPath = Storage::disk('public')->path($audioPath);

        $session->update([
            'audio_path' => $audioPath,
            'status' => 'evaluating',
        ]);

        try {
            $evaluation = $service->evaluateAudioSession($session, $absoluteAudioPath);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() === 'Performance review service is not configured.' ? 'Performance review service is not configured.' : $exception->getMessage(),
            ], $exception->getMessage() === 'Performance review service is not configured.' ? 422 : 500);
        }

        $this->saveEvaluationToSession($session, $evaluation, [
            'transcript' => $evaluation['transcript'] ?? null,
            'audio_path' => $audioPath,
        ]);

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation,
        ]);
    }

    private function resolveEvaluationSession(array $validated, Request $request): AcademySession
    {
        $user = $request->user();
        abort_unless($user, 401);

        if (! empty($validated['academy_session_id'])) {
            $session = AcademySession::with(['scenario.category'])->findOrFail($validated['academy_session_id']);
            abort_unless((int) $session->user_id === (int) $user->id, 403);

            if ($session->is_locked) {
                throw ValidationException::withMessages([
                    'academy_session_id' => 'This exam has already been submitted and locked.',
                ]);
            }

            return $session;
        }

        $avatarSetting = $this->activeAvatarSetting($user->id);
        $currentConfig = $this->currentAvatarConfig($avatarSetting);

        if (blank($currentConfig['avatar_id']) || blank($currentConfig['context_id'])) {
            throw ValidationException::withMessages([
                'academy_session_id' => 'The Practice Room is not ready yet. Please contact support before requesting a performance review.',
            ]);
        }

        return AcademySession::create([
            'user_id' => $user->id,
            'heygen_avatar_id' => $currentConfig['avatar_id'],
            'heygen_voice_id' => $currentConfig['voice_id'],
            'heygen_context_id' => $currentConfig['context_id'],
            'avatar_name' => $currentConfig['avatar_name'],
            'avatar_image_url' => $currentConfig['avatar_image_url'],
            'context_name' => $currentConfig['context_name'],
            'status' => 'evaluating',
            'session_type' => 'practice',
            'started_at' => now(),
        ])->load(['scenario.category']);
    }

    private function saveEvaluationToSession(AcademySession $session, array $evaluation, array $extra = []): void
    {
        $isExam = $session->session_type === 'exam';
        $overallScore = $evaluation['overall_score'] ?? null;

        $session->update(array_merge([
            'grammar_score' => $evaluation['grammar_score'] ?? null,
            'fluency_score' => $evaluation['fluency_score'] ?? null,
            'vocabulary_score' => $evaluation['vocabulary_score'] ?? null,
            'pronunciation_score' => $evaluation['pronunciation_score'] ?? null,
            'overall_score' => $overallScore,
            'exam_score' => $isExam ? $overallScore : $session->exam_score,
            'exam_result' => $isExam ? $this->examResult($overallScore) : $session->exam_result,
            'corrections' => $evaluation['corrections'] ?? [],
            'strengths' => $evaluation['strengths'] ?? [],
            'weaknesses' => $evaluation['weaknesses'] ?? [],
            'next_steps' => $evaluation['next_steps'] ?? [],
            'feedback' => $evaluation['feedback'] ?? null,
            'ai_evaluation' => $evaluation,
            'evaluated_at' => now(),
            'submitted_at' => $isExam ? now() : $session->submitted_at,
            'is_locked' => $isExam ? true : $session->is_locked,
            'locked_at' => $isExam ? now() : $session->locked_at,
            'ended_at' => $isExam ? now() : $session->ended_at,
            'status' => $isExam ? 'submitted' : 'evaluated',
        ], array_filter($extra, fn($value) => $value !== null)));
    }



    private function ensureCreditAccount(int $userId): UserPracticeCredit
    {
        $account = UserPracticeCredit::firstOrCreate(
            ['user_id' => $userId],
            [
                'balance' => config('practice_room.default_course_credits'),
                'lifetime_granted' => config('practice_room.default_course_credits'),
            ]
        );

        if ($account->wasRecentlyCreated && $account->lifetime_granted > 0) {
            PracticeCreditTransaction::create([
                'user_id' => $userId,
                'type' => 'course_grant',
                'amount' => $account->lifetime_granted,
                'balance_after' => $account->balance,
                'description' => 'Default Practice Room course credits',
            ]);
        }

        return $account->fresh();
    }

    private function consumeCredits(int $userId, int $amount, AcademySession $session, string $sessionType): void
    {
        if ($amount <= 0) {
            return;
        }

        $account = $this->ensureCreditAccount($userId);
        $account->decrement('balance', $amount);
        $account->increment('lifetime_used', $amount);
        $account->refresh();

        PracticeCreditTransaction::create([
            'user_id' => $userId,
            'academy_session_id' => $session->id,
            'type' => 'usage',
            'amount' => -$amount,
            'balance_after' => $account->balance,
            'description' => ucfirst($sessionType) . ' session credit usage',
            'meta' => ['session_type' => $sessionType],
        ]);
    }

    private function creditCost(string $sessionType): int
    {
        return $sessionType === 'exam'
            ? (int) config('practice_room.exam_credit_cost')
            : (int) config('practice_room.practice_credit_cost');
    }

    private function examResult($score): ?string
    {
        if ($score === null) {
            return null;
        }

        return ((float) $score) >= 7 ? 'Pass' : 'Needs Practice';
    }

    private function activeAvatarSetting(int $userId): ?AcademyUserAvatarSetting
    {
        return AcademyUserAvatarSetting::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();
    }

    private function currentAvatarConfig(?AcademyUserAvatarSetting $avatarSetting): array
    {
        return [
            'avatar_id' => $avatarSetting?->heygen_avatar_id ?: config('services.heygen.default_avatar_id'),
            'voice_id' => $avatarSetting?->heygen_voice_id ?: config('services.heygen.default_voice_id'),
            'context_id' => $avatarSetting?->heygen_context_id ?: config('services.heygen.default_context_id'),
            'avatar_name' => 'Victoria Clarke',
            'avatar_image_url' => $avatarSetting?->avatar_image_url,
            'context_name' => $avatarSetting?->context_name ?: 'Personalized English speaking practice',
            'preferred_language' => $avatarSetting?->preferred_language ?: 'English',
            'speaking_level' => $avatarSetting?->speaking_level,
            'tutor_style' => $avatarSetting?->tutor_style,
            'source' => [
                'avatar_id' => $avatarSetting?->heygen_avatar_id ? 'user' : (config('services.heygen.default_avatar_id') ? 'env' : 'none'),
                'voice_id' => $avatarSetting?->heygen_voice_id ? 'user' : (config('services.heygen.default_voice_id') ? 'env' : 'none'),
                'context_id' => $avatarSetting?->heygen_context_id ? 'user' : (config('services.heygen.default_context_id') ? 'env' : 'none'),
            ],
        ];
    }

    private function extractLiveAvatarEmbedId(?string $embedUrl, array $response = []): ?string
    {
        $providerId = data_get($response, 'data.id')
            ?? data_get($response, 'id')
            ?? data_get($response, 'data.embed_id');

        if (filled($providerId)) {
            return (string) $providerId;
        }

        if (blank($embedUrl)) {
            return null;
        }

        $path = parse_url($embedUrl, PHP_URL_PATH);
        $candidate = $path ? basename($path) : null;

        return $candidate && $candidate !== '/' ? $candidate : null;
    }

    public function endSession(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'academy_session_id' => ['required', 'integer', 'exists:academy_sessions,id'],
            'score' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'feedback' => ['nullable', 'string'],
            'transcript' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ]);

        $session = AcademySession::findOrFail($validated['academy_session_id']);
        abort_unless((int) $session->user_id === (int) $request->user()->id, 403);

        $session->update([
            'score' => $validated['score'] ?? $session->score,
            'feedback' => $validated['feedback'] ?? $session->feedback,
            'transcript' => $validated['transcript'] ?? $session->transcript,
            'status' => $validated['status'] ?? 'ended',
            'ended_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session ended successfully.',
        ]);
    }
}
