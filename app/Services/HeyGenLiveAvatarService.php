<?php

namespace App\Services;

use App\Models\AcademyScenario;
use App\Models\AcademyUserAvatarSetting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeyGenLiveAvatarService
{
    private const FALLBACK_PRACTICE_AVATAR_ID = '513fd1b7-7ef9-466d-9af2-344e51eeb833';

    private array $lastListingDebug = [];

    public function defaultPracticeAvatarId(): string
    {
        $configured = (string) config('services.heygen.default_avatar_id');

        return filled($configured) ? $configured : self::FALLBACK_PRACTICE_AVATAR_ID;
    }

    public function getMissingConfigurationKeys(): array
    {
        $liveAvatarKey = $this->normalizeApiKey((string) config('services.heygen.liveavatar_api_key'));
        $heygenKey = $this->normalizeApiKey((string) config('services.heygen.api_key'));

        if ($liveAvatarKey === '' && $heygenKey === '') {
            return ['api_key'];
        }

        return [];
    }

    public function resolveAvatarConfig(?AcademyScenario $scenario = null, ?User $user = null, string $sessionType = 'practice'): array
    {
        $userSetting = null;
        if ($user) {
            $userSetting = AcademyUserAvatarSetting::query()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        }

        $isExam = $sessionType === 'exam';

        $defaultAvatarId = $this->defaultPracticeAvatarId();
        $avatarCandidates = [
            'exam_env' => $isExam ? config('services.heygen.exam_avatar_id') : null,
            'user' => $userSetting?->heygen_avatar_id,
            'scenario' => $scenario?->heygen_avatar_id,
            'default' => $defaultAvatarId,
        ];
        $avatarSource = collect($avatarCandidates)->filter(fn ($value) => filled($value))->keys()->first() ?? 'none';
        $avatarId = collect($avatarCandidates)->first(fn ($value) => filled($value));

        $avatarMetadata = null;
        if (! $isExam) {
            $avatarMetadata = $this->resolveAvatarMetadata($avatarId);
            if (filled($avatarId) && $avatarId !== $defaultAvatarId && $avatarMetadata === null && $this->hasAvatarListingData()) {
                $avatarId = $defaultAvatarId;
                $avatarSource = 'default_unresolved_selection';
                $avatarMetadata = $this->resolveAvatarMetadata($avatarId);
            }
        }

        $voiceCandidates = [
            'exam_env' => $isExam ? config('services.heygen.exam_voice_id') : null,
            'user' => $userSetting?->heygen_voice_id,
            'scenario' => $scenario?->heygen_voice_id,
            'env' => config('services.heygen.default_voice_id'),
            'avatar_metadata' => data_get($avatarMetadata, 'default_voice_id'),
        ];
        $voiceSource = collect($voiceCandidates)->filter(fn ($value) => filled($value))->keys()->first() ?? 'none';
        $voiceId = collect($voiceCandidates)->first(fn ($value) => filled($value));

        $contextCandidates = [
            'exam_env' => $isExam ? config('services.heygen.exam_context_id') : null,
            'user' => $userSetting?->heygen_context_id,
            'env' => config('services.heygen.default_context_id'),
        ];
        $contextSource = collect($contextCandidates)->filter(fn ($value) => filled($value))->keys()->first() ?? 'none';
        $contextId = collect($contextCandidates)->first(fn ($value) => filled($value));

        return [
            'avatar_id' => $avatarId,
            'voice_id' => $voiceId,
            'context_id' => $contextId,
            'avatar_metadata' => $avatarMetadata,
            'source' => [
                'avatar_id' => $avatarSource,
                'voice_id' => $voiceSource,
                'context_id' => $contextSource,
            ],
        ];
    }

    public function buildDynamicInstructions(?AcademyScenario $scenario = null, ?User $user = null, string $sessionType = 'practice'): string
    {
        $userSetting = null;
        if ($user) {
            $userSetting = AcademyUserAvatarSetting::query()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        }

        $speakingLevel = $userSetting?->speaking_level ?? $scenario?->level ?? 'Beginner';
        $preferredLanguage = $userSetting?->preferred_language ?? 'English';
        $tutorStyle = $userSetting?->tutor_style ?? 'friendly and encouraging';
        $isExam = $sessionType === 'exam';
        $sampleQuestions = is_array($scenario?->sample_questions) ? implode('; ', $scenario->sample_questions) : 'Ask natural follow-up questions for the selected speaking focus.';
        $categoryTitle = $scenario?->category?->title ?? ($isExam ? 'English Speaking Exam' : 'English Practice');
        $scenarioTitle = $scenario?->title ?? ($userSetting?->context_name ?: ($isExam ? 'formal speaking assessment' : 'speaking practice'));
        $scenarioLevel = $scenario?->level ?? $speakingLevel;
        $scenarioDescription = $scenario?->description ?? ($isExam ? 'Conduct a formal English speaking assessment.' : 'Practice a natural English conversation.');
        $practiceText = $scenario?->practice_text ?? ($isExam ? 'Ask clear assessment questions and keep a formal tone.' : 'Guide a realistic English conversation.');

        return "You are an English speaking practice tutor inside EDUCONECX Academy.\n\n"
            . "Learner information:\n"
            . "- Speaking level: {$speakingLevel}\n"
            . "- Preferred language: {$preferredLanguage}\n"
            . "- Tutor style: {$tutorStyle}\n\n"
            . "Selected practice:\n"
            . "- Category: {$categoryTitle}\n"
            . "- Scenario/context: {$scenarioTitle}\n"
            . "- Level: {$scenarioLevel}\n"
            . "- Description: {$scenarioDescription}\n"
            . "- Practice text: {$practiceText}\n"
            . "- Sample questions: {$sampleQuestions}\n\n"
            . "Your behavior:\n"
            . "- greet the learner warmly\n"
            . "- explain the scenario briefly\n"
            . "- ask one question at a time\n"
            . "- wait for the learner response\n"
            . "- correct grammar gently\n"
            . "- improve vocabulary naturally\n"
            . "- encourage the learner\n"
            . "- keep responses short and simple\n"
            . "- adapt to the learner level\n"
            . "- do not overwhelm the learner\n"
            . "- at the end, provide short feedback and a score out of 10.";
    }

    public function generateSessionToken(?AcademyScenario $scenario = null, ?User $user = null, string $sessionType = 'practice'): array
    {
        $url = 'https://api.liveavatar.com/v1/sessions/token';
        $apiKey = $this->apiKey();

        $resolved = $this->resolveAvatarConfig($scenario, $user, $sessionType);
        $instructions = $this->buildDynamicInstructions($scenario, $user, $sessionType);

        $tokenPayload = [
            'mode' => 'FULL',
            'avatar_id' => $resolved['avatar_id'],
            'avatar_persona' => [
                'name' => 'EDUCONECX Academy Tutor',
                'role' => 'English speaking practice tutor',
                'description' => $instructions,
                'personality' => 'Friendly, patient, encouraging, and clear',
                'instructions' => $instructions,
            ],
        ];

        Log::debug('LiveAvatar token payload prepared', [
            'mode' => $tokenPayload['mode'],
            'avatar_id' => $tokenPayload['avatar_id'],
            'avatar_persona_type' => gettype($tokenPayload['avatar_persona']),
            'avatar_persona_keys' => array_keys($tokenPayload['avatar_persona']),
        ]);

        $primaryResponse = Http::withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.liveavatar.com/v1/sessions/token', $tokenPayload);

        Log::debug('LiveAvatar token endpoint response', [
            'endpoint_url' => $url,
            'auth_strategy' => 'X-Api-Key',
            'status' => $primaryResponse->status(),
            'request_payload' => $tokenPayload,
            'body' => $primaryResponse->json() ?? $primaryResponse->body(),
        ]);

        $response = $primaryResponse;

        if (in_array($primaryResponse->status(), [401, 403], true)) {
            $secondaryResponse = Http::withHeaders([
                    'X-API-KEY' => $apiKey,
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.liveavatar.com/v1/sessions/token', $tokenPayload);

            Log::debug('LiveAvatar token endpoint response', [
                'endpoint_url' => $url,
                'auth_strategy' => 'X-Api-Key + Bearer',
                'status' => $secondaryResponse->status(),
                'request_payload' => $tokenPayload,
                'body' => $secondaryResponse->json() ?? $secondaryResponse->body(),
            ]);

            if ($secondaryResponse->successful()) {
                $response = $secondaryResponse;
            }
        }

        if ($response->failed()) {
            $message = $this->extractProviderError($response);
            if (in_array($response->status(), [401, 403], true)) {
                $message = 'Invalid API key';
            }
            throw new \RuntimeException($message);
        }

        $token = data_get($response->json(), 'data.token')
            ?? data_get($response->json(), 'token')
            ?? data_get($response->json(), 'data.session_token');

        if (blank($token)) {
            throw new \RuntimeException('LiveAvatar token endpoint did not return a token.');
        }

        return [
            'token' => $token,
            'status' => $response->status(),
            'endpoint_url' => $url,
            'body' => $response->json() ?? [],
        ];
    }


    public function createLiveAvatarEmbed(?AcademyScenario $scenario = null, ?User $user = null, string $sessionType = 'practice'): array
    {
        $resolved = $this->resolveAvatarConfig($scenario, $user, $sessionType);

        if (empty($resolved['avatar_id'])) {
            throw new \RuntimeException('LiveAvatar avatar_id is missing.');
        }

        if (empty($resolved['context_id'])) {
            throw new \RuntimeException('LiveAvatar context_id is missing. Please select a LiveAvatar context from your EDUCONECX Academy dashboard or set HEYGEN_DEFAULT_CONTEXT_ID in .env.');
        }

        $url = 'https://api.liveavatar.com/v2/embeddings';
        $payload = [
            'avatar_id' => $resolved['avatar_id'],
            'context_id' => $resolved['context_id'],
            'is_sandbox' => false,
            'orientation' => 'horizontal',
        ];

        Log::debug('LiveAvatar embed payload prepared', [
            'avatar_id' => $payload['avatar_id'],
            'context_id' => $payload['context_id'],
            'is_sandbox' => $payload['is_sandbox'],
            'orientation' => $payload['orientation'],
        ]);

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey(),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        Log::debug('LiveAvatar embed endpoint response', [
            'endpoint_url' => $url,
            'status' => $response->status(),
            'body' => $response->json() ?? $response->body(),
        ]);

        if ($response->failed()) {
            throw new \RuntimeException($this->extractProviderError($response));
        }

        return [
            'embed_url' => data_get($response->json(), 'data.url'),
            'embed_script' => data_get($response->json(), 'data.script'),
            'status' => $response->status(),
            'endpoint_url' => $url,
            'response' => $response->json() ?? [],
            'resolved' => $resolved,
        ];
    }


    public function resolveAvatarMetadata(?string $avatarId): ?array
    {
        if (blank($avatarId)) {
            return null;
        }

        $avatarId = (string) $avatarId;
        $publicAvatar = $this->findPublicAvatarById($avatarId);
        if ($publicAvatar !== null) {
            return $publicAvatar;
        }

        return collect($this->listCustomAvatars())->first(fn (array $avatar) => (string) ($avatar['id'] ?? '') === $avatarId) ?: null;
    }

    public function findPublicAvatarById(string $avatarId): ?array
    {
        $avatarId = trim($avatarId);
        if ($avatarId === '') {
            return null;
        }

        return Cache::remember("liveavatar.public_avatar.{$avatarId}", now()->addMinutes(10), function () use ($avatarId) {
            return collect($this->listPublicAvatars())->first(fn (array $avatar) => (string) ($avatar['id'] ?? '') === $avatarId) ?: null;
        });
    }

    public function defaultPracticeAvatarMetadata(): array
    {
        $avatarId = $this->defaultPracticeAvatarId();
        $metadata = $this->resolveAvatarMetadata($avatarId) ?? [];

        return array_merge([
            'id' => $avatarId,
            'name' => 'Victoria Clarke',
            'image_url' => null,
            'default_voice_id' => null,
            'default_voice_name' => null,
            'type' => 'default practice',
        ], $metadata, [
            'id' => $avatarId,
        ]);
    }

    private function hasAvatarListingData(): bool
    {
        return collect($this->lastListingDebug)
            ->filter(fn ($debug) => ($debug['type'] ?? null) === 'avatars')
            ->contains(fn ($debug) => (int) ($debug['count'] ?? 0) > 0);
    }

    public function getLiveAvatarListingDebug(): array
    {
        return $this->lastListingDebug;
    }

    public function listPublicAvatars(): array
    {
        return $this->listLiveAvatarResources(
            endpoint: 'https://api.liveavatar.com/v1/avatars/public',
            type: 'avatars',
            normalizer: fn (array $item) => $this->normalizeAvatarResource($item, 'public')
        );
    }

    public function listCustomAvatars(): array
    {
        return $this->listLiveAvatarResources(
            endpoint: 'https://api.liveavatar.com/v1/avatars',
            type: 'avatars',
            normalizer: fn (array $item) => $this->normalizeAvatarResource($item, 'custom')
        );
    }

    public function listContexts(): array
    {
        return $this->listLiveAvatarResources(
            endpoint: 'https://api.liveavatar.com/v1/contexts',
            type: 'contexts',
            normalizer: fn (array $item) => $this->normalizeContextResource($item)
        );
    }

    public function listVoices(): array
    {
        return $this->listLiveAvatarResources(
            endpoint: 'https://api.liveavatar.com/v1/voices',
            type: 'voices',
            normalizer: fn (array $item) => $this->normalizeVoiceResource($item)
        );
    }

    protected function listLiveAvatarResources(string $endpoint, string $type, callable $normalizer): array
    {
        $apiKey = $this->listingApiKey();

        if ($apiKey === '') {
            $this->recordListingDebug($endpoint, $type, null, [], 'Missing LIVEAVATAR_API_KEY.');

            Log::error('LiveAvatar listing skipped because LIVEAVATAR_API_KEY is missing', [
                'endpoint_url' => $endpoint,
                'type' => $type,
            ]);

            return [];
        }

        $allItems = [];
        $nextEndpoint = $endpoint;
        $lastStatus = null;
        $lastHeaders = [];
        $lastRawBody = null;
        $firstRawItem = null;
        $pageCount = 0;

        while ($nextEndpoint !== null && $pageCount < 10) {
            $pageCount++;

            try {
                $response = Http::withHeaders([
                    'X-API-KEY' => $apiKey,
                    'Accept' => 'application/json',
                ])->timeout(20)->get($nextEndpoint);
            } catch (\Throwable $exception) {
                $this->recordListingDebug($endpoint, $type, null, [], $exception->getMessage());

                Log::error('LiveAvatar listing request failed', [
                    'endpoint_url' => $nextEndpoint,
                    'type' => $type,
                    'exception' => $exception->getMessage(),
                ]);

                break;
            }

            $rawJson = $response->json();
            $rawBody = $rawJson ?? $response->body();
            $lastStatus = $response->status();
            $lastHeaders = $response->headers();
            $lastRawBody = $rawBody;

            Log::info('LiveAvatar listing response received', [
                'endpoint_url' => $nextEndpoint,
                'type' => $type,
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $rawBody,
            ]);

            if ($response->failed()) {
                Log::error('LiveAvatar listing returned an error', [
                    'endpoint_url' => $nextEndpoint,
                    'type' => $type,
                    'status' => $response->status(),
                    'headers' => $response->headers(),
                    'body' => $rawBody,
                    'provider_message' => $this->extractProviderError($response),
                ]);

                break;
            }

            $items = $this->extractLiveAvatarItems(is_array($rawJson) ? $rawJson : [], $type);
            $allItems = array_merge($allItems, $items);
            $firstRawItem ??= $items[0] ?? null;
            $nextEndpoint = $this->extractNextPageUrl(is_array($rawJson) ? $rawJson : [], $nextEndpoint);
        }

        $this->recordListingDebug($endpoint, $type, $lastStatus, $lastHeaders, null, $lastRawBody);

        $normalized = collect($allItems)
            ->filter(fn ($item) => is_array($item))
            ->map(fn ($item) => $normalizer($item))
            ->filter(fn ($item) => filled($item['id'] ?? null))
            ->unique('id')
            ->values()
            ->all();

        $this->lastListingDebug[$endpoint]['count'] = count($normalized);
        $this->lastListingDebug[$endpoint]['pages_loaded'] = $pageCount;
        $this->lastListingDebug[$endpoint]['first_raw_item'] = $firstRawItem;
        $this->lastListingDebug[$endpoint]['first_raw_item_keys'] = is_array($firstRawItem) ? array_keys($firstRawItem) : [];

        return $normalized;
    }

    protected function extractNextPageUrl(array $response, string $currentEndpoint): ?string
    {
        $next = data_get($response, 'next')
            ?? data_get($response, 'next_page')
            ?? data_get($response, 'next_page_url')
            ?? data_get($response, 'links.next')
            ?? data_get($response, 'pagination.next')
            ?? data_get($response, 'pagination.next_url')
            ?? data_get($response, 'data.next')
            ?? data_get($response, 'data.next_page')
            ?? data_get($response, 'data.next_page_url')
            ?? data_get($response, 'data.links.next')
            ?? data_get($response, 'data.pagination.next')
            ?? data_get($response, 'data.pagination.next_url');

        if (! is_string($next) || trim($next) === '') {
            return null;
        }

        $next = trim($next);
        if (str_starts_with($next, 'http://') || str_starts_with($next, 'https://')) {
            return $next === $currentEndpoint ? null : $next;
        }

        $baseUrl = parse_url($currentEndpoint, PHP_URL_SCHEME) . '://' . parse_url($currentEndpoint, PHP_URL_HOST);
        $path = str_starts_with($next, '/') ? $next : '/' . ltrim($next, '/');
        $nextUrl = $baseUrl . $path;

        return $nextUrl === $currentEndpoint ? null : $nextUrl;
    }

    protected function extractLiveAvatarItems(array $response, string $type): array
    {
        $candidatePaths = [
            'data',
            $type,
            'items',
            'results',
            'records',
            'data.items',
            'data.results',
            'data.records',
            'data.' . $type,
            'data.avatars',
            'data.contexts',
            'data.voices',
            'avatars',
            'contexts',
            'voices',
        ];

        foreach ($candidatePaths as $path) {
            $candidate = data_get($response, $path);
            if (is_array($candidate) && $this->isListOfArrays($candidate)) {
                return $candidate;
            }
        }

        if ($this->isListOfArrays($response)) {
            return $response;
        }

        return $this->firstListOfArrays($response) ?? [];
    }

    protected function isListOfArrays(array $value): bool
    {
        return array_is_list($value) && $value !== [] && collect($value)->every(fn ($item) => is_array($item));
    }

    protected function firstListOfArrays(array $value): ?array
    {
        foreach ($value as $item) {
            if (is_array($item)) {
                if ($this->isListOfArrays($item)) {
                    return $item;
                }

                $nested = $this->firstListOfArrays($item);
                if ($nested !== null) {
                    return $nested;
                }
            }
        }

        return null;
    }

    protected function recordListingDebug(string $endpoint, string $type, ?int $status, array $headers = [], ?string $error = null, mixed $raw = null): void
    {
        $this->lastListingDebug[$endpoint] = [
            'endpoint_url' => $endpoint,
            'type' => $type,
            'status' => $status,
            'headers' => $headers,
            'error' => $error,
            'raw' => $raw,
            'count' => 0,
        ];
    }

    protected function normalizeAvatarResource(array $avatar, string $type): array
    {
        return [
            'id' => (string) (data_get($avatar, 'id') ?? ''),
            'name' => (string) (data_get($avatar, 'name') ?? 'English Coach'),
            'image_url' => data_get($avatar, 'preview_url')
                ?? data_get($avatar, 'image_url')
                ?? data_get($avatar, 'thumbnail_url')
                ?? data_get($avatar, 'preview_image_url')
                ?? data_get($avatar, 'image')
                ?? data_get($avatar, 'thumbnail')
                ?? null,
            'type' => $type,
            'default_voice_id' => data_get($avatar, 'default_voice.id'),
            'default_voice_name' => data_get($avatar, 'default_voice.name'),
        ];
    }

    protected function resolveAvatarImageUrl(array $avatar): ?string
    {
        $candidates = [
            data_get($avatar, 'preview_url'),
            data_get($avatar, 'image_url'),
            data_get($avatar, 'thumbnail_url'),
            data_get($avatar, 'preview_image_url'),
            data_get($avatar, 'preview'),
            data_get($avatar, 'image'),
            data_get($avatar, 'thumbnail'),
            data_get($avatar, 'avatar_image_url'),
            data_get($avatar, 'portrait_url'),
            data_get($avatar, 'photo_url'),
            data_get($avatar, 'cover_url'),
            data_get($avatar, 'media.url'),
            data_get($avatar, 'preview_image.url'),
            data_get($avatar, 'asset.url'),
        ];

        foreach ($candidates as $candidate) {
            $url = $this->extractUrlFromValue($candidate);

            if ($url !== null) {
                return $url;
            }
        }

        return null;
    }

    protected function extractUrlFromValue(mixed $value): ?string
    {
        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }

        if (! is_array($value)) {
            return null;
        }

        foreach (['url', 'src', 'href'] as $key) {
            $candidate = data_get($value, $key);
            if (is_string($candidate) && trim($candidate) !== '') {
                return trim($candidate);
            }
        }

        foreach ($value as $nestedValue) {
            $candidate = $this->extractUrlFromValue($nestedValue);
            if ($candidate !== null) {
                return $candidate;
            }
        }

        return null;
    }

    protected function normalizeContextResource(array $item): array
    {
        return [
            'id' => (string) (data_get($item, 'id') ?? data_get($item, 'context_id') ?? data_get($item, 'contextId') ?? ''),
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'context_name') ?? data_get($item, 'title') ?? 'English Speaking Practice'),
        ];
    }

    protected function normalizeVoiceResource(array $item): array
    {
        return [
            'id' => (string) (data_get($item, 'id') ?? data_get($item, 'voice_id') ?? data_get($item, 'voiceId') ?? ''),
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'voice_name') ?? data_get($item, 'display_name') ?? 'English Voice'),
        ];
    }

    protected function listingApiKey(): string
    {
        $configured = $this->normalizeApiKey((string) config('services.heygen.liveavatar_api_key'));
        if ($configured !== '') {
            return $configured;
        }

        return $this->normalizeApiKey((string) env('LIVEAVATAR_API_KEY', ''));
    }

    protected function apiKey(): string
    {
        $liveAvatarKey = $this->normalizeApiKey((string) config('services.heygen.liveavatar_api_key'));
        if ($liveAvatarKey !== '') {
            return $liveAvatarKey;
        }

        $configured = $this->normalizeApiKey((string) config('services.heygen.api_key'));
        if ($configured !== '') {
            return $configured;
        }

        $envLiveAvatar = $this->normalizeApiKey((string) env('LIVEAVATAR_API_KEY', ''));
        if ($envLiveAvatar !== '') {
            return $envLiveAvatar;
        }

        return $this->normalizeApiKey((string) env('HEYGEN_API_KEY', ''));
    }

    public function apiKeyDebugMeta(): array
    {
        $liveAvatarKey = $this->normalizeApiKey((string) config('services.heygen.liveavatar_api_key'));
        $heygenKey = $this->normalizeApiKey((string) config('services.heygen.api_key'));
        $selected = $this->apiKey();

        return [
            'selected_key_source' => $liveAvatarKey !== '' ? 'services.heygen.liveavatar_api_key' : ($heygenKey !== '' ? 'services.heygen.api_key' : 'env.HEYGEN_API_KEY'),
            'selected_key_prefix' => $selected !== '' ? substr($selected, 0, 12) . '...' : null,
            'selected_key_length' => $selected !== '' ? strlen($selected) : 0,
        ];
    }


    protected function normalizeApiKey(string $value): string
    {
        $normalized = trim($value);

        if ($normalized === '') {
            return '';
        }

        $normalized = trim($normalized, "\"'");
        $normalized = preg_replace('/\s+/', '', $normalized) ?? '';

        return trim($normalized);
    }

    protected function extractProviderError($response): string
    {
        $json = $response->json();

        return data_get($json, 'message')
            ?? data_get($json, 'error.message')
            ?? data_get($json, 'error')
            ?? data_get($json, 'detail')
            ?? (trim((string) $response->body()) ?: 'Unable to generate LiveAvatar token.');
    }
}
