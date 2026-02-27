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

        // Check cache first
        $cacheKey = 'deepl_' . md5($text . $sourceLang . $targetLang);
        if (Cache::has($cacheKey)) {
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

            // Add formality if specified
            if (isset($options['formality']) && in_array($targetLang, ['de', 'fr', 'it', 'es', 'nl', 'pl', 'pt', 'ru'])) {
                $postData['formality'] = $options['formality'];
            }

            // Make the request with header authentication
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/translate', $postData);

            Log::info('DeepL API Response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error('DeepL HTTP request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                // Don't return original text on error - throw exception so we know it failed
                throw new \Exception('DeepL API returned status ' . $response->status());
            }

            $data = $response->json();
            
            // Check if we got a valid translation
            if (!isset($data['translations'][0]['text'])) {
                Log::error('DeepL response missing translation', ['data' => $data]);
                throw new \Exception('Invalid DeepL response format');
            }
            
            $translatedText = $data['translations'][0]['text'];

            // Verify translation is different (sanity check)
            if ($translatedText === $text) {
                Log::warning('DeepL returned same text - possible issue', [
                    'text' => $text,
                    'translated' => $translatedText
                ]);
            }

            // Cache the result
            Cache::put($cacheKey, $translatedText, now()->addDays(30));

            return $translatedText;

        } catch (\Exception $e) {
            Log::error('DeepL translation error: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100),
                'source' => $sourceLang,
                'target' => $targetLang
            ]);
            
            // THROW the exception instead of returning original text
            // This will let the controller know there was an error
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
     */
    public function translateBatch(array $texts, string $sourceLang, string $targetLang, array $options = [])
    {
        if ($sourceLang === $targetLang) {
            return $texts;
        }

        // Filter out empty texts
        $texts = array_filter($texts, function($text) {
            return !empty($text) && strlen(trim($text)) > 1;
        });

        if (empty($texts)) {
            return $texts;
        }

        try {
            $source = $this->mapLanguageCode($sourceLang);
            $target = $this->mapLanguageCode($targetLang);

            Log::info('Processing batch translation', [
                'count' => count($texts),
                'source' => $source,
                'target' => $target
            ]);

            // Prepare request data for batch
            $postData = [
                'text' => array_values($texts),
                'source_lang' => $source,
                'target_lang' => $target,
            ];

            if (isset($options['formality'])) {
                $postData['formality'] = $options['formality'];
            }

            // Make the request with header authentication
            $response = Http::withHeaders([
                'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/translate', $postData);

            Log::info('DeepL Batch API Response', [
                'status' => $response->status()
            ]);

            if (!$response->successful()) {
                Log::error('DeepL batch HTTP request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('DeepL API returned status ' . $response->status());
            }

            $data = $response->json();
            
            if (!isset($data['translations'])) {
                Log::error('DeepL batch response missing translations', ['data' => $data]);
                throw new \Exception('Invalid DeepL response format');
            }

            $translations = $data['translations'];
            $results = [];

            foreach ($translations as $index => $translation) {
                $results[$index] = $translation['text'] ?? $texts[$index];
            }

            Log::info('Batch translation successful', [
                'count' => count($results)
            ]);

            return $results;

        } catch (\Exception $e) {
            Log::error('DeepL batch translation error: ' . $e->getMessage());
            // THROW exception instead of returning original texts
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
                return [
                    'character_count' => $data['character_count'] ?? 0,
                    'character_limit' => $data['character_limit'] ?? 0,
                    'percentage_used' => isset($data['character_count']) && isset($data['character_limit']) 
                        ? ($data['character_count'] / $data['character_limit']) * 100 
                        : 0
                ];
            }
        } catch (\Exception $e) {
            Log::error('Failed to get DeepL usage: ' . $e->getMessage());
        }

        return null;
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