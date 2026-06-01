<?php

namespace App\Http\Controllers;

use App\Models\AcademyCategory;
use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Services\HeyGenLiveAvatarService;
use App\Services\OpenAIEvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EduconecxAcademyController extends Controller
{
    public function index()
    {
        $categories = AcademyCategory::query()
            ->where('status', 'active')
            ->with(['scenarios' => fn($q) => $q->where('status', 'active')->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $missingHeyGenConfig = app(HeyGenLiveAvatarService::class)->getMissingConfigurationKeys();

        return view('educonecx-academy.index', compact('categories', 'missingHeyGenConfig'));
    }

    public function createLiveAvatarToken(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['required', 'string', 'exists:academy_scenarios,slug'],
        ]);

        $scenario = AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail();

        try {
            $user = auth()->user();
            $tokenData = $heyGenService->generateSessionToken($scenario, $user);
            $resolved = $heyGenService->resolveAvatarConfig($scenario, $user);
            $instructions = $heyGenService->buildDynamicInstructions($scenario, $user);

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


    public function createLiveAvatarEmbed(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['required', 'string', 'exists:academy_scenarios,slug'],
        ]);

        $scenario = AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail();

        try {
            $user = $request->user();
            abort_unless($user, 401);

            $embed = $heyGenService->createLiveAvatarEmbed($scenario, $user);
            $embedUrl = $embed['embed_url'];
            $resolved = data_get($embed, 'resolved', []);

            $session = AcademySession::create([
                'user_id' => $user->id,
                'academy_category_id' => $scenario->academy_category_id,
                'academy_scenario_id' => $scenario->id,
                'liveavatar_embed_id' => $this->extractLiveAvatarEmbedId($embedUrl, $embed['response'] ?? []),
                'liveavatar_embed_url' => $embedUrl,
                'heygen_avatar_id' => data_get($resolved, 'avatar_id'),
                'heygen_voice_id' => data_get($resolved, 'voice_id'),
                'heygen_context_id' => data_get($resolved, 'context_id'),
                'dynamic_instructions' => $heyGenService->buildDynamicInstructions($scenario, $user),
                'config_source' => data_get($resolved, 'source'),
                'status' => 'started',
                'started_at' => now(),
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
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'endpoint_url' => 'https://api.liveavatar.com/v2/embeddings',
                'debug' => $heyGenService->apiKeyDebugMeta(),
            ], 422);
        }
    }


    public function evaluateSession(Request $request, OpenAIEvaluationService $service): JsonResponse
    {
        $validated = $request->validate([
            'academy_session_id' => ['nullable', 'integer', 'exists:academy_sessions,id'],
            'transcript' => ['required', 'string', 'min:10'],
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
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
                'message' => $exception->getMessage(),
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
            'scenario_slug' => ['nullable', 'string', 'exists:academy_scenarios,slug'],
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
                'message' => $exception->getMessage(),
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

            return $session;
        }

        if (! empty($validated['scenario_slug'])) {
            $scenario = AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail();

            return AcademySession::create([
                'user_id' => $user->id,
                'academy_category_id' => $scenario->academy_category_id,
                'academy_scenario_id' => $scenario->id,
                'status' => 'evaluating',
                'started_at' => now(),
            ])->load(['scenario.category']);
        }

        throw ValidationException::withMessages([
            'scenario_slug' => 'Please select a scenario before requesting AI feedback.',
        ]);
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
        ], array_filter($extra, fn($value) => $value !== null)));
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
