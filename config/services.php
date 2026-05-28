<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

     'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],



    'heygen' => [
        'api_key' => env('HEYGEN_API_KEY'),
        'liveavatar_api_key' => env('LIVEAVATAR_API_KEY'),
        'base_url' => env('HEYGEN_BASE_URL', 'https://api.heygen.com'),
        'streaming_token_endpoint' => env('HEYGEN_STREAMING_TOKEN_ENDPOINT', '/v1/streaming.create_token'),
        'streaming_start_endpoint' => env('HEYGEN_STREAMING_START_ENDPOINT', '/v1/streaming.start'),
        'default_avatar_id' => env('HEYGEN_DEFAULT_AVATAR_ID', env('HEYGEN_AVATAR_ID')),
        'default_voice_id' => env('HEYGEN_DEFAULT_VOICE_ID', env('HEYGEN_VOICE_ID')),
        'default_context_id' => env('HEYGEN_DEFAULT_CONTEXT_ID', env('HEYGEN_CONTEXT_ID')),
    ],
];
