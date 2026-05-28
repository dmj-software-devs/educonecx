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

    public function generateSessionToken(): array
    {
        $url = 'https://api.liveavatar.com/v1/sessions/token';
        $apiKey = $this->apiKey();

        $primaryResponse = Http::acceptJson()
            ->withHeaders([
                'X-Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($url, []);

        Log::debug('LiveAvatar token endpoint response', [
            'endpoint_url' => $url,
            'auth_strategy' => 'X-Api-Key',
            'status' => $primaryResponse->status(),
            'body' => $primaryResponse->json() ?? $primaryResponse->body(),
        ]);

        $response = $primaryResponse;

        if (in_array($primaryResponse->status(), [401, 403], true)) {
            $secondaryResponse = Http::acceptJson()
                ->withHeaders([
                    'X-Api-Key' => $apiKey,
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, []);

            Log::debug('LiveAvatar token endpoint response', [
                'endpoint_url' => $url,
                'auth_strategy' => 'X-Api-Key + Bearer',
                'status' => $secondaryResponse->status(),
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
