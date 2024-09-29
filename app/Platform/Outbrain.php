<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;

class Outbrain implements PlatformInterface
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
                'debug' => config('app.debug')
            ]);
        } 
    }

    public function getBaseUrl()
    {
        return config('platform.outbrain.url');
    }

    public function getPlatformName()
    {
        return 'outbrain';
    }

    public function getPlatformUrl()
    {
        return config('platform.outbrain.url');
    }

    public function getPlatformApiUrl()
    {
        return config('platform.outbrain.api_url');
    }

    public function getPlatformToken()
    {
        return config('platform.outbrain.token');
    }

    public function getPlatformAccountId()
    {
        return config('platform.outbrain.account_id');
    }

    public function getToken()
    {
        return $this->getPlatformToken();
    }
}