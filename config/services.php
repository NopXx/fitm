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

    'ipinfo' => [
        'token' => env('IPINFO_TOKEN'),
        // limit lookups per aggregation run to avoid timeouts
        'max_lookups' => env('IPINFO_MAX_LOOKUPS', 100),
    ],

    // Analytics retention and rollup options
    'visitor_analytics' => [
        // Keep daily totals this many months (default 8)
        'retain_daily_months' => env('VISITOR_RETAIN_DAILY_MONTHS', 8),
        // Keep daily pages/regional breakdown this many months (default 8)
        'retain_pages_daily_months' => env('VISITOR_RETAIN_PAGES_DAILY_MONTHS', 8),
        'retain_regions_daily_months' => env('VISITOR_RETAIN_REGIONS_DAILY_MONTHS', 8),
    ],

];
