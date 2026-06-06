<?php

namespace App\Services;

use App\Models\AcademySession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OpenAIEvaluationService
{
    private const PRONUNCIATION_NOTE = 'Pronunciation score requires an audio recording.';

    public function evaluateSession(AcademySession $session, string $transcript): array
    {
        $this->ensureConfigured();

        $evaluation = $this->requestEvaluation(
            session: $session,
            transcript: $transcript,
            audioBased: false
        );

        $evaluation['transcript'] = $transcript;
        $evaluation['pronunciation_score'] = null;
        $evaluation['pronunciation_feedback'] = self::PRONUNCIATION_NOTE;
        $evaluation['pronunciation_note'] = self::PRONUNCIATION_NOTE;

        return $evaluation;
    }

    public function evaluateAudioSession(AcademySession $session, string $audioPath): array
    {
        $this->ensureConfigured();

        $transcript = $this->transcribeAudio($session, $audioPath);
        $evaluation = $this->requestEvaluation(
            session: $session,
            transcript: $transcript,
            audioBased: true
        );

        $evaluation['transcript'] = $evaluation['transcript'] ?: $transcript;
        $evaluation['pronunciation_score'] = $this->normalizeScore($evaluation['pronunciation_score'] ?? null);
        $evaluation['pronunciation_feedback'] = (string) ($evaluation['pronunciation_feedback'] ?? 'Pronunciation feedback was generated from the uploaded speech recording and transcript.');

        return $evaluation;
    }

    private function ensureConfigured(): void
    {
        if ($this->apiKey() === '') {
            throw new RuntimeException('Performance review service is not configured.');
        }
    }

    private function transcribeAudio(AcademySession $session, string $audioPath): string
    {
        if (! is_file($audioPath) || ! is_readable($audioPath)) {
            throw new RuntimeException('Uploaded audio could not be read for evaluation.');
        }

        try {
            $handle = fopen($audioPath, 'r');

            if ($handle === false) {
                throw new RuntimeException('Uploaded audio could not be opened for evaluation.');
            }

            $response = Http::withToken($this->apiKey())
                ->acceptJson()
                ->timeout(120)
                ->attach('file', $handle, basename($audioPath))
                ->post('https://api.openai.com/v1/audio/transcriptions', [
                    'model' => config('services.openai.transcription_model', 'gpt-4o-transcribe'),
                    'response_format' => 'json',
                ]);
        } catch (\Throwable $exception) {
            Log::warning('OpenAI audio transcription request failed', [
                'academy_session_id' => $session->id,
                'exception' => $exception->getMessage(),
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to transcribe this recording right now.', $exception->getMessage()));
        } finally {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
        }

        if ($response->failed()) {
            $providerMessage = data_get($response->json(), 'error.message')
                ?? data_get($response->json(), 'message')
                ?? 'Audio transcription request failed.';

            Log::warning('OpenAI audio transcription returned an error', [
                'academy_session_id' => $session->id,
                'status' => $response->status(),
                'provider_message' => $providerMessage,
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to transcribe this recording right now.', $providerMessage));
        }

        $transcript = trim((string) data_get($response->json(), 'text'));

        if ($transcript === '') {
            throw new RuntimeException('The review service did not return a transcript for this recording.');
        }

        return $transcript;
    }

    private function requestEvaluation(AcademySession $session, string $transcript, bool $audioBased): array
    {
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
                    'content' => $this->buildEvaluationPrompt($session, $transcript, $audioBased),
                ],
            ],
            'text' => [
                'format' => [
                    'type' => 'json_schema',
                    'name' => $audioBased ? 'speaking_audio_evaluation' : 'speaking_evaluation',
                    'strict' => true,
                    'schema' => $audioBased ? $this->audioEvaluationSchema() : $this->textEvaluationSchema(),
                ],
            ],
        ];

        try {
            $response = Http::withToken($this->apiKey())
                ->acceptJson()
                ->asJson()
                ->timeout(90)
                ->post('https://api.openai.com/v1/responses', $payload);
        } catch (\Throwable $exception) {
            Log::warning('OpenAI evaluation request failed', [
                'academy_session_id' => $session->id,
                'audio_based' => $audioBased,
                'exception' => $exception->getMessage(),
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to evaluate this session right now.', $exception->getMessage()));
        }

        if ($response->failed()) {
            $providerMessage = data_get($response->json(), 'error.message')
                ?? data_get($response->json(), 'message')
                ?? 'Performance review request failed.';

            Log::warning('OpenAI evaluation returned an error', [
                'academy_session_id' => $session->id,
                'audio_based' => $audioBased,
                'status' => $response->status(),
                'provider_message' => $providerMessage,
            ]);

            throw new RuntimeException($this->safeErrorMessage('Unable to evaluate this session right now.', $providerMessage));
        }

        return $this->extractEvaluation($response->json() ?? [], $audioBased);
    }

    private function buildEvaluationPrompt(AcademySession $session, string $transcript, bool $audioBased): string
    {
        $scenario = $session->scenario;
        $category = $scenario?->category;
        $contextName = $session->context_name ?: 'English Speaking Practice';
        $avatarName = $session->avatar_name ?: 'Victoria Clarke';
        $pronunciationInstruction = $audioBased
            ? 'The learner uploaded a microphone recording that was transcribed before this review. Provide pronunciation_feedback and a pronunciation_score from 0 to 10 based on speech-to-text clarity, likely unclear words, fluency, and the transcript. If exact acoustic pronunciation details are not available from the transcription output, say the score is approximate and explain the limitation briefly.'
            : 'No audio recording or speech metrics are provided in this request, so pronunciation_score must be null and pronunciation_note must match the required note.';

        return implode("\n", [
            "Evaluate this learner's English speaking practice for EDUCONECX Academy.",
            'Victoria Clarke led the live coaching conversation. Provide only the post-session performance review and scoring.',
            'Selected category: ' . ($category?->title ?? 'English Speaking Practice'),
            'English Coach: ' . $avatarName,
            'Conversation focus: ' . $contextName,
            'Scenario title: ' . ($scenario?->title ?? $contextName),
            'Practice text: ' . ($scenario?->practice_text ?? 'Evaluate the learner against the selected English practice focus and natural English speaking practice.'),
            'Transcript: ' . $transcript,
            'Score grammar_score, fluency_score, vocabulary_score, and overall_score from 0 to 10.',
            $audioBased ? 'Also score pronunciation_score from 0 to 10 and include practical pronunciation_feedback.' : 'Set pronunciation_note exactly to: ' . self::PRONUNCIATION_NOTE,
            $pronunciationInstruction,
            'Be encouraging and practical. Correct grammar gently with concise explanations.',
            'Return only JSON matching the required schema.',
        ]);
    }

    private function textEvaluationSchema(): array
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
                'corrections' => $this->correctionsSchema(),
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

    private function audioEvaluationSchema(): array
    {
        return [
            'type' => 'object',
            'additionalProperties' => false,
            'properties' => [
                'transcript' => ['type' => 'string'],
                'pronunciation_score' => ['type' => 'number'],
                'grammar_score' => ['type' => 'number'],
                'fluency_score' => ['type' => 'number'],
                'vocabulary_score' => ['type' => 'number'],
                'overall_score' => ['type' => 'number'],
                'pronunciation_feedback' => ['type' => 'string'],
                'corrections' => $this->correctionsSchema(),
                'strengths' => ['type' => 'array', 'items' => ['type' => 'string']],
                'weaknesses' => ['type' => 'array', 'items' => ['type' => 'string']],
                'feedback' => ['type' => 'string'],
                'next_steps' => ['type' => 'array', 'items' => ['type' => 'string']],
            ],
            'required' => [
                'transcript',
                'pronunciation_score',
                'grammar_score',
                'fluency_score',
                'vocabulary_score',
                'overall_score',
                'pronunciation_feedback',
                'corrections',
                'strengths',
                'weaknesses',
                'feedback',
                'next_steps',
            ],
        ];
    }

    private function correctionsSchema(): array
    {
        return [
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
        ];
    }

    private function extractEvaluation(array $response, bool $audioBased): array
    {
        $content = data_get($response, 'output_text') ?? $this->extractOutputText($response);
        $evaluation = is_string($content) ? json_decode($content, true) : null;

        if (! is_array($evaluation)) {
            Log::warning('OpenAI evaluation response could not be parsed', [
                'response_id' => data_get($response, 'id'),
                'response_status' => data_get($response, 'status'),
                'audio_based' => $audioBased,
            ]);

            throw new RuntimeException('Unable to parse performance review response.');
        }

        $normalized = [
            'transcript' => (string) ($evaluation['transcript'] ?? ''),
            'grammar_score' => $this->normalizeScore($evaluation['grammar_score'] ?? null),
            'fluency_score' => $this->normalizeScore($evaluation['fluency_score'] ?? null),
            'vocabulary_score' => $this->normalizeScore($evaluation['vocabulary_score'] ?? null),
            'pronunciation_score' => $audioBased ? $this->normalizeScore($evaluation['pronunciation_score'] ?? null) : null,
            'overall_score' => $this->normalizeScore($evaluation['overall_score'] ?? null),
            'pronunciation_feedback' => (string) ($evaluation['pronunciation_feedback'] ?? ($evaluation['pronunciation_note'] ?? '')),
            'corrections' => $this->normalizeArray($evaluation['corrections'] ?? []),
            'strengths' => $this->normalizeArray($evaluation['strengths'] ?? []),
            'weaknesses' => $this->normalizeArray($evaluation['weaknesses'] ?? []),
            'feedback' => (string) ($evaluation['feedback'] ?? ''),
            'next_steps' => $this->normalizeArray($evaluation['next_steps'] ?? []),
        ];

        if (! $audioBased) {
            $normalized['pronunciation_note'] = self::PRONUNCIATION_NOTE;
        }

        return $normalized;
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

    private function apiKey(): string
    {
        return trim((string) config('services.openai.api_key'));
    }

    private function safeErrorMessage(string $publicMessage, string $debugMessage): string
    {
        if (config('app.debug')) {
            return $publicMessage . ' ' . $debugMessage;
        }

        return $publicMessage;
    }
}
