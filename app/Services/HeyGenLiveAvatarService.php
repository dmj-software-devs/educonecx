<?php

namespace App\Services;

use App\Models\AcademyScenario;
use App\Models\AcademyUserAvatarSetting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeyGenLiveAvatarService
{
    protected array $createTokenEndpoints = [
        '/v1/streaming.create_token',
        '/v1/sessions/token',
    ];

    protected array $createSessionEndpoints = [
        '/v1/streaming.start',
        '/v1/sessions/start',
    ];

    protected array $startSessionEndpoints = [
        '/v1/sessions/start',
        '/v1/session/start',
    ];

    public function getMissingConfigurationKeys(): array
    {
        $required = ['api_key'];
        $missing = [];

        foreach ($required as $key) {
            if (blank(config("services.heygen.{$key}"))) {
                $missing[] = $key;
            }
        }

        return $missing;
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
            'user_setting' => $userSetting,
        ];
    }

    public function buildDynamicInstructions(AcademyScenario $scenario, ?User $user = null): string
    {
        $resolved = $this->resolveAvatarConfig($scenario, $user);
        $userSetting = $resolved['user_setting'];

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

    public function createSession(AcademyScenario $scenario, ?User $user = null): array
    {
        $this->assertApiConfiguration();

        $resolved = $this->resolveAvatarConfig($scenario, $user);
        if (blank($resolved['avatar_id']) || blank($resolved['voice_id'])) {
            throw new \RuntimeException('HeyGen avatar or voice configuration is missing. Please set scenario, user, or default avatar/voice IDs.');
        }

        $instructions = $this->buildDynamicInstructions($scenario, $user);
        $payload = $this->buildHeyGenPayload($resolved, $instructions);

        // Streaming migration flow: token -> start session.
        [$tokenResponse, $tokenEndpoint, $usedBaseUrl] = $this->postWithFallbackEndpoints($this->createTokenEndpoints, [], null, false);

        if ($tokenResponse->failed()) {
            throw new \RuntimeException('Unable to create live avatar session token. ' . $this->extractProviderError($tokenResponse));
        }

        $tokenData = $tokenResponse->json() ?? [];
        $sessionToken = data_get($tokenData, 'data.token')
            ?? data_get($tokenData, 'token')
            ?? data_get($tokenData, 'data.session_token');

        if (blank($sessionToken)) {
            throw new \RuntimeException('Unable to create live avatar session token. Token missing in provider response.');
        }

        $payload['session_token'] = $sessionToken;

        [$response, $endpoint] = $this->postWithFallbackEndpoints($this->createSessionEndpoints, $payload, $sessionToken, true, [$usedBaseUrl]);

        if ($response->failed()) {
            $errorMessage = $this->extractProviderError($response);

            Log::error('HeyGen create session failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'scenario_slug' => $scenario->slug,
                'config_source' => $resolved['source'],
                'endpoint' => $endpoint,
                'token_endpoint' => $tokenEndpoint,
                'base_url' => $usedBaseUrl,
            ]);

            throw new \RuntimeException('Unable to create live avatar session right now. ' . $errorMessage);
        }

        return [
            'response' => $response->json() ?? [],
            'resolved' => [
                'avatar_id' => $resolved['avatar_id'],
                'voice_id' => $resolved['voice_id'],
                'context_id' => $resolved['context_id'],
                'source' => $resolved['source'],
                'endpoint' => $endpoint,
                'token_endpoint' => $tokenEndpoint,
                'session_token' => $sessionToken,
                'base_url' => $usedBaseUrl,
            ],
            'dynamic_instructions' => $instructions,
        ];
    }

    public function buildHeyGenPayload(array $resolvedConfig, string $instructions): array
    {
        $payload = [
            // TODO: Confirm official LiveAvatar Full Mode payload keys for dynamic instructions/context.
            'avatar_id' => $resolvedConfig['avatar_id'],
            'voice_id' => $resolvedConfig['voice_id'],
            'mode' => 'full',
            'instructions' => $instructions,
            'prompt' => $instructions,
        ];

        if (!blank($resolvedConfig['context_id'])) {
            $payload['context_id'] = $resolvedConfig['context_id'];
        }

        return $payload;
    }

    public function startSession(string $sessionId): array
    {
        $this->assertApiConfiguration();

        [$response, $endpoint] = $this->postWithFallbackEndpoints($this->startSessionEndpoints, [
            'session_id' => $sessionId,
        ], null, true);

        if ($response->failed()) {
            Log::error('HeyGen start session failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'session_id' => $sessionId,
                'endpoint' => $endpoint,
            ]);

            throw new \RuntimeException('Unable to start live avatar session right now. ' . $this->extractProviderError($response));
        }

        return $response->json() ?? [];
    }

    protected function assertApiConfiguration(): void
    {
        if (blank($this->apiKey())) {
            throw new \RuntimeException('HeyGen configuration missing: api_key');
        }
    }

    protected function apiKey(): string
    {
        $configured = trim((string) config('services.heygen.api_key'));
        if ($configured !== '') {
            return $configured;
        }

        return trim((string) env('HEYGEN_API_KEY', ''));
    }

    protected function heygenHttp(string $baseUrl, ?string $sessionToken = null, bool $preferSessionToken = false)
    {
        $request = Http::baseUrl($baseUrl)
            ->acceptJson()
            ->withHeaders([
                'X-Api-Key' => $this->apiKey(),
                'Content-Type' => 'application/json',
            ]);

        if ($preferSessionToken && !blank($sessionToken)) {
            return $request->withToken($sessionToken);
        }

        return $request;
    }

    protected function postWithFallbackEndpoints(array $endpoints, array $payload, ?string $sessionToken = null, bool $preferSessionToken = false, ?array $baseUrls = null): array
    {
        $lastResponse = null;
        $lastEndpoint = end($endpoints);
        $lastBaseUrl = config('services.heygen.base_url');

        $baseUrls = $baseUrls ?: $this->candidateBaseUrls();

        foreach ($baseUrls as $baseUrl) {
            foreach ($endpoints as $endpoint) {
                $response = $this->heygenHttp($baseUrl, $sessionToken, $preferSessionToken)->post($endpoint, $payload);
                $lastResponse = $response;
                $lastEndpoint = $endpoint;
                $lastBaseUrl = $baseUrl;

                // HeyGen often returns HTTP 200 with non-success code in body.
                $providerCode = data_get($response->json(), 'code');
                if ($response->successful() && !is_null($providerCode) && (int) $providerCode !== 100) {
                    return [$response, $endpoint, $baseUrl];
                }

                if ($response->successful()) {
                    return [$response, $endpoint, $baseUrl];
                }

                $error = strtolower($this->extractProviderError($response));
                if (str_contains($error, 'sunset')) {
                    continue;
                }

                // If endpoint is clearly not found / not supported, try next fallback.
                if (!in_array($response->status(), [404, 405], true)) {
                    return [$response, $endpoint, $baseUrl];
                }
            }
        }

        return [$lastResponse, $lastEndpoint, $lastBaseUrl];
    }

    protected function candidateBaseUrls(): array
    {
        $configured = rtrim((string) config('services.heygen.base_url'), '/');
        $candidates = [$configured ?: 'https://api.heygen.com'];

        if (!str_contains($candidates[0], 'api.heygen.com')) {
            $candidates[] = 'https://api.heygen.com';
        }

        $candidates = array_values(array_unique(array_filter($candidates)));

        return $candidates;
    }

    protected function extractProviderError($response): string
    {
        $json = $response->json();
        $message = data_get($json, 'message')
            ?? data_get($json, 'error.message')
            ?? data_get($json, 'error')
            ?? data_get($json, 'detail')
            ?? null;

        if ($message) {
            if (str_contains(strtolower($message), 'sunset')) {
                return $message . ' Try HEYGEN_BASE_URL=https://api.heygen.com with HeyGen streaming endpoints.';
            }
            return (string) $message;
        }

        $body = trim((string) $response->body());
        if ($body !== '') {
            return mb_substr($body, 0, 220);
        }

        return 'Please verify your HeyGen endpoint/payload and credentials.';
    }
}
