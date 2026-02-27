<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DeepL API Key
    |--------------------------------------------------------------------------
    |
    | Your DeepL API authentication key. The :fx suffix indicates the free API.
    |
    */
    'api_key' => env('DEEPL_API_KEY', 'f157d5fb-8af7-46d3-afb0-438af5a55bc1:fx'),
    
    /*
    |--------------------------------------------------------------------------
    | DeepL API URL
    |--------------------------------------------------------------------------
    |
    | The API URL for DeepL. Use different URLs for free vs pro accounts.
    |
    */
    'api_url' => env('DEEPL_API_URL', 'https://api-free.deepl.com/v2'),
    
    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | List of languages your application supports for translation.
    |
    */
    'supported_languages' => ['en', 'es', 'fr', 'de', 'it', 'pt', 'nl', 'pl', 'ru', 'ja', 'zh'],
];