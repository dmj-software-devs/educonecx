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

        $response = Http::baseUrl(config('services.heygen.base_url'))
            ->withToken(config('services.heygen.api_key'))
            ->acceptJson()
            ->post('/v1/live-avatar/session', $payload); // TODO: verify final endpoint path.

        if ($response->failed()) {
            Log::error('HeyGen create session failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'scenario_slug' => $scenario->slug,
                'config_source' => $resolved['source'],
            ]);

            throw new \RuntimeException('Unable to create live avatar session right now. Please try again later.');
        }

        return [
            'response' => $response->json() ?? [],
            'resolved' => [
                'avatar_id' => $resolved['avatar_id'],
                'voice_id' => $resolved['voice_id'],
                'context_id' => $resolved['context_id'],
                'source' => $resolved['source'],
            ],
            'dynamic_instructions' => $instructions,
        ];
    }

    public function buildHeyGenPayload(array $resolvedConfig, string $instructions): array
    {
        $payload = [
            // TODO: Confirm official HeyGen LiveAvatar Full Mode payload keys for dynamic instructions/context.
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

        $response = Http::baseUrl(config('services.heygen.base_url'))
            ->withToken(config('services.heygen.api_key'))
            ->acceptJson()
            ->post('/v1/live-avatar/session/start', [
                'session_id' => $sessionId,
            ]);

        if ($response->failed()) {
            Log::error('HeyGen start session failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'session_id' => $sessionId,
            ]);

            throw new \RuntimeException('Unable to start live avatar session right now. Please try again later.');
        }

        return $response->json() ?? [];
    }

    protected function assertApiConfiguration(): void
    {
        if (blank(config('services.heygen.api_key'))) {
            throw new \RuntimeException('HeyGen configuration missing: api_key');
        }
    }
}
