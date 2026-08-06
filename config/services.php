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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'recaptcha' => [
        'site_key' => env('APP_ENV') === 'local'
            ? env('RECAPTCHA_SITE_KEY_LOCAL', env('RECAPTCHA_SITE_KEY', '6LeoNnctAAAAAKR5jGB0E8YWYZe7eJWvC9iIQpxc'))
            : env('RECAPTCHA_SITE_KEY', '6LeoNnctAAAAAKR5jGB0E8YWYZe7eJWvC9iIQpxc'),
        'site_key_local' => env('RECAPTCHA_SITE_KEY_LOCAL', '6LeoNnctAAAAAKR5jGB0E8YWYZe7eJWvC9iIQpxc'),
        'secret' => env('RECAPTCHA_SECRET'),
    ],

];
