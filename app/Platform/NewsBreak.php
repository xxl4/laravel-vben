<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;


class NewsBreak implements PlatformInterface
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

    public function getBaseUrl()
    {
        return config('platform.newsbreak.url');
    }

    public function getPlatformName()
    {
        return 'newsbreak';
    }

    public function getPlatformUrl()
    {
        return config('platform.newsbreak.url');
    }

    public function getPlatformApiUrl()
    {
        return config('platform.newsbreak.api_url');
    }

    public function getPlatformClientId()
    {
        return config('platform.newsbreak.client_id');
    }

    public function getPlatformClientSecret()
    {
        return config('platform.newsbreak.client_secret');
    }

    public function getPlatformAccountId()
    {
        return config('platform.newsbreak.account_id');
    }

    public function getToken()
    {
        return config('platform.newsbreak.token');
    }

    public function getPlatformToken()
    {
        return config('platform.newsbreak.token');
    }

    public function getCampaigns($params = []){
        $token = $this->getToken();
        if(!$token) {
            return [];
        }

        $params['adAccountId'] = $this->getPlatformAccountId();
        $params['pageNo'] = $params['page'] ?? 1;
        $params['pageSize'] = $params['page_size'] ?? 10;
        
        try {
            $response = $this->client->get('/business-api/v1/campaign/getList', [
                'headers' => [
                    'Access-Token' => $token,
                    'Content-Type' => 'application/json'
                ],
                'query' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            

            $data = [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];

            return $data;

        }
    }

    public function getAdsets($params = []){
        $token = $this->getToken();
        if(!$token) {
            return [];
        }

        $params['adAccountId'] = $this->getPlatformAccountId();
        $params['pageNo'] = $params['page'] ?? 1;
        $params['pageSize'] = $params['page_size'] ?? 10;
        
        try {
            $response = $this->client->get('/business-api/v1/adset/getList', [
                'headers' => [
                    'Access-Token' => $token,
                    'Content-Type' => 'application/json'
                ],
                'query' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            

            $data = [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];

            return $data;

        }
    }
}