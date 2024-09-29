<?php
/**
 * 
 * platform configuration
 * 
 * 
 */
return [

    'newsbreak' => [
        'name' => 'NewsBreak',
        'url' => 'https://www.newsbreak.com',
        'api_url' => 'https://business.newsbreak.com',
        'token' => env('NEWSBREAK_TOKEN', ''),
        'account_id' => env('NEWSBREAK_ACCOUNT_ID', ''),
    ],
    'mediago' => [
        'name' => 'mediago',
        'url' => 'https://www.mediago.com',
        'api_url' => 'https://api.mediago.io',
        'token' => env('MEDIAGO_TOKEN', ''),
        'account_id' => env('MEDIAGO_ACCOUNT_ID', '')
    ],
    'taboola' => [
        'name' => 'taboola',
        'url' => 'https://backstage.taboola.com',
        'api_url' => 'https://backstage.taboola.com/backstage/api/1.0',
        'client_id' => env('TABOOLA_Client_ID', ''),
        'client_secret' => env('TABOOLA_Client_Secret', ''),
        'account_id' => env('TABOOLA_Account_ID', ''),
    ],
    'outbrain' => [
        'name' => 'outbrain',
        'url' => 'https://my.outbrain.com',
        'api_url' => 'https://api.outbrain.com',
        'token' => env('OUTBRAIN_TOKEN', ''),
        'account_id' => env('OUTBRAIN_ACCOUNT_ID', ''),
    ],

];
