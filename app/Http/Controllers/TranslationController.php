<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeepLService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    protected $deepLService;

    public function __construct(DeepLService $deepLService)
    {
        $this->deepLService = $deepLService;
    }

    public function translate(Request $request)
    {
        // Log the request for debugging
        Log::info('Translation request received', [
            'q_type' => gettype($request->q),
            'source' => $request->source,
            'target' => $request->target,
            'batch' => $request->boolean('batch'),
            'has_array' => is_array($request->q)
        ]);

        // Custom validation - allow array for batch, string for single
        $rules = [
            'source' => 'required|string|in:en,es,fr,de,it,pt,nl,pl,ru,ja,zh',
            'target' => 'required|string|in:en,es,fr,de,it,pt,nl,pl,ru,ja,zh',
            'formality' => 'sometimes|string|in:default,more,less',
            'batch' => 'sometimes|boolean'
        ];

        // If batch is true and q is an array, validate as array
        if ($request->boolean('batch') && is_array($request->q)) {
            $rules['q'] = 'required|array';
            $rules['q.*'] = 'string|min:1';
        } else {
            // Otherwise validate as string
            $rules['q'] = 'required|string|min:1';
        }

        // Validate the request
        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Translation validation failed', [
                'errors' => $e->errors(),
                'request_data' => [
                    'q' => $request->q,
                    'batch' => $request->boolean('batch'),
                    'source' => $request->source,
                    'target' => $request->target
                ]
            ]);
            
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage(),
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Translation validation exception: ' . $e->getMessage());
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage()
            ], 422);
        }

        $text = $request->q;
        $source = $request->source;
        $target = $request->target;
        $formality = $request->get('formality', 'default');

        // Handle batch translation
        if ($request->boolean('batch') && is_array($text)) {
            try {
                Log::info('Processing batch translation', [
                    'text_count' => count($text),
                    'source' => $source,
                    'target' => $target
                ]);

                $options = [];
                if ($formality !== 'default') {
                    $options['formality'] = $formality;
                }
                
                $translatedTexts = $this->deepLService->translateBatch($text, $source, $target, $options);
                
                Log::info('Batch translation successful', [
                    'count' => count($translatedTexts),
                    'source' => $source,
                    'target' => $target
                ]);
                
                return response()->json([
                    'translatedTexts' => $translatedTexts,
                    'source' => $source,
                    'target' => $target,
                    'batch' => true
                ]);

            } catch (\Exception $e) {
                Log::error('Batch translation failed: ' . $e->getMessage(), [
                    'source' => $source,
                    'target' => $target,
                    'text_count' => count($text),
                    'error' => $e->getMessage()
                ]);

                // Return original texts as fallback
                return response()->json([
                    'error' => 'Translation failed',
                    'message' => $e->getMessage(),
                    'translatedTexts' => $text, // Return original as fallback
                    'source' => $source,
                    'target' => $target,
                    'batch' => true
                ], 200); // Return 200 with original text to avoid breaking UI
            }
        }

        // Single text translation
        try {
            Log::info('Processing single translation', [
                'text_length' => strlen($text),
                'source' => $source,
                'target' => $target
            ]);

            // Check if text contains HTML
            $tagHandling = $this->containsHtml($text) ? 'html' : null;
            
            $options = [];
            if ($formality !== 'default') {
                $options['formality'] = $formality;
            }
            if ($tagHandling) {
                $options['tag_handling'] = $tagHandling;
            }

            $translatedText = $this->deepLService->translate($text, $source, $target, $options);

            Log::info('Single translation successful', [
                'source' => $source,
                'target' => $target
            ]);

            return response()->json([
                'translatedText' => $translatedText,
                'source' => $source,
                'target' => $target,
                'from_cache' => false,
                'batch' => false
            ]);

        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100),
                'source' => $source,
                'target' => $target,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'translatedText' => $text,
                'error' => 'Translation service temporarily unavailable',
                'message' => $e->getMessage(),
                'source' => $source,
                'target' => $target,
                'batch' => false
            ], 200); // Return 200 with original text to avoid breaking the UI
        }
    }

    /**
     * Get translation usage information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usage()
    {
        try {
            $usage = $this->deepLService->getUsage();
            return response()->json([
                'success' => true,
                'data' => $usage
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get usage: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Could not retrieve usage'
            ], 500);
        }
    }

    /**
     * Get supported languages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function languages()
    {
        try {
            $languages = $this->deepLService->getSupportedLanguages();
            return response()->json([
                'success' => true,
                'data' => $languages
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get languages: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Could not retrieve languages'
            ], 500);
        }
    }

    /**
     * Test endpoint for debugging
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function test()
    {
        $apiKey = config('deepl.api_key');
        $apiKeyStatus = $apiKey ? 'Configured' : 'Not configured';
        $apiKeyPreview = $apiKey ? substr($apiKey, 0, 10) . '...' : 'none';
        
        return response()->json([
            'success' => true,
            'message' => 'Translation controller is working',
            'timestamp' => now()->toDateTimeString(),
            'config' => [
                'api_key' => $apiKeyStatus,
                'api_key_preview' => $apiKeyPreview,
                'supported_languages' => config('deepl.supported_languages', []),
                'environment' => app()->environment()
            ],
            'request' => [
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'headers' => [
                    'accept' => request()->header('accept'),
                    'content_type' => request()->header('content-type'),
                    'x_requested_with' => request()->header('x-requested-with')
                ]
            ]
        ]);
    }

    /**
     * Debug endpoint to test translation with various inputs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function debug(Request $request)
    {
        $testResults = [];
        
        // Test single string
        try {
            $singleResult = $this->deepLService->translate('Hello world', 'en', 'es');
            $testResults['single_string'] = [
                'success' => true,
                'result' => $singleResult
            ];
        } catch (\Exception $e) {
            $testResults['single_string'] = [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
        // Test batch array
        try {
            $batchResult = $this->deepLService->translateBatch(['Hello', 'world'], 'en', 'es');
            $testResults['batch_array'] = [
                'success' => true,
                'result' => $batchResult
            ];
        } catch (\Exception $e) {
            $testResults['batch_array'] = [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
        return response()->json([
            'success' => true,
            'controller_status' => 'operational',
            'deepL_service' => class_exists('App\Services\DeepLService'),
            'test_results' => $testResults
        ]);
    }

    /**
     * Check if text contains HTML
     *
     * @param string $text
     * @return bool
     */
    protected function containsHtml(string $text): bool
    {
        // Strip whitespace and check for HTML tags
        $text = trim($text);
        return preg_match('/<[^<]+>/', $text) === 1;
    }
}