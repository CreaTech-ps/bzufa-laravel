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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'lahza' => [
        'payment_page_url' => env('LAHZA_PAYMENT_PAGE_URL'),
        'public_key' => env('LAHZA_PUBLIC_KEY'),
        'secret_key' => env('LAHZA_SECRET_KEY'),
        'page_id' => env('LAHZA_PAGE_ID'),
        'checkout_url' => env('LAHZA_CHECKOUT_URL', 'https://pay.lahza.io'),
        'api_base_url' => env('LAHZA_API_BASE_URL', 'https://api.lahza.io'),
        'webhook_secret' => env('LAHZA_WEBHOOK_SECRET'),
        'success_url' => env('LAHZA_SUCCESS_URL'),
        'cancel_url' => env('LAHZA_CANCEL_URL'),
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

];
