<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;

class MediaGo implements PlatformInterface
{
    protected $client;

    public function __construct($params = [])
    {
        if(empty($client)) {
            $this->client = new Client([
                'base_uri' => $this->getPlatformApiUrl(),
                'timeout'  => 60,
                'allow_redirects' => true,
                'http_errors' => true,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'debug' => true
            ]);
        } 
    }

    public function getPlatformName()
    {
        return 'mediago';
    }

    public function getPlatformUrl()
    {
        return config('platform.mediago.url');
    }

    public function getPlatformApiUrl()
    {
        return config('platform.mediago.api_url');
    }

    public function getPlatformClientId()
    {
        return config('platform.mediago.client_id');
    }

    public function getPlatformClientSecret()
    {
        return config('platform.mediago.client_secret');
    }

    public function getPlatformAccountId()
    {
        return config('platform.mediago.account_id');
    }

    public function getToken()
    {
        return 'mediago_token';
    }
}