<?php

namespace App\Http\Controllers;

use App\Models\AcademyCategory;
use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Models\AcademyUserAvatarSetting;
use App\Services\HeyGenLiveAvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardEduconecxAcademyController extends Controller
{
    public function index(Request $request, HeyGenLiveAvatarService $liveAvatarService): View
    {
        $user = $request->user();
        $avatarSetting = $this->avatarSetting($user->id);

        $academySessions = AcademySession::with(['category', 'scenario'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $sessionQuery = AcademySession::where('user_id', $user->id);
        $stats = [
            'total_sessions' => (clone $sessionQuery)->count(),
            'average_overall_score' => round((float) ((clone $sessionQuery)->whereNotNull('overall_score')->avg('overall_score') ?? 0), 1),
            'best_score' => round((float) ((clone $sessionQuery)->whereNotNull('overall_score')->max('overall_score') ?? 0), 1),
            'last_practice_date' => optional((clone $sessionQuery)->latest()->first()?->created_at)->format('M d, Y g:i A'),
        ];

        $publicAvatars = $liveAvatarService->listPublicAvatars();
        $customAvatars = $liveAvatarService->listCustomAvatars();
        $avatars = collect(array_merge($publicAvatars, $customAvatars))
            ->unique('id')
            ->values()
            ->all();

        if ($avatars === [] && filled(config('services.heygen.default_avatar_id'))) {
            $avatars[] = [
                'id' => (string) config('services.heygen.default_avatar_id'),
                'name' => 'Default LiveAvatar',
                'image_url' => null,
                'type' => 'env',
            ];
        }

        $contexts = $this->normalizeContexts($liveAvatarService->listContexts());

        $categories = AcademyCategory::query()
            ->where('status', 'active')
            ->with(['scenarios' => fn ($query) => $query->where('status', 'active')->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('dashboard.educonecx-academy.index', compact(
            'academySessions',
            'avatarSetting',
            'avatars',
            'contexts',
            'categories',
            'stats'
        ));
    }

    public function updateAvatarPreference(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'heygen_avatar_id' => ['required', 'string', 'max:255'],
            'avatar_name' => ['nullable', 'string', 'max:255'],
            'avatar_image_url' => ['nullable', 'url', 'max:2000'],
        ]);

        $setting = $this->avatarSetting($request->user()->id);
        $setting->fill([
            'heygen_avatar_id' => $validated['heygen_avatar_id'],
            'avatar_name' => $validated['avatar_name'] ?? $setting->avatar_name,
            'avatar_image_url' => $validated['avatar_image_url'] ?? $setting->avatar_image_url,
            'preferred_language' => $setting->preferred_language ?: 'en',
            'tutor_style' => $setting->tutor_style ?: 'friendly and encouraging',
            'status' => 'active',
        ])->save();

        return back()->with('success', 'Your Academy avatar preference has been saved.');
    }

    public function updateContextPreference(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'heygen_context_id' => ['required', 'string', 'max:255'],
            'context_name' => ['nullable', 'string', 'max:255'],
            'preferred_language' => ['nullable', 'string', 'max:20'],
            'speaking_level' => ['nullable', 'string', 'max:50'],
            'tutor_style' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = $this->avatarSetting($request->user()->id);
        $setting->fill([
            'heygen_context_id' => $validated['heygen_context_id'],
            'context_name' => $validated['context_name'] ?? $setting->context_name,
            'preferred_language' => $validated['preferred_language'] ?? $setting->preferred_language ?? 'en',
            'speaking_level' => $validated['speaking_level'] ?? $setting->speaking_level,
            'tutor_style' => $validated['tutor_style'] ?? $setting->tutor_style ?? 'friendly and encouraging',
            'status' => 'active',
        ])->save();

        return back()->with('success', 'Your Academy context preference has been saved.');
    }

    public function history(Request $request): JsonResponse
    {
        $sessions = AcademySession::with(['category', 'scenario'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $sessions->getCollection()->map(fn (AcademySession $session) => [
                'date' => optional($session->created_at)->format('M d, Y g:i A'),
                'scenario' => $session->scenario->title ?? 'Academy Practice Session',
                'category' => $session->category->title ?? 'No category',
                'avatar' => config('app.debug') ? ($session->heygen_avatar_id ?: 'Default') : 'LiveAvatar',
                'context' => config('app.debug') ? ($session->heygen_context_id ?: 'Default') : 'LiveAvatar',
                'overall' => $this->formatScore($session->overall_score),
                'pronunciation' => $this->formatScore($session->pronunciation_score),
                'grammar' => $this->formatScore($session->grammar_score),
                'fluency' => $this->formatScore($session->fluency_score),
                'vocabulary' => $this->formatScore($session->vocabulary_score),
                'status' => $session->status ?? 'pending',
                'action_url' => route('dashboard.educonecx-academy.sessions.show', $session),
                'start_again_url' => route('educonecx.academy.index'),
            ]),
            'meta' => [
                'current_page' => $sessions->currentPage(),
                'last_page' => $sessions->lastPage(),
                'per_page' => $sessions->perPage(),
                'total' => $sessions->total(),
            ],
        ]);
    }

    public function showSession(Request $request, AcademySession $session): View
    {
        abort_unless((int) $session->user_id === (int) $request->user()->id, 403);

        $session->load(['category', 'scenario']);
        $audioUrl = $session->audio_path ? Storage::disk('public')->url($session->audio_path) : null;

        return view('dashboard.educonecx-academy.show', compact('session', 'audioUrl'));
    }

    private function avatarSetting(int $userId): AcademyUserAvatarSetting
    {
        return AcademyUserAvatarSetting::firstOrCreate(
            ['user_id' => $userId],
            [
                'preferred_language' => 'en',
                'tutor_style' => 'friendly and encouraging',
                'status' => 'active',
            ]
        );
    }

    public function updateScenarioPreference(Request $request): RedirectResponse
    {
        return $this->updateContextPreference($request);
    }

    private function normalizeContexts(array $contexts): array
    {
        $contextCollection = collect($contexts)
            ->filter(fn ($context) => filled($context['id'] ?? null))
            ->map(fn ($context) => [
                'id' => (string) $context['id'],
                'name' => (string) ($context['name'] ?? 'LiveAvatar Context'),
            ]);

        if ($contextCollection->isEmpty() && filled(config('services.heygen.default_context_id'))) {
            $contextCollection->push([
                'id' => (string) config('services.heygen.default_context_id'),
                'name' => 'Default LiveAvatar Context',
            ]);
        }

        return $contextCollection->unique('id')->values()->all();
    }

    private function formatScore($score): string
    {
        return is_null($score) ? 'N/A' : number_format((float) $score, 1) . '/10';
    }
}
