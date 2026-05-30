<?php

namespace App\Services;

use App\Models\AcademySession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OpenAIEvaluationService
{
    private const PRONUNCIATION_NOTE = 'Pronunciation score requires audio recording or LiveAvatar speech metrics.';

    public function evaluateSession(AcademySession $session, string $transcript): array
    {
        $apiKey = trim((string) config('services.openai.api_key'));

        if ($apiKey === '') {
            throw new RuntimeException('OpenAI evaluation is not configured.');
        }

        $session->loadMissing(['scenario.category']);

        $payload = [
            'model' => config('services.openai.evaluation_model', 'gpt-5.4'),
            'input' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert English speaking evaluator. Return strict JSON only.',
                ],
                [
                    'role' => 'user',
                    'content' => $this->buildEvaluationPrompt($session, $transcript),
                ],
            ],
            'text' => [
                'format' => [
                    'type' => 'json_schema',
                    'name' => 'speaking_evaluation',
                    'strict' => true,
                    'schema' => $this->evaluationSchema(),
                ],
            ],
        ];

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout(60)
                ->post('https://api.openai.com/v1/responses', $payload);
        } catch (\Throwable $exception) {
            Log::warning('OpenAI evaluation request failed', [
                'academy_session_id' => $session->id,
                'exception' => $exception->getMessage(),
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to evaluate this session right now.', $exception->getMessage()));
        }

        if ($response->failed()) {
            $providerMessage = data_get($response->json(), 'error.message')
                ?? data_get($response->json(), 'message')
                ?? 'OpenAI Responses API request failed.';

            Log::warning('OpenAI evaluation returned an error', [
                'academy_session_id' => $session->id,
                'status' => $response->status(),
                'provider_message' => $providerMessage,
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to evaluate this session right now.', $providerMessage));
        }

        $evaluation = $this->extractEvaluation($response->json() ?? []);
        $evaluation['pronunciation_score'] = null;
        $evaluation['pronunciation_note'] = self::PRONUNCIATION_NOTE;

        return $evaluation;
    }

    private function buildEvaluationPrompt(AcademySession $session, string $transcript): string
    {
        $scenario = $session->scenario;
        $category = $scenario?->category;

        return implode("\n", [
            "Evaluate this learner's speaking practice transcript for EDUCONECX Academy Social Practice.",
            'HeyGen/LiveAvatar handled the live avatar, voice interaction, real-time conversation, and roleplay session. OpenAI is only providing post-session written evaluation.',
            'Selected category: ' . ($category?->title ?? 'Not provided'),
            'Scenario title: ' . ($scenario?->title ?? 'Not provided'),
            'Practice text: ' . ($scenario?->practice_text ?? 'Not provided'),
            'Transcript: ' . $transcript,
            'Score grammar_score, fluency_score, vocabulary_score, and overall_score from 0 to 10.',
            'Be encouraging and practical. Correct grammar gently with concise explanations.',
            'No audio recording or LiveAvatar speech metrics are provided in this request, so pronunciation_score must be null.',
            'Set pronunciation_note exactly to: ' . self::PRONUNCIATION_NOTE,
            'Return only JSON matching the required schema.',
        ]);
    }

    private function evaluationSchema(): array
    {
        return [
            'type' => 'object',
            'additionalProperties' => false,
            'properties' => [
                'grammar_score' => ['type' => 'number'],
                'fluency_score' => ['type' => 'number'],
                'vocabulary_score' => ['type' => 'number'],
                'pronunciation_score' => ['type' => ['number', 'null']],
                'overall_score' => ['type' => 'number'],
                'corrections' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'additionalProperties' => false,
                        'properties' => [
                            'original' => ['type' => 'string'],
                            'corrected' => ['type' => 'string'],
                            'explanation' => ['type' => 'string'],
                        ],
                        'required' => ['original', 'corrected', 'explanation'],
                    ],
                ],
                'strengths' => ['type' => 'array', 'items' => ['type' => 'string']],
                'weaknesses' => ['type' => 'array', 'items' => ['type' => 'string']],
                'feedback' => ['type' => 'string'],
                'next_steps' => ['type' => 'array', 'items' => ['type' => 'string']],
                'pronunciation_note' => ['type' => 'string'],
            ],
            'required' => [
                'grammar_score',
                'fluency_score',
                'vocabulary_score',
                'pronunciation_score',
                'overall_score',
                'corrections',
                'strengths',
                'weaknesses',
                'feedback',
                'next_steps',
                'pronunciation_note',
            ],
        ];
    }

    private function extractEvaluation(array $response): array
    {
        $content = data_get($response, 'output_text') ?? $this->extractOutputText($response);
        $evaluation = is_string($content) ? json_decode($content, true) : null;

        if (! is_array($evaluation)) {
            Log::warning('OpenAI evaluation response could not be parsed', [
                'response_id' => data_get($response, 'id'),
                'response_status' => data_get($response, 'status'),
            ]);

            throw new RuntimeException('Unable to parse OpenAI evaluation response.');
        }

        return [
            'grammar_score' => $this->normalizeScore($evaluation['grammar_score'] ?? null),
            'fluency_score' => $this->normalizeScore($evaluation['fluency_score'] ?? null),
            'vocabulary_score' => $this->normalizeScore($evaluation['vocabulary_score'] ?? null),
            'pronunciation_score' => null,
            'overall_score' => $this->normalizeScore($evaluation['overall_score'] ?? null),
            'corrections' => $this->normalizeArray($evaluation['corrections'] ?? []),
            'strengths' => $this->normalizeArray($evaluation['strengths'] ?? []),
            'weaknesses' => $this->normalizeArray($evaluation['weaknesses'] ?? []),
            'feedback' => (string) ($evaluation['feedback'] ?? ''),
            'next_steps' => $this->normalizeArray($evaluation['next_steps'] ?? []),
            'pronunciation_note' => self::PRONUNCIATION_NOTE,
        ];
    }

    private function extractOutputText(array $response): ?string
    {
        $chunks = [];

        foreach ((array) data_get($response, 'output', []) as $output) {
            foreach ((array) data_get($output, 'content', []) as $content) {
                $text = data_get($content, 'text');
                if (is_string($text)) {
                    $chunks[] = $text;
                }
            }
        }

        return $chunks === [] ? null : implode('', $chunks);
    }

    private function normalizeScore(mixed $score): ?float
    {
        if (! is_numeric($score)) {
            return null;
        }

        return round(max(0, min(10, (float) $score)), 2);
    }

    private function normalizeArray(mixed $value): array
    {
        return is_array($value) ? array_values($value) : [];
    }

    private function safeErrorMessage(string $publicMessage, string $debugMessage): string
    {
        if (config('app.debug')) {
            return $publicMessage . ' ' . $debugMessage;
        }

        return $publicMessage;
    }
}
