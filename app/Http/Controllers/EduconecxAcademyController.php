<?php

namespace App\Http\Controllers;

use App\Models\AcademyScenario;
use App\Models\AcademySession;
use App\Models\AcademyUserAvatarSetting;
use App\Models\EnglishPracticeCourse;
use App\Models\EnglishPracticeLesson;
use App\Models\PracticeSessionPackage;
use App\Exceptions\InsufficientPracticeCreditsException;
use App\Services\HeyGenLiveAvatarService;
use App\Services\OpenAIEvaluationService;
use App\Services\PracticeCreditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Validation\ValidationException;

class EduconecxAcademyController extends Controller
{
    public function index(HeyGenLiveAvatarService $heyGenService, PracticeCreditService $creditService): View|Response
    {
        $user = auth()->user();
        $practiceBalance = $creditService->syncMonthlyAllocation($user);
        $canAccessPracticeRoom = $this->currentUserCanAccessPracticeRoom($user, $practiceBalance);
        $isPaidMember = $canAccessPracticeRoom;
        $practiceSessionPackage = PracticeSessionPackage::where('status', 'active')->first();

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
        $currentAvatarConfig['avatar_name'] = $currentAvatarConfig['avatar_name'] ?? data_get($defaultAvatar, 'name', 'Olivia Clarcke');
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
        $examCoachImage = file_exists(public_path('images/academy/olivia.jpg'))
            ? asset('images/academy/olivia.jpg')
            : $practiceCoachImage;
        $recentAcademySessions = auth()->check()
            ? AcademySession::query()
                ->where('user_id', auth()->id())
                ->latest()
                ->limit(5)
                ->get()
            : collect();
        $englishPracticeCourses = $this->englishPracticeCoursesForUser();
        $practiceLessonContext = $this->practiceLessonContext(request()->query('lesson_id'));
        $practiceBalance = $creditService->syncMonthlyAllocation($user);
        $practiceMinutesAvailable = (int) $practiceBalance->computed_available_minutes;
        $practiceSessionsAvailable = intdiv($practiceMinutesAvailable, 30);
        $practiceCreditValue = $creditService->minutesToDollarCredits($practiceMinutesAvailable);
        $practiceCreditValuePerMinute = $creditService->creditValuePerMinute();
        $subscriptionIncludedPracticeCredits = (float) config('practice_room.subscription.included_credit_amount', 4);
        $subscriptionIncludedPracticeMinutes = $creditService->includedSubscriptionMinutes();

        return response()
            ->view('educonecx-academy.index', compact('missingHeyGenConfig', 'avatarSetting', 'currentAvatarConfig', 'introVideoUrl', 'practiceCoachImage', 'examCoachImage', 'recentAcademySessions', 'practiceMinutesAvailable', 'practiceSessionsAvailable', 'practiceCreditValue', 'practiceCreditValuePerMinute', 'subscriptionIncludedPracticeCredits', 'subscriptionIncludedPracticeMinutes', 'practiceBalance', 'practiceSessionPackage', 'isPaidMember', 'canAccessPracticeRoom', 'defaultAvatarDebug', 'englishPracticeCourses', 'practiceLessonContext'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    private function englishPracticeCoursesForUser()
    {
        return EnglishPracticeCourse::query()
            ->with([
                'lessons' => fn ($query) => $query->where('status', 'published')->orderBy('sort_order'),
                'lessons.userProgress',
            ])
            ->withCount(['lessons as published_lessons_count' => fn ($query) => $query->where('status', 'published')])
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get()
            ->map(function (EnglishPracticeCourse $course) {
                $lessons = $course->lessons;
                $completed = $lessons->filter(fn ($lesson) => optional($lesson->userProgress)->is_completed)->count();
                $total = max(1, $lessons->count());
                $lastProgressLesson = $lessons
                    ->filter(fn ($lesson) => optional($lesson->userProgress)->last_watched_at)
                    ->sortByDesc(fn ($lesson) => optional($lesson->userProgress)->last_watched_at)
                    ->first();
                $firstIncomplete = $lessons->first(fn ($lesson) => ! optional($lesson->userProgress)->is_completed);
                $continueLesson = $lastProgressLesson ?: $firstIncomplete ?: $lessons->first();

                $course->user_completed_lessons_count = $completed;
                $course->user_course_progress_percent = (int) round(($completed / $total) * 100);
                $course->user_continue_lesson_id = $continueLesson?->id;
                $course->user_has_progress = $lessons->contains(fn ($lesson) => optional($lesson->userProgress)->watched_seconds > 0);

                return $course;
            });
    }

    private function practiceLessonContext($lessonId): ?EnglishPracticeLesson
    {
        if (! $lessonId) {
            return null;
        }

        return EnglishPracticeLesson::query()
            ->with('course')
            ->whereKey($lessonId)
            ->where('status', 'published')
            ->whereHas('course', fn ($query) => $query->where('status', 'published'))
            ->first();
    }

    public function practiceTimeSummary(Request $request, PracticeCreditService $creditService): JsonResponse
    {
        $user = $request->user();
        abort_unless($user, 401);

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $balance = $creditService->syncMonthlyAllocation($user);

        $practiceMinutesAvailable = (int) $balance->computed_available_minutes;

        return response()->json([
            'success' => true,
            'practice_minutes_available' => $practiceMinutesAvailable,
            'practice_credit_value' => $creditService->minutesToDollarCredits($practiceMinutesAvailable),
            'practice_sessions_available' => intdiv($practiceMinutesAvailable, 30),
            'practice_cost_minutes' => 30,
            'exam_cost_minutes' => 30,
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
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

        $sessionType = $validated['session_type'] ?? 'practice';
        $creditCost = 0;
        $currentBalance = $creditService->remainingMinutes($user);

        if ($currentBalance <= 0) {
            return response()->json([
                'success' => false,
                'type' => 'insufficient_practice_time',
                'message' => 'You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.',
                'balance' => $currentBalance,
                'practice_credit_value' => $creditService->minutesToDollarCredits($currentBalance),
                'required' => 1,
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

            $creditTransaction = null;

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
                'practice_minutes_available' => $creditService->remainingMinutes($user),
                'practice_credit_value' => $creditService->minutesToDollarCredits($creditService->remainingMinutes($user)),
                'max_minutes' => min(30, $currentBalance),
            ]);
        } catch (InsufficientPracticeCreditsException $exception) {
            return response()->json([
                'success' => false,
                'type' => 'insufficient_practice_time',
                'message' => 'You have used all of your available practice sessions. Please purchase additional practice sessions to continue learning with your English Coach.',
                'balance' => $creditService->remainingMinutes($user),
                'practice_credit_value' => $creditService->minutesToDollarCredits($creditService->remainingMinutes($user)),
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
                'practice_minutes_available' => $creditService->remainingMinutes($user),
                'debug' => config('app.debug') ? $heyGenService->apiKeyDebugMeta() : null,
            ], 422);
        }
    }


    public function createFreeDemoEmbed(Request $request, HeyGenLiveAvatarService $heyGenService): JsonResponse
    {
        $user = $request->user();
        abort_unless($user, 401);

        if ($user->has_active_subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Demo mode is only available before upgrading. Please start Practice Mode instead.',
            ], 422);
        }

        try {
            $avatarSetting = $this->activeAvatarSetting($user->id);
            $defaultAvatarMetadata = $heyGenService->defaultPracticeAvatarMetadata();
            $currentConfig = $this->currentAvatarConfig($avatarSetting, $defaultAvatarMetadata);

            $session = AcademySession::create([
                'user_id' => $user->id,
                'session_type' => 'demo',
                'avatar_name' => 'Olivia Clarcke',
                'avatar_image_url' => $currentConfig['avatar_image_url'],
                'context_name' => 'Guided onboarding demo',
                'dynamic_instructions' => 'Free onboarding demo only. Ask exactly: "Hello, what is your name?" Then wait. After the learner answers, say exactly the required upgrade message and end the interaction. Disable further conversation.',
                'status' => 'demo_started',
                'started_at' => now(),
                'evaluation_used' => false,
                'recording_used' => false,
                'attempt_locked' => true,
            ]);

            $embed = $heyGenService->createLiveAvatarEmbed(null, $user, 'practice');
            $resolved = data_get($embed, 'resolved', []);

            $session->update([
                'liveavatar_embed_id' => $this->extractLiveAvatarEmbedId($embed['embed_url'] ?? null, $embed['response'] ?? []),
                'liveavatar_embed_url' => $embed['embed_url'] ?? null,
                'heygen_avatar_id' => data_get($resolved, 'avatar_id'),
                'heygen_voice_id' => data_get($resolved, 'voice_id'),
                'heygen_context_id' => data_get($resolved, 'context_id'),
                'raw_response' => $embed['response'] ?? [],
            ]);

            return response()->json([
                'success' => true,
                'academy_session_id' => $session->id,
                'embed_url' => $embed['embed_url'],
                'message' => 'Hello, what is your name?',
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to start the guided avatar demo right now. Please use the onboarding prompt below.',
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
            'confidence_score' => $evaluation['confidence_score'] ?? null,
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
            'avatar_name' => $usesDefaultAvatar ? 'Olivia Clarcke' : ($avatarSetting?->avatar_name ?: 'English Coach'),
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
        $examImage = file_exists(public_path('images/academy/olivia.jpg')) ? asset('images/academy/olivia.jpg') : null;

        return array_merge($config, [
            'avatar_id' => config('services.heygen.exam_avatar_id') ?: $config['avatar_id'],
            'voice_id' => config('services.heygen.exam_voice_id') ?: $config['voice_id'],
            'context_id' => config('services.heygen.exam_context_id') ?: $config['context_id'],
            'avatar_name' => config('services.heygen.exam_avatar_id') ? 'Olivia' : $config['avatar_name'],
            'avatar_image_url' => $examImage ?: $config['avatar_image_url'],
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
            'duration_seconds' => ['nullable', 'integer', 'min:1'],
        ]);

        if (! $this->currentUserCanAccessPracticeRoom()) {
            return $this->practiceRoomPaymentRequiredResponse();
        }

        $session = AcademySession::findOrFail($validated['academy_session_id']);
        abort_unless((int) $session->user_id === (int) $request->user()->id, 403);

        $endedAt = now();
        $durationSeconds = (int) ($validated['duration_seconds'] ?? ($session->started_at ? $session->started_at->diffInSeconds($endedAt) : 60));
        $minutesUsed = max(1, (int) ceil($durationSeconds / 60));

        $session->update([
            'score' => $validated['score'] ?? $session->score,
            'feedback' => $validated['feedback'] ?? $session->feedback,
            'transcript' => $validated['transcript'] ?? $session->transcript,
            'status' => $validated['status'] ?? 'ended',
            'ended_at' => $endedAt,
        ]);

        app(PracticeCreditService::class)->recordUsageMinutes($request->user(), $session, $minutesUsed, $session->session_type ?: 'practice');
        $remaining = app(PracticeCreditService::class)->remainingMinutes($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Session ended successfully.',
            'practice_minutes_available' => $remaining,
            'practice_credit_value' => app(PracticeCreditService::class)->minutesToDollarCredits($remaining),
        ]);
    }

    public function purchaseSessions(Request $request): JsonResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:50']]);
        $package = PracticeSessionPackage::where('status', 'active')->firstOrFail();
        $quantity = (int) $validated['quantity'];
        $user = $request->user();
        $total = (float) $package->price * $quantity;

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $checkout = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'customer_email' => $user->email,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) round($package->price * 100),
                        'product_data' => ['name' => $package->name],
                    ],
                    'quantity' => $quantity,
                ]],
                'success_url' => route('educonecx.academy.practice-sessions.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('educonecx.academy.index'),
                'metadata' => ['type' => 'practice_sessions', 'user_id' => $user->id, 'package_id' => $package->id, 'quantity' => $quantity, 'minutes' => $package->minutes * $quantity],
            ]);

