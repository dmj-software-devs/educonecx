<?php

namespace App\Http\Controllers;

use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Models\AcademyUserAvatarSetting;
use App\Exceptions\InsufficientPracticeCreditsException;
use App\Services\HeyGenLiveAvatarService;
use App\Services\OpenAIEvaluationService;
use App\Services\PracticeCreditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EduconecxAcademyController extends Controller
{
    public function index(HeyGenLiveAvatarService $heyGenService, PracticeCreditService $creditService): View
    {
        $creditWallet = $creditService->grantSignupCredits(auth()->user());
        $practiceCreditCost = $creditService->getSessionCost('practice');
        $examCreditCost = $creditService->getSessionCost('exam');

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return view('educonecx-academy.paywall');
        }

        $missingHeyGenConfig = $heyGenService->getMissingConfigurationKeys();
        $avatarSetting = AcademyUserAvatarSetting::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();
        $defaultPracticeAvatarId = config('services.heygen.default_avatar_id')
            ?: '513fd1b7-7ef9-466d-9af2-344e51eeb833';
        $defaultAvatar = $heyGenService->findPublicAvatarById($defaultPracticeAvatarId);
        $defaultAvatarMetadata = $defaultAvatar ?: $heyGenService->defaultPracticeAvatarMetadata();
        $currentAvatarConfig = $this->currentAvatarConfig($avatarSetting, $defaultAvatarMetadata);
        $currentAvatarConfig['avatar_id'] = $currentAvatarConfig['avatar_id'] ?? $defaultPracticeAvatarId;
        $currentAvatarConfig['avatar_name'] = $currentAvatarConfig['avatar_name'] ?? data_get($defaultAvatar, 'name', 'Victoria Clarke');
        $currentAvatarConfig['avatar_image_url'] = $this->isValidImageUrl(data_get($currentAvatarConfig, 'avatar_image_url'))
            ? data_get($currentAvatarConfig, 'avatar_image_url')
            : (data_get($defaultAvatar, 'image_url') ?: data_get($defaultAvatarMetadata, 'image_url'));
        $currentAvatarConfig['image_url'] = $currentAvatarConfig['avatar_image_url'];
        $currentAvatarConfig['voice_id'] = $currentAvatarConfig['voice_id'] ?? data_get($defaultAvatar, 'default_voice_id');
        $introVideoUrl = config('services.heygen.practice_room_intro_video_url');
        $practiceCoachImage = data_get($currentAvatarConfig, 'avatar_image_url')
            ?: data_get($defaultAvatar, 'image_url')
            ?: asset('images/academy/victoria-clarke.jpg');
        $defaultAvatarDebug = [
            'default_avatar_id' => $defaultPracticeAvatarId,
            'resolved_image_url' => data_get($defaultAvatar, 'image_url') ?: data_get($defaultAvatarMetadata, 'image_url'),
            'current_avatar_image_url' => data_get($currentAvatarConfig, 'avatar_image_url'),
        ];
        $examCoachImage = file_exists(public_path('images/academy/olivia.jpg')) ? asset('images/academy/olivia.jpg') : null;
        $recentAcademySessions = auth()->check()
            ? AcademySession::query()
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(5)
                ->get()
            : collect();
        $creditWallet->refresh();
        $creditsAvailable = (int) $creditWallet->balance;

        return view('educonecx-academy.index', compact('missingHeyGenConfig', 'avatarSetting', 'currentAvatarConfig', 'introVideoUrl', 'practiceCoachImage', 'examCoachImage', 'recentAcademySessions', 'creditsAvailable', 'practiceCreditCost', 'examCreditCost', 'defaultAvatarDebug'));
    }

    public function createLiveAvatarToken(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
            'session_type' => ['nullable', 'in:practice,exam'],
        ]);

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $scenario = ! empty($validated['scenario_slug'])
            ? AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail()
            : null;

        try {
            $user = auth()->user();
            $sessionType = $validated['session_type'] ?? 'practice';
            $tokenData = $heyGenService->generateSessionToken($scenario, $user, $sessionType);
            $resolved = $heyGenService->resolveAvatarConfig($scenario, $user, $sessionType);
            $instructions = $heyGenService->buildDynamicInstructions($scenario, $user, $sessionType);

            return response()->json([
                'success' => true,
                'token' => $tokenData['token'],
                'avatar_id' => $resolved['avatar_id'],
                'voice_id' => $resolved['voice_id'],
                'context_id' => $resolved['context_id'],
                'instructions' => $instructions,
                'endpoint_url' => $tokenData['endpoint_url'],
                'endpoint_status' => $tokenData['status'],
                'debug' => $heyGenService->apiKeyDebugMeta(),
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'endpoint_url' => 'https://api.liveavatar.com/v1/sessions/token',
                'hint' => 'If auth fails, set LIVEAVATAR_API_KEY explicitly (preferred for LiveAvatar) and run php artisan optimize:clear.',
                'debug' => $heyGenService->apiKeyDebugMeta(),
            ], 422);
        }
    }


    public function createLiveAvatarEmbed(Request $request, HeyGenLiveAvatarService $heyGenService, PracticeCreditService $creditService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
            'session_type' => ['nullable', 'in:practice,exam'],
        ]);

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $scenario = ! empty($validated['scenario_slug'])
            ? AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail()
            : null;

        $user = $request->user();
        abort_unless($user, 401);

        $creditService->grantSignupCredits($user);
        $sessionType = $validated['session_type'] ?? 'practice';
        $creditCost = $creditService->getSessionCost($sessionType);
        $currentBalance = $creditService->getBalance($user);

        if (! $creditService->hasEnoughCredits($user, $creditCost)) {
            return response()->json([
                'success' => false,
                'type' => 'insufficient_credits',
                'message' => 'You do not have enough practice credits to start this session.',
                'balance' => $currentBalance,
                'required' => $creditCost,
            ], 402);
        }

        $session = null;
        $creditTransaction = null;

        try {
            $avatarSetting = $this->activeAvatarSetting($user->id);
            $defaultAvatarMetadata = $sessionType === 'exam' ? null : $heyGenService->defaultPracticeAvatarMetadata();
            $currentConfig = $sessionType === 'exam' ? $this->examAvatarConfig($avatarSetting) : $this->currentAvatarConfig($avatarSetting, $defaultAvatarMetadata);

            $session = AcademySession::create([
                'user_id' => $user->id,
                'academy_category_id' => $scenario?->academy_category_id,
                'academy_scenario_id' => $scenario?->id,
                'session_type' => $sessionType,
                'avatar_name' => $currentConfig['avatar_name'],
                'avatar_image_url' => $currentConfig['avatar_image_url'],
                'context_name' => $currentConfig['context_name'],
                'dynamic_instructions' => $heyGenService->buildDynamicInstructions($scenario, $user, $sessionType),
                'status' => 'starting',
                'started_at' => now(),
                'credit_used' => $creditCost,
                'credits_used' => $creditCost,
                'evaluation_used' => false,
                'recording_used' => false,
                'attempt_locked' => false,
            ]);

            $creditTransaction = $creditService->deductCredits(
                $user,
                $creditCost,
                $sessionType === 'exam' ? 'exam_usage' : 'practice_usage',
                $session,
                $sessionType === 'exam' ? 'Speaking Exam credit usage.' : 'Practice Room session credit usage.',
                ['session_type' => $sessionType]
            );

            $session->update(['credit_transaction_id' => $creditTransaction->id]);

            $embed = $heyGenService->createLiveAvatarEmbed($scenario, $user, $sessionType);
            $embedUrl = $embed['embed_url'];
            $resolved = data_get($embed, 'resolved', []);

            if ($sessionType !== 'exam' && (string) data_get($resolved, 'avatar_id') === (string) data_get($defaultAvatarMetadata, 'id')) {
                $currentConfig = $this->currentAvatarConfig(null, $defaultAvatarMetadata);
            }

            $session->update([
                'liveavatar_embed_id' => $this->extractLiveAvatarEmbedId($embedUrl, $embed['response'] ?? []),
                'liveavatar_embed_url' => $embedUrl,
                'heygen_avatar_id' => data_get($resolved, 'avatar_id'),
                'heygen_voice_id' => data_get($resolved, 'voice_id'),
                'heygen_context_id' => data_get($resolved, 'context_id'),
                'avatar_name' => $currentConfig['avatar_name'],
                'avatar_image_url' => $currentConfig['avatar_image_url'],
                'context_name' => $currentConfig['context_name'],
                'config_source' => data_get($resolved, 'source'),
                'status' => 'started',
                'raw_response' => $embed['response'] ?? [],
            ]);

            return response()->json([
                'success' => true,
                'academy_session_id' => $session->id,
                'embed_url' => $embedUrl,
                'embed_script' => $embed['embed_script'],
                'avatar_id' => data_get($resolved, 'avatar_id'),
                'voice_id' => data_get($resolved, 'voice_id'),
                'context_id' => data_get($resolved, 'context_id'),
                'endpoint_url' => $embed['endpoint_url'],
                'endpoint_status' => $embed['status'],
                'credits_balance' => $creditService->getBalance($user),
                'credits_used' => $creditCost,
            ]);
        } catch (InsufficientPracticeCreditsException $exception) {
            return response()->json([
                'success' => false,
                'type' => 'insufficient_credits',
                'message' => 'You do not have enough practice credits to start this session.',
                'balance' => $creditService->getBalance($user),
                'required' => $creditCost,
            ], 402);
        } catch (\Throwable $exception) {
            if ($creditTransaction && $session) {
                $creditService->refundCredits($user, $creditCost, $session, 'Refund for failed Practice Room session.');
            }

            if ($session) {
                $session->update(['status' => 'failed']);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unable to prepare your speaking session right now. Please try again later.',
                'credits_balance' => $creditService->getBalance($user),
                'debug' => config('app.debug') ? $heyGenService->apiKeyDebugMeta() : null,
            ], 422);
        }
    }


    public function evaluateSession(Request $request, OpenAIEvaluationService $service): JsonResponse
    {
        $validated = $request->validate([
            'academy_session_id' => ['nullable', 'integer', 'exists:academy_sessions,id'],
            'transcript' => ['required', 'string', 'min:10'],
        ]);

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $session = $this->resolveEvaluationSession($validated, $request);

        $session->update([
            'transcript' => $validated['transcript'],
            'status' => 'evaluating',
            'evaluation_used' => true,
        ]);

        try {
            $evaluation = $service->evaluateSession($session, $validated['transcript']);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() === 'OpenAI evaluation is not configured.' ? 'Performance review service is not configured.' : $exception->getMessage(),
            ], $exception->getMessage() === 'OpenAI evaluation is not configured.' ? 422 : 500);
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

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $session = $this->resolveEvaluationSession($validated, $request);
        $audioPath = $request->file('audio')->store('academy-audio', 'public');
        $absoluteAudioPath = Storage::disk('public')->path($audioPath);

        $session->update([
            'audio_path' => $audioPath,
            'status' => 'evaluating',
            'recording_used' => true,
            'evaluation_used' => true,
        ]);

        try {
            $evaluation = $service->evaluateAudioSession($session, $absoluteAudioPath);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() === 'OpenAI evaluation is not configured.' ? 'Performance review service is not configured.' : $exception->getMessage(),
            ], $exception->getMessage() === 'OpenAI evaluation is not configured.' ? 422 : 500);
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
            if ($session->attempt_locked) {
                throw ValidationException::withMessages([
                    'academy_session_id' => 'This exam attempt is locked.',
                ]);
            }

            return $session;
        }

        $avatarSetting = $this->activeAvatarSetting($user->id);
        $currentConfig = $this->currentAvatarConfig($avatarSetting);

        if (blank($currentConfig['avatar_id']) || blank($currentConfig['context_id'])) {
            throw ValidationException::withMessages([
                'academy_session_id' => 'Please complete your Coach Settings before requesting a performance review.',
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
            'session_type' => $request->input('session_type', 'practice') === 'exam' ? 'exam' : 'practice',
            'status' => 'evaluating',
            'started_at' => now(),
        ])->load(['scenario.category']);
    }

    private function saveEvaluationToSession(AcademySession $session, array $evaluation, array $extra = []): void
    {
        $session->update(array_merge([
            'grammar_score' => $evaluation['grammar_score'] ?? null,
            'fluency_score' => $evaluation['fluency_score'] ?? null,
            'vocabulary_score' => $evaluation['vocabulary_score'] ?? null,
            'pronunciation_score' => $evaluation['pronunciation_score'] ?? null,
            'overall_score' => $evaluation['overall_score'] ?? null,
            'corrections' => $evaluation['corrections'] ?? [],
            'strengths' => $evaluation['strengths'] ?? [],
            'weaknesses' => $evaluation['weaknesses'] ?? [],
            'next_steps' => $evaluation['next_steps'] ?? [],
            'feedback' => $evaluation['feedback'] ?? null,
            'ai_evaluation' => $evaluation,
            'evaluated_at' => now(),
            'status' => 'evaluated',
            'ended_at' => now(),
            'duration_seconds' => $session->started_at ? now()->diffInSeconds($session->started_at) : null,
            'attempt_locked' => $session->session_type === 'exam',
        ], array_filter($extra, fn($value) => $value !== null)));
    }


    private function isValidImageUrl(mixed $imageUrl): bool
    {
        if (! is_string($imageUrl) || blank($imageUrl)) {
            return false;
        }

        return str_starts_with($imageUrl, 'http://')
            || str_starts_with($imageUrl, 'https://')
            || str_starts_with($imageUrl, '/');
    }

    private function activeAvatarSetting(int $userId): ?AcademyUserAvatarSetting
    {
        return AcademyUserAvatarSetting::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->first();
    }

    private function currentAvatarConfig(?AcademyUserAvatarSetting $avatarSetting, ?array $defaultAvatarMetadata = null): array
    {
        $defaultAvatarId = (string) (config('services.heygen.default_avatar_id') ?: '513fd1b7-7ef9-466d-9af2-344e51eeb833');
        $avatarId = $avatarSetting?->heygen_avatar_id ?: $defaultAvatarId;
        $usesDefaultAvatar = (string) $avatarId === $defaultAvatarId;

        return [
            'avatar_id' => $avatarId,
            'voice_id' => $avatarSetting?->heygen_voice_id ?: config('services.heygen.default_voice_id') ?: data_get($defaultAvatarMetadata, 'default_voice_id'),
            'context_id' => $avatarSetting?->heygen_context_id ?: config('services.heygen.default_context_id'),
            'avatar_name' => $usesDefaultAvatar ? 'Victoria Clarke' : ($avatarSetting?->avatar_name ?: 'English Coach'),
            'avatar_image_url' => $avatarSetting?->avatar_image_url ?: ($usesDefaultAvatar ? data_get($defaultAvatarMetadata, 'image_url') : null),
            'image_url' => $avatarSetting?->avatar_image_url ?: ($usesDefaultAvatar ? data_get($defaultAvatarMetadata, 'image_url') : null),
            'context_name' => 'English Speaking Practice',
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

    private function examAvatarConfig(?AcademyUserAvatarSetting $avatarSetting): array
    {
        $config = $this->currentAvatarConfig($avatarSetting);

        return array_merge($config, [
            'avatar_id' => config('services.heygen.exam_avatar_id') ?: $config['avatar_id'],
            'voice_id' => config('services.heygen.exam_voice_id') ?: $config['voice_id'],
            'context_id' => config('services.heygen.exam_context_id') ?: $config['context_id'],
            'avatar_name' => 'Olivia',
            'avatar_image_url' => file_exists(public_path('images/academy/olivia.jpg')) ? asset('images/academy/olivia.jpg') : null,
            'context_name' => 'English Speaking Exam',
        ]);
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

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

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

    private function currentUserCanAccessPracticeRoom(): bool
    {
        return (bool) auth()->user()?->canAccessPracticeRoom();
    }

    private function practiceRoomPaymentRequiredResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Please pay for a subscription to access the Practice Room.',
            'subscription_url' => route('subscription.plans'),
        ], 402);
    }
}
