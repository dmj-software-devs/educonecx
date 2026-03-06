<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        
        // IMPORTANT: Check if translations is an array
        if (!is_array($translations)) {
            // Log the error for debugging
            Log::warning("Translation file for {$file} in locale {$locale} did not return an array");
            return $key;
        }
        
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
        
        // If cache exists and is an array, use it
        if ($translations !== null && is_array($translations)) {
            self::$translations[$locale][$file] = $translations;
            return $translations;
        }
        
        // Load from file for requested locale
        $path = resource_path("lang/{$locale}/{$file}.php");
        $translations = self::loadFileFromPath($path);
        
        // If file doesn't exist or is not valid, fall back to English
        if (!is_array($translations) || empty($translations)) {
            $fallbackPath = resource_path("lang/en/{$file}.php");
            $translations = self::loadFileFromPath($fallbackPath);
        }
        
        // If still not valid, return empty array
        if (!is_array($translations)) {
            $translations = [];
        }
        
        // Cache for 24 hours
        Cache::put($cacheKey, $translations, now()->addDay());
        
        // Store in memory
        self::$translations[$locale][$file] = $translations;
        
        return $translations;
    }

    /**
     * Load a translation file from a specific path
     *
     * @param string $path
     * @return array
     */
    protected static function loadFileFromPath(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }
        
        try {
            $loaded = require $path;
            
            // Check if what we got is an array
            if (is_array($loaded)) {
                return $loaded;
            }
            
            // Log the error for debugging
            Log::warning("Translation file at {$path} did not return an array. Got: " . gettype($loaded));
            
            return [];
        } catch (\Throwable $e) {
            Log::error("Error loading translation file at {$path}: " . $e->getMessage());
            return [];
        }
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