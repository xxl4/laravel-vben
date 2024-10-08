<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

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
                    'Content-Type' => 'application/x-www-formurlencoded',
                    'charset' => 'utf-8'
                ],
                'debug' => config('app.debug')
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

        $token = Cache::get('mediaGo_token');
        if($token) {
            return $token;
        }

        $response = $this->client->post('data/v1/authentication', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Charset' => 'utf-8',
                'Authorization' => 'Basic ' . base64_encode(config('platform.mediago.token')),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        //var_dump($data);

        Cache::put('mediaGo_token', $data['access_token'], $data['expires_in']);

        return $data['access_token'];


        return base64_encode(config('platform.mediago.token'));
        return config('platform.mediago.token');
    }

    public function getCampaigns()
    {

    }

    public function getCampaign($campaign_id)
    {

    }

    /**
     * createCampaign
     * 
     * Create a campaign
     * 
     * @param array $params
     * @return array
     * 
     * 
     * 
     */
    public function createCampaign($params = [])
    {
        $token = $this->getToken();
        if(!$token) {
            return [];
        }

        $params['adAccountId'] = $this->getPlatformAccountId();
        $params['pageNo'] = $params['page'] ?? 1;
        $params['pageSize'] = $params['page_size'] ?? 10;
        
        try {
            $response = $this->client->post('/manage/v1/campaign/create', [
                'headers' => [
                    'Authorization' => "Bearer ".$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $params
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

    // update campaign
    public function updateCampaign($campaign_id, $params = [])
    {

        $token = $this->getToken();
        if(!$token) {
            return [];
        }

        try {
            $response = $this->client->post('/manage/v1/campaign/update', [
                'headers' => [
                    'Authorization' => "Bearer ".$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        }catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];

            return $data;
        }

    }

    // delete campaign
    public function deleteCampaign($campaign_id)
    {
        // don't support delete campaign
        return [];
    }

    public function getCampaignItems($campaign_id)
    {

    }

    public function getReports()
    {
        $response = $this->client->get('data/v1/report/summary', [
            'query' => [
                'start_date' => '2024-08-01',
                'end_date' => '2024-08-20',
                'timezone' => 'est',
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        //var_dump($data);

        return $data;

    }



}