            return response()->json(['success' => true, 'checkout_url' => $checkout->url]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Unable to start practice session checkout.'], 422);
        }
    }

    public function purchaseSessionsSuccess(Request $request, PracticeCreditService $creditService)
    {
        $sessionId = $request->query('session_id');
        abort_if(blank($sessionId), 404);
        Stripe::setApiKey(config('services.stripe.secret'));
        $checkout = Session::retrieve($sessionId);
        abort_unless((int) data_get($checkout, 'metadata.user_id') === (int) $request->user()->id, 403);

        $creditService->processPracticeSessionCheckout($checkout, $request->user());

        return redirect()->route('educonecx.academy.index')->with('success', 'Practice sessions purchased successfully.');
    }

    private function currentUserCanAccessPracticeRoom($user = null, $practiceBalance = null): bool
    {
        $user ??= auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->has_active_subscription) {
            return true;
        }

        $practiceBalance ??= app(PracticeCreditService::class)->syncMonthlyAllocation($user);

        if ((int) ($practiceBalance?->computed_available_minutes ?? 0) > 0) {
            return true;
        }

        return $user->canAccessPracticeRoom();
    }

    private function practiceRoomPaymentRequiredResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Upgrade your membership to unlock full access and start practicing with your English Coach.',
            'subscription_url' => route('subscription.plans'),
        ], 402);
    }
}
