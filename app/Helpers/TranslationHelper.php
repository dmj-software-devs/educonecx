<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class TranslationHelper
{
    /**
     * Available languages
     */
    const LANGUAGES = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
    ];

    /**
     * Language flags
     */
    const FLAGS = [
        'en' => '🇺🇸',
        'es' => '🇪🇸',
        'fr' => '🇫🇷',
    ];

    /**
     * Language codes for display
     */
    const CODES = [
        'en' => 'EN',
        'es' => 'ES',
        'fr' => 'FR',
    ];

    /**
     * Default language
     */
    const DEFAULT = 'en';

    /**
     * Cache loaded translations
     */
    protected static $translations = [];

    /**
     * Get translation for a key
     *
     * @param string $key
     * @param array $replace
     * @param string|null $locale
     * @return string
     */
    public static function trans(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        
        // Parse key (e.g., "header.home" or "common.brand_name")
        $parts = explode('.', $key);
        $file = $parts[0];
        $transKey = $parts[1] ?? null;
        
        if (!$transKey) {
            return $key;
        }
        
        // Load translation file
        $translations = self::loadFile($file, $locale);
        
        // Get translation
        $translation = $translations[$transKey] ?? $key;
        
        // Replace placeholders
        foreach ($replace as $search => $replaceValue) {
            $translation = str_replace(":{$search}", $replaceValue, $translation);
        }
        
        return $translation;
    }

    /**
     * Load translation file
     *
     * @param string $file
     * @param string $locale
     * @return array
     */
    protected static function loadFile(string $file, string $locale): array
    {
        // Check if already loaded in memory
        if (isset(self::$translations[$locale][$file])) {
            return self::$translations[$locale][$file];
        }
        
        // Try cache first
        $cacheKey = "translations.{$locale}.{$file}";
        $translations = Cache::get($cacheKey);
        
        if ($translations === null) {
            // Load from file
            $path = resource_path("lang/{$locale}/{$file}.php");
            
            if (file_exists($path)) {
                $translations = require $path;
            } else {
                // Fallback to English
                $fallbackPath = resource_path("lang/en/{$file}.php");
                $translations = file_exists($fallbackPath) ? require $fallbackPath : [];
            }
            
            // Cache for 24 hours
            Cache::put($cacheKey, $translations, now()->addDay());
        }
        
        // Store in memory
        self::$translations[$locale][$file] = $translations;
        
        return $translations;
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public static function getLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Get language flag
     *
     * @param string|null $locale
     * @return string
     */
    public static function getFlag(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return self::FLAGS[$locale] ?? self::FLAGS[self::DEFAULT];
    }

    /**
     * Get language code for display
     *
     * @param string|null $locale
     * @return string
     */
    public static function getCode(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return self::CODES[$locale] ?? self::CODES[self::DEFAULT];
    }

    /**
     * Get all languages for dropdown
     *
     * @return array
     */
    public static function getLanguages(): array
    {
        $languages = [];
        foreach (self::LANGUAGES as $code => $name) {
            $languages[$code] = [
                'name' => $name,
                'flag' => self::FLAGS[$code],
                'code' => self::CODES[$code],
                'native' => self::getNativeName($code)
            ];
        }
        return $languages;
    }

    /**
     * Get native language name
     *
     * @param string $code
     * @return string
     */
    protected static function getNativeName(string $code): string
    {
        return match($code) {
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            default => 'English'
        };
    }
}