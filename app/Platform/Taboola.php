<?php
namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Taboola implements PlatformInterface
{

    protected $client;


    public function __construct($params = [])
    {
        if(empty($client)) {
            $this->client = new Client([
                'base_uri' => $this->getBaseUrl(),
                'timeout'  => 60,
                'allow_redirects' => true,
                'http_errors' => true,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'debug' => $params['debug'] ?? false
            ]);
        } 
    }

    public function getBaseUrl()
    {
        return config('platform.taboola.url');
    }

    public function getPlatformName()
    {
        return 'taboola';
    }

    public function getPlatformUrl()
    {
        return config('platform.taboola.url');
    }

    public function getPlatformApiUrl()
    {
        return config('platform.taboola.api_url');
    }

    public function getPlatformClientId()
    {
        return config('platform.taboola.client_id');
    }

    public function getPlatformClientSecret()
    {
        return config('platform.taboola.client_secret');
    }

    public function getPlatformAccountId()
    {
        return config('platform.taboola.account_id');
    }

    public function getToken()
    {
        // Token from cache
        $token = Cache::get('taboola_token');
        if($token) {
            return $token;
        }
        $response = $this->client->post('backstage/oauth/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'client_id' => $this->getPlatformClientId(),
                'client_secret' => $this->getPlatformClientSecret(),
                'grant_type' => 'client_credentials'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        Cache::put('taboola_token', $data['access_token'], $data['expires_in']);


        return $data['access_token'];
    }

    /**
     * 
     * Get Campaigns
     */
    public function getCampaigns()
    {
        $token = $this->getToken();

        try {
            
            $response = $this->client->get('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/?fetch_level=R', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $data = [];
            $data['error'] = $e->getMessage();
            $data['code'] = $e->getCode();
            
            return $data;

        }
    }

    /**
     * 
     * Get Campaign
     */
    public function getCampaign($campaign_id)
    {
        $token = $this->getToken();

        try {
            
            $response = $this->client->get('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $data = [];
            $data['error'] = $e->getMessage();
            $data['code'] = $e->getCode();
            
            return $data;

        }
    }

    /**
     * 
     * Get Campaign Items
     */
    public function getCampaignItems($campaign_id) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->get('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id.'/items', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $data = [];
            $data['error'] = $e->getMessage();
            $data['code'] = $e->getCode();
            
            return $data;

        }
    }
}