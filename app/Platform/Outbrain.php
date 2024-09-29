<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;

class Outbrain implements PlatformInterface
{
    protected $client;

    protected $params = [];



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

    public function getPlatformClientSecret()
    {
        return config('platform.outbrain.client_secret');
    }

    public function getPlatformClientId()
    {
        return config('platform.outbrain.client_id');
    }

    public function getToken()
    {
        return $this->getPlatformToken();
    }

    public function getCampaigns()
    {
        try {

            $response = $this->client->get('/amplify/v0.1/campaigns', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'query' => [
                    'extraFields' => 'ALL',
                ]
            ]);
    
            return json_decode($response->getBody()->getContents(), true);


        }catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getReports($params = [])
    {
        try {

            $response = $this->client->get('/amplify/v0.1/reports/custom', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'query' => [
                    'extraFields' => 'ALL',
                    'startDate' => $params['startDate'],
                    'endDate' => $params['endDate'],
                    'groupBy' => $params['groupBy'],
                    'metrics' => $params['metrics'],
                    'filters' => $params['filters'],
                    'format' => 'json',
                ]
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getGeoLocations($params = [])
    {
        try {

            $response = $this->client->get('/amplify/v0.1/locations/search', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'query' => [
                    'term' => isset($params['term']) ? $params['term'] : '',
                    'limit' => isset($params['limit']) ? $params['limit'] : 10,
                    'include' => isset($params['include']) ? $params['include'] : 'Region',
                    //'exclude' => isset($params['exclude']) ? $params['exclude'] : 'Country',
                    //'country' => isset($params['country']) ? $params['country'] : '',
                    'locationsVersion' => isset($params['locationsVersion']) ? $params['locationsVersion'] : 'V2',
                    'exactMatch' => isset($params['exactMatch']) ? $params['exactMatch'] : true,
                ]
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            return $e->getMessage();
        }
    }
        


}