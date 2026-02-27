<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    /**
     * Switch language and redirect back or return JSON for AJAX
     *
     * @param  string  $lang
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function switch($lang)
    {
        // Validate language
        $supportedLanguages = ['en', 'es', 'fr', 'de', 'it', 'pt', 'nl', 'pl', 'ru', 'ja', 'zh'];
        
        if (!in_array($lang, $supportedLanguages)) {
            $lang = 'en';
        }
        
        // Set locale in session and cookie
        Session::put('locale', $lang);
        Cookie::queue('locale', $lang, 60 * 24 * 30); // 30 days
        
        // Set application locale
        App::setLocale($lang);
        
        // If AJAX request, return JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'language' => $lang,
                'message' => 'Language changed successfully'
            ]);
        }
        
        // Otherwise redirect back
        return redirect()->back()->with('success', __('Language changed successfully!'));
    }
    
    /**
     * Get current language info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentLanguage()
    {
        $currentLang = App::getLocale();
        
        $languages = [
            'en' => ['name' => 'English', 'flag' => '🇺🇸', 'native' => 'English'],
            'es' => ['name' => 'Spanish', 'flag' => '🇪🇸', 'native' => 'Español'],
            'fr' => ['name' => 'French', 'flag' => '🇫🇷', 'native' => 'Français'],
            'de' => ['name' => 'German', 'flag' => '🇩🇪', 'native' => 'Deutsch'],
            'it' => ['name' => 'Italian', 'flag' => '🇮🇹', 'native' => 'Italiano'],
            'pt' => ['name' => 'Portuguese', 'flag' => '🇵🇹', 'native' => 'Português'],
            'nl' => ['name' => 'Dutch', 'flag' => '🇳🇱', 'native' => 'Nederlands'],
            'pl' => ['name' => 'Polish', 'flag' => '🇵🇱', 'native' => 'Polski'],
            'ru' => ['name' => 'Russian', 'flag' => '🇷🇺', 'native' => 'Русский'],
            'ja' => ['name' => 'Japanese', 'flag' => '🇯🇵', 'native' => '日本語'],
            'zh' => ['name' => 'Chinese', 'flag' => '🇨🇳', 'native' => '中文'],
        ];
        
        return response()->json([
            'current' => $currentLang,
            'info' => $languages[$currentLang] ?? $languages['en'],
            'all' => $languages
        ]);
    }
}