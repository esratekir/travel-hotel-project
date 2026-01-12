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

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    
    'facebook' => [
        'client_id' => '1101350461239783',
        'client_secret' => 'ed1692becf822f48c7cba5471e94bcaf',
        'redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],

    'vkontakte' => [
        'client_id' => '51780520',
        'client_secret' => 'U6J8ImvHoniFn5l8UT7I',
        'secret_key' => 'd6d58f4bd6d58f4bd6d58f4b0ed5c394e3dd6d5d6d58f4bb3e93d43af87d86f78d52f0b',
        'redirect' => 'http://localhost:8000/auth/vkontakte/callback',
    ],

];
