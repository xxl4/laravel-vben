<?php
/**
 * 
 * platform configuration
 * 
 * 
 */
return [

    'NewsBreak' => [
        'name' => 'NewsBreak',
        'url' => 'https://www.newsbreak.com',
        'api_url' => 'https://api.newsbreak.com',
        'token' => env('NEWSBREAK_TOKEN', '')
    ],
    'mediago' => [
        'name' => 'mediago',
        'url' => 'https://www.mediago.com',
        'api_url' => 'https://api.mediago.com',
        'token' => env('MEDIAGO_TOKEN', '')
    ],
    'taboola' => [
        'name' => 'taboola',
        'url' => 'https://www.taboola.com',
        'api_url' => 'https://backstage.taboola.com/backstage/api/1.0',
        'client_id' => env('TABOOLA_Client_ID', ''),
        'client_secret' => env('TABOOLA_Client_Secret', ''),
        'account_id' => env('TABOOLA_Account_ID', ''),
    ],

];
