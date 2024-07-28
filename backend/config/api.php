<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Here you may configure the rate limit settings for your API routes.
    | These settings control the maximum number of requests that can be
    | made to your API within a given time period.
    |
    */

    'rate_limits' => [
        'api' => [
            'limit' => 60, // Number of requests
            'expires' => 1, // Time period in minutes
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Authentication Settings
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings for API authentication, including
    | the use of OAuth via Laravel Passport and other related settings.
    |
    */

    'auth' => [
        'passport' => [
            'client_id' => env('PASSPORT_CLIENT_ID', 'your-client-id'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET', 'your-client-secret'),
            'redirect_uri' => env('PASSPORT_REDIRECT_URI', 'your-redirect-uri'),
        ],
    ],
];
