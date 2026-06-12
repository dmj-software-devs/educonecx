<?php

namespace App\Http\Controllers;

use App\Models\AcademySession;
use App\Models\AcademyUserAvatarSetting;
use App\Services\HeyGenLiveAvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardEduconecxAcademyController extends Controller
{
    public function index(Request $request, HeyGenLiveAvatarService $liveAvatarService): View|JsonResponse
    {
        $user = $request->user();

        if (! $user->canAccessPracticeRoom()) {
            return view('educonecx-academy.paywall');
        }

        $avatarSetting = $this->avatarSetting($user->id);

        $academySessions = AcademySession::with(['category', 'scenario'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $sessionQuery = AcademySession::where('user_id', $user->id);
        $allSessions = (clone $sessionQuery)->latest()->get();
        $totalSpeakingSeconds = $allSessions->sum(function (AcademySession $session) {
            if ($session->started_at && $session->ended_at) {
                return $session->started_at->diffInSeconds($session->ended_at);
            }

            return 0;
        });
        $stats = [
            'total_sessions' => (clone $sessionQuery)->count(),
            'average_overall_score' => round((float) ((clone $sessionQuery)->whereNotNull('overall_score')->avg('overall_score') ?? 0), 1),
            'average_pronunciation_score' => round((float) ((clone $sessionQuery)->whereNotNull('pronunciation_score')->avg('pronunciation_score') ?? 0), 1),
            'average_fluency_score' => round((float) ((clone $sessionQuery)->whereNotNull('fluency_score')->avg('fluency_score') ?? 0), 1),
            'average_grammar_score' => round((float) ((clone $sessionQuery)->whereNotNull('grammar_score')->avg('grammar_score') ?? 0), 1),
            'average_vocabulary_score' => round((float) ((clone $sessionQuery)->whereNotNull('vocabulary_score')->avg('vocabulary_score') ?? 0), 1),
            'best_score' => round((float) ((clone $sessionQuery)->whereNotNull('overall_score')->max('overall_score') ?? 0), 1),
            'last_practice_date' => optional((clone $sessionQuery)->latest()->first()?->created_at)->format('M d, Y g:i A'),
            'total_speaking_time' => $totalSpeakingSeconds > 0 ? gmdate($totalSpeakingSeconds >= 3600 ? 'H\h i\m' : 'i\m s\s', $totalSpeakingSeconds) : '0m',
            'practice_streak' => $this->practiceStreak($allSessions),
            'current_level' => $this->currentLevel(round((float) ((clone $sessionQuery)->whereNotNull('overall_score')->avg('overall_score') ?? 0), 1)),
            'improvement_percentage' => $this->improvementPercentage($allSessions),
        ];

        $chartData = [
            'score_trend' => $allSessions->whereNotNull('overall_score')->take(8)->reverse()->values()->map(fn (AcademySession $session) => [
                'label' => optional($session->created_at)->format('M d'),
                'score' => round((float) $session->overall_score, 1),
            ])->all(),
            'monthly_progress' => $allSessions->whereNotNull('overall_score')->groupBy(fn (AcademySession $session) => optional($session->created_at)->format('M'))->map(fn ($sessions, $month) => [
                'label' => $month,
                'score' => round((float) $sessions->avg('overall_score'), 1),
            ])->values()->take(6)->all(),
            'recent_performance' => [
                ['label' => 'Pronunciation', 'score' => $stats['average_pronunciation_score']],
                ['label' => 'Fluency', 'score' => $stats['average_fluency_score']],
                ['label' => 'Grammar', 'score' => $stats['average_grammar_score']],
                ['label' => 'Vocabulary', 'score' => $stats['average_vocabulary_score']],
            ],
        ];

        $publicAvatars = $liveAvatarService->listPublicAvatars();
        $customAvatars = $liveAvatarService->listCustomAvatars();
        $avatars = collect(array_merge($publicAvatars, $customAvatars))
            ->unique('id')
            ->values()
            ->all();

        $defaultAvatarMetadata = $liveAvatarService->defaultPracticeAvatarMetadata();
        if (! collect($avatars)->contains(fn (array $avatar) => (string) ($avatar['id'] ?? '') === (string) $defaultAvatarMetadata['id'])) {
            $avatars[] = $defaultAvatarMetadata;
        }

        $contexts = $this->normalizeContexts($liveAvatarService->listContexts());
        $languageLearningContext = collect($contexts)->first(function (array $context) {
            return strcasecmp((string) ($context['name'] ?? ''), 'Language Learning') === 0;
        });

        if (blank($avatarSetting->heygen_context_id) && $languageLearningContext) {
            $avatarSetting->fill([
                'heygen_context_id' => $languageLearningContext['id'],
                'context_name' => $languageLearningContext['name'],
                'preferred_language' => $avatarSetting->preferred_language ?: 'en',
                'tutor_style' => $avatarSetting->tutor_style ?: 'friendly and encouraging',
                'status' => 'active',
            ])->save();
        }

        if ($contexts === [] && filled(config('services.heygen.default_context_id'))) {
            $contexts[] = [
                'id' => (string) config('services.heygen.default_context_id'),
                'name' => 'English Speaking Practice',
            ];
        }

        $voices = $liveAvatarService->listVoices();
        $liveAvatarDebug = $liveAvatarService->getLiveAvatarListingDebug();

        if (app()->environment('local') && $request->boolean('liveavatar_debug')) {
            return response()->json([
                'avatars_raw' => collect($liveAvatarDebug)
                    ->filter(fn ($debug) => ($debug['type'] ?? null) === 'avatars')
                    ->map(fn ($debug) => [
                        'endpoint_url' => $debug['endpoint_url'] ?? null,
                        'status' => $debug['status'] ?? null,
                        'headers' => $debug['headers'] ?? [],
                        'body' => $debug['raw'] ?? null,
                        'count' => $debug['count'] ?? 0,
                        'error' => $debug['error'] ?? null,
                        'first_raw_item_keys' => $debug['first_raw_item_keys'] ?? [],
                        'first_raw_item' => $debug['first_raw_item'] ?? null,
                    ])
                    ->values(),
                'contexts_raw' => collect($liveAvatarDebug)
                    ->filter(fn ($debug) => ($debug['type'] ?? null) === 'contexts')
                    ->map(fn ($debug) => [
                        'endpoint_url' => $debug['endpoint_url'] ?? null,
                        'status' => $debug['status'] ?? null,
                        'headers' => $debug['headers'] ?? [],
                        'body' => $debug['raw'] ?? null,
                        'count' => $debug['count'] ?? 0,
                        'error' => $debug['error'] ?? null,
                        'first_raw_item_keys' => $debug['first_raw_item_keys'] ?? [],
                        'first_raw_item' => $debug['first_raw_item'] ?? null,
                    ])
                    ->values(),
                'voices_raw' => collect($liveAvatarDebug)
                    ->filter(fn ($debug) => ($debug['type'] ?? null) === 'voices')
                    ->map(fn ($debug) => [
                        'endpoint_url' => $debug['endpoint_url'] ?? null,
                        'status' => $debug['status'] ?? null,
                        'headers' => $debug['headers'] ?? [],
                        'body' => $debug['raw'] ?? null,
                        'count' => $debug['count'] ?? 0,
                        'error' => $debug['error'] ?? null,
                        'first_raw_item_keys' => $debug['first_raw_item_keys'] ?? [],
                        'first_raw_item' => $debug['first_raw_item'] ?? null,
                    ])
                    ->values(),
                'avatar_count_loaded' => count($avatars),
                'context_count_loaded' => count($contexts),
                'voice_count_loaded' => count($voices),
            ]);
        }


        return view('dashboard.educonecx-academy.index', compact(
            'academySessions',
            'avatarSetting',
            'avatars',
            'contexts',
            'stats',
            'liveAvatarDebug',
            'chartData'
        ));
    }

    public function updateAvatarPreference(Request $request): RedirectResponse
    {
        if (! $request->user()->canAccessPracticeRoom()) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Please pay for a subscription to access the Practice Room.');
        }

        $validated = $request->validate([
            'avatar_id' => ['nullable', 'string', 'max:255'],
            'heygen_avatar_id' => ['nullable', 'string', 'max:255'],
            'avatar_name' => ['nullable', 'string', 'max:255'],
            'avatar_image_url' => ['nullable', 'url', 'max:2000'],
            'default_voice_id' => ['nullable', 'string', 'max:255'],
            'default_voice_name' => ['nullable', 'string', 'max:255'],
        ]);

        $avatarId = $validated['avatar_id'] ?? $validated['heygen_avatar_id'] ?? null;
        abort_if(blank($avatarId), 422, 'Please select an English Coach.');

        $setting = $this->avatarSetting($request->user()->id);
        $payload = [
            'heygen_avatar_id' => $avatarId,
            'heygen_voice_id' => $validated['default_voice_id'] ?? $setting->heygen_voice_id,
            'avatar_name' => $validated['avatar_name'] ?? $setting->avatar_name,
            'avatar_image_url' => $validated['avatar_image_url'] ?? $setting->avatar_image_url,
            'preferred_language' => $setting->preferred_language ?: 'en',
            'tutor_style' => $setting->tutor_style ?: 'friendly and encouraging',
            'status' => 'active',
        ];

        if (Schema::hasColumn('academy_user_avatar_settings', 'voice_name')) {
            $payload['voice_name'] = $validated['default_voice_name'] ?? $setting->voice_name;
        }

        $setting->fill($payload)->save();

        return back()->with('success', 'Your English Coach preference has been saved.');
    }

    public function updateContextPreference(Request $request): RedirectResponse
    {
        if (! $request->user()->canAccessPracticeRoom()) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Please pay for a subscription to access the Practice Room.');
        }

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

        return back()->with('success', 'Your conversation scenario preference has been saved.');
    }

    public function history(Request $request): JsonResponse
    {
        if (! $request->user()->canAccessPracticeRoom()) {
            return response()->json([
                'success' => false,
                'message' => 'Please pay for a subscription to access the Practice Room.',
                'subscription_url' => route('subscription.plans'),
            ], 402);
        }

        $sessions = AcademySession::with(['category', 'scenario'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $sessions->getCollection()->map(fn (AcademySession $session) => [
                'date' => optional($session->created_at)->format('M d, Y g:i A'),
                'scenario' => $session->scenario->title ?? 'Daily Conversation',
                'category' => $session->category->title ?? 'No category',
                'coach' => ($session->session_type ?? 'practice') === 'exam' ? 'Olivia' : 'Victoria Clarke',
                'coach_title' => ($session->session_type ?? 'practice') === 'exam' ? 'Assessment Supervisor' : 'English Coach',
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
        if (! $request->user()->canAccessPracticeRoom()) {
            return view('educonecx-academy.paywall');
        }

        abort_unless((int) $session->user_id === (int) $request->user()->id, 403);

        $session->load(['category', 'scenario']);
        $audioUrl = $session->audio_path ? Storage::disk('public')->url($session->audio_path) : null;

        return view('dashboard.educonecx-academy.show', compact('session', 'audioUrl'));
    }


    private function practiceStreak($sessions): int
    {
        $dates = $sessions->pluck('created_at')
            ->filter()
            ->map(fn ($date) => $date->toDateString())
            ->unique()
            ->values();

        $streak = 0;
        $cursor = now()->toDateString();

        while ($dates->contains($cursor)) {
            $streak++;
            $cursor = \Illuminate\Support\Carbon::parse($cursor)->subDay()->toDateString();
        }

        return $streak;
    }

    private function currentLevel(float $averageScore): string
    {
        return match (true) {
            $averageScore >= 8.5 => 'Advanced',
            $averageScore >= 7 => 'Upper Intermediate',
            $averageScore >= 5 => 'Intermediate',
            $averageScore > 0 => 'Foundation',
            default => 'Not started',
        };
    }

    private function improvementPercentage($sessions): int
    {
        $scored = $sessions->whereNotNull('overall_score')->sortBy('created_at')->values();

        if ($scored->count() < 2) {
            return 0;
        }

        $first = (float) $scored->first()->overall_score;
        $latest = (float) $scored->last()->overall_score;

        return $first > 0 ? (int) round((($latest - $first) / $first) * 100) : 0;
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
        if (! $request->user()->canAccessPracticeRoom()) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Please pay for a subscription to access the Practice Room.');
        }

        return $this->updateContextPreference($request);
    }

    private function normalizeContexts(array $contexts): array
    {
        $contextCollection = collect($contexts)
            ->filter(fn ($context) => filled($context['id'] ?? null))
            ->map(fn ($context) => [
                'id' => (string) $context['id'],
                'name' => (string) ($context['name'] ?? 'English Speaking Practice'),
            ]);

        return $contextCollection->unique('id')->values()->all();
    }

    private function formatScore($score): string
    {
        return is_null($score) ? 'N/A' : number_format((float) $score, 1) . '/10';
    }
}
