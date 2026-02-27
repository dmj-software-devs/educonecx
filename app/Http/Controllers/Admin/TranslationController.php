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
            'q' => substr(json_encode($request->q), 0, 100),
            'source' => $request->source,
            'target' => $request->target,
            'batch' => $request->boolean('batch')
        ]);

        // Validate request
        try {
            $request->validate([
                'q' => 'required',
                'source' => 'required|string|in:en,es,fr,de,it,pt,nl,pl,ru,ja,zh',
                'target' => 'required|string|in:en,es,fr,de,it,pt,nl,pl,ru,ja,zh',
                'formality' => 'sometimes|string|in:default,more,less',
                'batch' => 'sometimes|boolean'
            ]);
        } catch (\Exception $e) {
            Log::error('Translation validation failed: ' . $e->getMessage());
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
                $options = [];
                if ($formality !== 'default') {
                    $options['formality'] = $formality;
                }
                
                $translatedTexts = $this->deepLService->translateBatch($text, $source, $target, $options);
                
                Log::info('Batch translation successful', ['count' => count($translatedTexts)]);
                
                return response()->json([
                    'translatedTexts' => $translatedTexts,
                    'source' => $source,
                    'target' => $target
                ]);
            } catch (\Exception $e) {
                Log::error('Batch translation failed: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Translation failed',
                    'message' => $e->getMessage(),
                    'translatedTexts' => $text // Return original as fallback
                ], 200); // Return 200 with original text to avoid breaking UI
            }
        }

        // Single text translation
        try {
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

            Log::info('Single translation successful');

            return response()->json([
                'translatedText' => $translatedText,
                'source' => $source,
                'target' => $target,
                'from_cache' => false
            ]);

        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100),
                'source' => $source,
                'target' => $target
            ]);

            return response()->json([
                'translatedText' => $text,
                'error' => 'Translation service temporarily unavailable',
                'message' => $e->getMessage(),
                'source' => $source,
                'target' => $target
            ], 200); // Return 200 with original text to avoid breaking the UI
        }
    }

    /**
     * Get translation usage information
     */
    public function usage()
    {
        try {
            $usage = $this->deepLService->getUsage();
            return response()->json($usage);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not retrieve usage'], 500);
        }
    }

    /**
     * Get supported languages
     */
    public function languages()
    {
        try {
            $languages = $this->deepLService->getSupportedLanguages();
            return response()->json($languages);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not retrieve languages'], 500);
        }
    }

    /**
     * Test endpoint for debugging
     */
    public function test()
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'Translation controller is working',
            'api_key_configured' => config('deepl.api_key') ? 'Yes' : 'No',
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Check if text contains HTML
     *
     * @param string $text
     * @return bool
     */
    protected function containsHtml(string $text)
    {
        return preg_match('/<[^<]+>/', $text) === 1;
    }
}