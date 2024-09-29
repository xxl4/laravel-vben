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
                    'charset' => 'utf-8',
                    'Authorization' => 'Bearer ' . $this->getToken(),
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