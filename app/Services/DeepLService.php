<?php

namespace App\Services;

use DeepL\Translator;
use DeepL\DeepLException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DeepLService
{
    protected $translator;
    protected $apiKey;
    protected $apiUrl;
    protected $supportedLanguages = ['en', 'es', 'fr', 'de', 'it', 'pt', 'nl', 'pl', 'ru', 'ja', 'zh'];

    /**
     * Map our language codes to DeepL language codes
     */
    protected $languageMap = [
        'en' => 'EN',
        'es' => 'ES',
        'fr' => 'FR',
        'de' => 'DE',
        'it' => 'IT',
        'pt' => 'PT',
        'nl' => 'NL',
        'pl' => 'PL',
        'ru' => 'RU',
        'ja' => 'JA',
        'zh' => 'ZH',
    ];

    public function __construct()
    {
        $this->apiKey = config('deepl.api_key');
        $this->apiUrl = config('deepl.api_url', 'https://api-free.deepl.com/v2');

        if (!$this->apiKey) {
            throw new \Exception('DeepL API key not configured');
        }

        Log::info('DeepL Service initialized', [
            'api_key_prefix' => substr($this->apiKey, 0, 10) . '...',
            'api_url' => $this->apiUrl
        ]);
    }

    /**
     * Translate text using DeepL with header authentication
     *
     * @param string $text
     * @param string $sourceLang
     * @param string $targetLang
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function translate(string $text, string $sourceLang, string $targetLang, array $options = [])
    {
        // Don't translate if source and target are the same
        if ($sourceLang === $targetLang) {
            return $text;
        }

        // Don't translate empty or very short texts
        if (empty($text) || strlen(trim($text)) < 2) {
            return $text;
        }

        // Check cache first (cache for 30 days)
        $cacheKey = 'deepl_' . md5($text . $sourceLang . $targetLang . json_encode($options));
        if (Cache::has($cacheKey)) {
            Log::info('Using cached translation', ['key' => $cacheKey]);
            return Cache::get($cacheKey);
        }

        try {
            // Map language codes
            $source = $this->mapLanguageCode($sourceLang);
            $target = $this->mapLanguageCode($targetLang);

            Log::info('Translating with DeepL HTTP client', [
                'text' => substr($text, 0, 50),
                'source' => $source,
                'target' => $target
            ]);

            // Prepare request data
            $postData = [
                'text' => [$text],
                'source_lang' => $source,
                'target_lang' => $target,
            ];

            // Add formality if specified and supported
            if (isset($options['formality']) && in_array($targetLang, ['de', 'fr', 'it', 'es', 'nl', 'pl', 'pt', 'ru'])) {
                $postData['formality'] = $options['formality'];
            }

            // Add preserve formatting if specified
            if (isset($options['preserve_formatting']) && $options['preserve_formatting']) {
                $postData['preserve_formatting'] = '1';
            }

            // Add tag handling if specified
            if (isset($options['tag_handling'])) {
                $postData['tag_handling'] = $options['tag_handling'];
            }

            // Make the request with header authentication
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/translate', $postData);

            Log::info('DeepL API Response', [
                'status' => $response->status(),
            ]);

            // Handle specific error codes
            if ($response->status() === 456) {
                Log::error('DeepL quota exceeded');
                throw new \Exception('DeepL API quota exceeded. Please check your plan at https://www.deepl.com/account/');
            }

            if (!$response->successful()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['message'] ?? 'Unknown error';
                Log::error('DeepL HTTP request failed', [
                    'status' => $response->status(),
                    'message' => $errorMessage,
                    'body' => $response->body()
                ]);

                throw new \Exception('DeepL API error: ' . $errorMessage . ' (Status: ' . $response->status() . ')');
            }

            $data = $response->json();

            // Check if we got a valid translation
            if (!isset($data['translations'][0]['text'])) {
                Log::error('DeepL response missing translation', ['data' => $data]);
                throw new \Exception('Invalid DeepL response format');
            }

            $translatedText = $data['translations'][0]['text'];

            // Cache the result for 30 days
            Cache::put($cacheKey, $translatedText, now()->addDays(30));

            Log::info('Translation successful', [
                'original' => substr($text, 0, 30),
                'translated' => substr($translatedText, 0, 30),
                'cached' => true
            ]);

            return $translatedText;
        } catch (\Exception $e) {
            Log::error('DeepL translation error: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100),
                'source' => $sourceLang,
                'target' => $targetLang
            ]);

            // Re-throw the exception so controller can handle it
            throw $e;
        }
    }

    /**
     * Translate multiple texts in batch
     *
     * @param array $texts
     * @param string $sourceLang
     * @param string $targetLang
     * @param array $options
     * @return array
     * @throws \Exception
     */
    public function translateBatch(array $texts, string $sourceLang, string $targetLang, array $options = [])
    {
        if ($sourceLang === $targetLang) {
            return $texts;
        }

        // Filter out empty texts and keep original indices
        $filteredTexts = [];
        $originalIndices = [];
        foreach ($texts as $index => $text) {
            if (!empty($text) && strlen(trim($text)) > 1) {
                $filteredTexts[] = $text;
                $originalIndices[] = $index;
            }
        }

        if (empty($filteredTexts)) {
            return $texts;
        }

        // Check cache for each text
        $results = [];
        $textsToTranslate = [];
        $textIndices = [];

        foreach ($filteredTexts as $idx => $text) {
            $cacheKey = 'deepl_' . md5($text . $sourceLang . $targetLang . json_encode($options));

            if (Cache::has($cacheKey)) {
                $results[$originalIndices[$idx]] = Cache::get($cacheKey);
                Log::info('Using cached batch translation', ['text' => substr($text, 0, 30)]);
            } else {
                $textsToTranslate[] = $text;
                $textIndices[] = $originalIndices[$idx];
            }
        }

        // If all texts were cached, return them in original order
        if (empty($textsToTranslate)) {
            ksort($results);
            return array_values($results);
        }

        try {
            $source = $this->mapLanguageCode($sourceLang);
            $target = $this->mapLanguageCode($targetLang);

            Log::info('Processing batch translation', [
                'count' => count($textsToTranslate),
                'source' => $source,
                'target' => $target,
                'total_batch_size' => count($texts)
            ]);

            // Prepare request data for batch
            $postData = [
                'text' => array_values($textsToTranslate),
                'source_lang' => $source,
                'target_lang' => $target,
            ];

            if (isset($options['formality'])) {
                $postData['formality'] = $options['formality'];
            }

            if (isset($options['preserve_formatting']) && $options['preserve_formatting']) {
                $postData['preserve_formatting'] = '1';
            }

            if (isset($options['tag_handling'])) {
                $postData['tag_handling'] = $options['tag_handling'];
            }

            // Make the request with header authentication
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/translate', $postData);

            Log::info('DeepL Batch API Response', [
                'status' => $response->status()
            ]);

            // Handle specific error codes
            if ($response->status() === 456) {
                Log::error('DeepL quota exceeded during batch translation');
                throw new \Exception('DeepL API quota exceeded. Please check your plan at https://www.deepl.com/account/');
            }

            if (!$response->successful()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['message'] ?? 'Unknown error';
                Log::error('DeepL batch HTTP request failed', [
                    'status' => $response->status(),
                    'message' => $errorMessage,
                    'body' => $response->body()
                ]);
                throw new \Exception('DeepL API error: ' . $errorMessage . ' (Status: ' . $response->status() . ')');
            }

            $data = $response->json();

            if (!isset($data['translations'])) {
                Log::error('DeepL batch response missing translations', ['data' => $data]);
                throw new \Exception('Invalid DeepL response format');
            }

            $translations = $data['translations'];

            // Store results with original indices and cache them
            foreach ($textIndices as $index => $originalIndex) {
                $translatedText = $translations[$index]['text'] ?? $textsToTranslate[$index];
                $results[$originalIndex] = $translatedText;

                // Cache each translation individually
                $cacheKey = 'deepl_' . md5($textsToTranslate[$index] . $sourceLang . $targetLang . json_encode($options));
                Cache::put($cacheKey, $translatedText, now()->addDays(30));
            }

            // Add back any texts that were skipped (empty ones)
            foreach ($texts as $index => $text) {
                if (!isset($results[$index])) {
                    $results[$index] = $text;
                }
            }

            // Sort by original index to maintain order
            ksort($results);

            Log::info('Batch translation successful', [
                'translated_count' => count($textsToTranslate),
                'cached_count' => count($results) - count($textsToTranslate),
                'total' => count($results)
            ]);

            return array_values($results);
        } catch (\Exception $e) {
            Log::error('DeepL batch translation error: ' . $e->getMessage());

            // Re-throw the exception
            throw $e;
        }
    }

    /**
     * Get usage information
     *
     * @return array|null
     */
    public function getUsage()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
            ])->get($this->apiUrl . '/usage');

            if ($response->successful()) {
                $data = $response->json();
                $usage = [
                    'character_count' => $data['character_count'] ?? 0,
                    'character_limit' => $data['character_limit'] ?? 0,
                    'percentage_used' => isset($data['character_count']) && isset($data['character_limit']) && $data['character_limit'] > 0
                        ? round(($data['character_count'] / $data['character_limit']) * 100, 2)
                        : 0
                ];

                // Log warning if close to limit
                if ($usage['percentage_used'] > 80) {
                    Log::warning('DeepL quota running low', [
                        'used' => $usage['character_count'],
                        'limit' => $usage['character_limit'],
                        'percentage' => $usage['percentage_used'] . '%'
                    ]);
                }

                return $usage;
            }
        } catch (\Exception $e) {
            Log::error('Failed to get DeepL usage: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Check if translation service is available and quota is not exceeded
     *
     * @return bool
     */
    public function isAvailable()
    {
        try {
            $usage = $this->getUsage();
            if ($usage && $usage['percentage_used'] >= 100) {
                Log::warning('DeepL quota exhausted');
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error('DeepL availability check failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get supported languages
     *
     * @return array
     */
    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
    }

    /**
     * Map our language codes to DeepL codes
     *
     * @param string $code
     * @return string
     */
    protected function mapLanguageCode(string $code)
    {
        // DeepL expects uppercase language codes
        return strtoupper($code);
    }
}
