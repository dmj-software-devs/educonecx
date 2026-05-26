<?php

namespace App\Http\Controllers;

use App\Models\AcademyCategory;
use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Services\HeyGenLiveAvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EduconecxAcademyController extends Controller
{
    public function index()
    {
        $categories = AcademyCategory::query()
            ->where('status', 'active')
            ->with(['scenarios' => fn($q) => $q->where('status', 'active')->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('educonecx-academy.index', compact('categories'));
    }

    public function startSession(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $validated = $request->validate([
            'scenario_slug' => ['required', 'string', 'exists:academy_scenarios,slug'],
        ]);

        $scenario = AcademyScenario::with('category')->where('slug', $validated['scenario_slug'])->firstOrFail();

        try {
            $createResponse = $heyGenService->createSession($scenario);
            $heygenSessionId = data_get($createResponse, 'data.session_id')
                ?? data_get($createResponse, 'session_id')
                ?? data_get($createResponse, 'data.id');

            if ($heygenSessionId) {
                $heyGenService->startSession($heygenSessionId);
            }

            $session = AcademySession::create([
                'user_id' => Auth::id(),
                'academy_category_id' => $scenario->academy_category_id,
                'academy_scenario_id' => $scenario->id,
                'heygen_session_id' => $heygenSessionId,
                'status' => 'started',
                'raw_response' => $createResponse,
                'started_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'academy_session_id' => $session->id,
                'heygen_session_id' => $session->heygen_session_id,
                'message' => 'Session created successfully.',
                'data' => [
                    'session' => $createResponse,
                ],
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
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
