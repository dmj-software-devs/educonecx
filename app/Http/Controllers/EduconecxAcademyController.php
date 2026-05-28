<?php

namespace App\Http\Controllers;

use App\Models\AcademyCategory;
use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Services\HeyGenLiveAvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $user = auth()->user();
            $embed = $heyGenService->createLiveAvatarEmbed($scenario, $user);

            return response()->json([
                'success' => true,
                'embed_url' => $embed['embed_url'],
                'embed_script' => $embed['embed_script'],
                'avatar_id' => data_get($embed, 'resolved.avatar_id'),
                'context_id' => data_get($embed, 'resolved.context_id'),
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
