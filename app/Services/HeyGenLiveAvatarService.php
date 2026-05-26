<?php

namespace App\Services;

use App\Models\AcademyScenario;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeyGenLiveAvatarService
{
    public function createSession(AcademyScenario $scenario): array
    {
        $this->assertConfiguration();

        $payload = [
            // TODO: Confirm final HeyGen endpoint and payload format for your account's Live Avatar Full Mode.
            'avatar_id' => config('services.heygen.avatar_id'),
            'voice_id' => config('services.heygen.voice_id'),
            'context_id' => config('services.heygen.context_id'),
            'mode' => 'full',
            'instructions' => $this->buildScenarioInstructions($scenario),
        ];

        $response = Http::baseUrl(config('services.heygen.base_url'))
            ->withToken(config('services.heygen.api_key'))
            ->acceptJson()
            ->post('/v1/live-avatar/session', $payload); // TODO: verify path.

        if ($response->failed()) {
            Log::error('HeyGen create session failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
                'scenario_slug' => $scenario->slug,
            ]);

            throw new \RuntimeException('Unable to create live avatar session right now. Please try again later.');
        }

        return $response->json() ?? [];
    }

    public function startSession(string $sessionId): array
    {
        $this->assertConfiguration();

        $response = Http::baseUrl(config('services.heygen.base_url'))
            ->withToken(config('services.heygen.api_key'))
            ->acceptJson()
            ->post('/v1/live-avatar/session/start', [ // TODO: verify path/payload.
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

    public function buildScenarioInstructions(AcademyScenario $scenario): string
    {
        return "You are an English speaking practice tutor inside EDUCONECX Academy.\n"
            . "The user selected this category: {$scenario->category->title}.\n"
            . "Scenario: {$scenario->title}.\n"
            . "Practice text: {$scenario->practice_text}.\n"
            . "Your job:\n"
            . "- greet the learner warmly\n"
            . "- explain the scenario briefly\n"
            . "- ask one question at a time\n"
            . "- wait for the learner response\n"
            . "- correct grammar gently\n"
            . "- improve vocabulary naturally\n"
            . "- encourage the learner\n"
            . "- keep responses short and clear\n"
            . "- at the end, provide simple feedback and a score out of 10.";
    }

    protected function assertConfiguration(): void
    {
        foreach (['api_key', 'avatar_id', 'voice_id', 'context_id'] as $key) {
            if (blank(config("services.heygen.{$key}"))) {
                throw new \RuntimeException("HeyGen configuration missing: {$key}");
            }
        }
    }
}
