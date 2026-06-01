<?php

namespace App\Services;

use App\Models\AcademyScenario;
use App\Models\AcademyUserAvatarSetting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeyGenLiveAvatarService
{
    public function getMissingConfigurationKeys(): array
    {
        $liveAvatarKey = $this->normalizeApiKey((string) config('services.heygen.liveavatar_api_key'));
        $heygenKey = $this->normalizeApiKey((string) config('services.heygen.api_key'));

        if ($liveAvatarKey === '' && $heygenKey === '') {
            return ['api_key'];
        }

        return [];
    }

    public function resolveAvatarConfig(AcademyScenario $scenario, ?User $user = null): array
    {
        $userSetting = null;
        if ($user) {
            $userSetting = AcademyUserAvatarSetting::query()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        }

        $avatarId = $scenario->heygen_avatar_id
            ?? $userSetting?->heygen_avatar_id
            ?? config('services.heygen.default_avatar_id');

        $voiceId = $scenario->heygen_voice_id
            ?? $userSetting?->heygen_voice_id
            ?? config('services.heygen.default_voice_id');

        $contextId = $scenario->heygen_context_id
            ?? $userSetting?->heygen_context_id
            ?? config('services.heygen.default_context_id');

        return [
            'avatar_id' => $avatarId,
            'voice_id' => $voiceId,
            'context_id' => $contextId,
            'source' => [
                'avatar_id' => $scenario->heygen_avatar_id ? 'scenario' : ($userSetting?->heygen_avatar_id ? 'user' : (config('services.heygen.default_avatar_id') ? 'env' : 'none')),
                'voice_id' => $scenario->heygen_voice_id ? 'scenario' : ($userSetting?->heygen_voice_id ? 'user' : (config('services.heygen.default_voice_id') ? 'env' : 'none')),
                'context_id' => $scenario->heygen_context_id ? 'scenario' : ($userSetting?->heygen_context_id ? 'user' : (config('services.heygen.default_context_id') ? 'env' : 'none')),
            ],
        ];
    }

    public function buildDynamicInstructions(AcademyScenario $scenario, ?User $user = null): string
    {
        $resolved = $this->resolveAvatarConfig($scenario, $user);

        $userSetting = null;
        if ($user) {
            $userSetting = AcademyUserAvatarSetting::query()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        }

        $speakingLevel = $userSetting?->speaking_level ?? $scenario->level ?? 'Beginner';
        $preferredLanguage = $userSetting?->preferred_language ?? 'English';
        $tutorStyle = $userSetting?->tutor_style ?? 'friendly and encouraging';
        $sampleQuestions = is_array($scenario->sample_questions) ? implode('; ', $scenario->sample_questions) : 'N/A';

        return "You are an English speaking practice tutor inside EDUCONECX Academy.\n\n"
            . "Learner information:\n"
            . "- Speaking level: {$speakingLevel}\n"
            . "- Preferred language: {$preferredLanguage}\n"
            . "- Tutor style: {$tutorStyle}\n\n"
            . "Selected practice:\n"
            . "- Category: {$scenario->category->title}\n"
            . "- Scenario: {$scenario->title}\n"
            . "- Level: " . ($scenario->level ?? 'General') . "\n"
            . "- Description: " . ($scenario->description ?? 'N/A') . "\n"
            . "- Practice text: {$scenario->practice_text}\n"
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

    public function generateSessionToken(AcademyScenario $scenario, ?User $user = null): array
    {
        $url = 'https://api.liveavatar.com/v1/sessions/token';
        $apiKey = $this->apiKey();

        $resolved = $this->resolveAvatarConfig($scenario, $user);
        $instructions = $this->buildDynamicInstructions($scenario, $user);

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


    public function createLiveAvatarEmbed(AcademyScenario $scenario, ?User $user = null): array
    {
        $resolved = $this->resolveAvatarConfig($scenario, $user);

        if (empty($resolved['avatar_id'])) {
            throw new \RuntimeException('LiveAvatar avatar_id is missing.');
        }

        if (empty($resolved['context_id'])) {
            throw new \RuntimeException('LiveAvatar context_id is missing. Please set HEYGEN_DEFAULT_CONTEXT_ID in .env or scenario/user context.');
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
        $apiKey = $this->apiKey();

        if ($apiKey === '') {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept' => 'application/json',
            ])->timeout(20)->get($endpoint);
        } catch (\Throwable $exception) {
            Log::warning('LiveAvatar listing request failed', [
                'endpoint_url' => $endpoint,
                'type' => $type,
                'exception' => $exception->getMessage(),
            ]);

            return [];
        }

        if ($response->failed()) {
            Log::warning('LiveAvatar listing returned an error', [
                'endpoint_url' => $endpoint,
                'type' => $type,
                'status' => $response->status(),
                'provider_message' => $this->extractProviderError($response),
            ]);

            return [];
        }

        $items = data_get($response->json(), 'data')
            ?? data_get($response->json(), $type)
            ?? data_get($response->json(), 'items')
            ?? $response->json();

        if (! is_array($items)) {
            return [];
        }

        if (isset($items['data']) && is_array($items['data'])) {
            $items = $items['data'];
        }

        return collect($items)
            ->filter(fn ($item) => is_array($item))
            ->map(fn ($item) => $normalizer($item))
            ->filter(fn ($item) => filled($item['id'] ?? null))
            ->unique('id')
            ->values()
            ->all();
    }

    protected function normalizeAvatarResource(array $item, string $type): array
    {
        return [
            'id' => (string) (data_get($item, 'id') ?? data_get($item, 'avatar_id') ?? data_get($item, 'avatarId') ?? ''),
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'avatar_name') ?? data_get($item, 'display_name') ?? 'LiveAvatar'),
            'image_url' => data_get($item, 'image_url')
                ?? data_get($item, 'thumbnail_url')
                ?? data_get($item, 'preview_image_url')
                ?? data_get($item, 'avatar_image_url')
                ?? data_get($item, 'image'),
            'type' => $type,
        ];
    }

    protected function normalizeContextResource(array $item): array
    {
        return [
            'id' => (string) (data_get($item, 'id') ?? data_get($item, 'context_id') ?? data_get($item, 'contextId') ?? ''),
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'context_name') ?? data_get($item, 'title') ?? 'LiveAvatar Context'),
        ];
    }

    protected function normalizeVoiceResource(array $item): array
    {
        return [
            'id' => (string) (data_get($item, 'id') ?? data_get($item, 'voice_id') ?? data_get($item, 'voiceId') ?? ''),
            'name' => (string) (data_get($item, 'name') ?? data_get($item, 'voice_name') ?? data_get($item, 'display_name') ?? 'LiveAvatar Voice'),
        ];
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
