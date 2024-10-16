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
                'debug' => config('app.debug')
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

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

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

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

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

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * createCampaign
     * 
     * @param $data
     * @return array
     * 
     * @throws \Exception
     * 
     * {
  "name": "new campaign 01",
  "cpc": 0.01,
  "branding_text": "Pizza",
  "spending_limit": 100000,
  "spending_limit_model": "MONTHLY",
  "marketing_objective": "DRIVE_WEBSITE_TRAFFIC"
}
     * 
     * Create Campaign
     * 
     * @link https://developers.taboola.com/backstage-api/reference/create-a-campaign
     */
    public function createCampaign($data) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->post('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * updateCampaign
     * 
     * @param $campaign_id
     * @param $data
     * @return array
     * 
     * @throws \Exception
     * 
     * {
     * "name": "new campaign 01",
     * "cpc": 0.01,
     * "branding_text": "Pizza",
     * "spending_limit": 100000,
     * "spending_limit_model": "MONTHLY",
     * "marketing_objective": "DRIVE_WEBSITE_TRAFFIC"
     * }
     * 
     * Update Campaign
     * 
     * @link https://developers.taboola.com/backstage-api/reference/update-a-campaign
     */

    public function updateCampaign($campaign_id, $data) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->put('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * deleteCampaign
     * 
     * @param $campaign_id
     * @return array
     * 
     * @throws \Exception
     * 
     * Delete Campaign
     * 
     * @link https://developers.taboola.com/backstage-api/reference/delete-a-campaign
     */

    public function deleteCampaign($campaign_id) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->delete('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * createCampaignItem
     * 
     * @param $campaign_id
     * @param $data
     * @return array
     * 
     * @throws \Exception
     * 
     * {
            "campaign_id": "42654912",
            "type": "ITEM",
            "url": "https://newamc.com/article/property-valuation-made-easy-use-home-calculators-to-understand-your-assets?key=t39z98jjndkz4c1scebp&tracking_id=$%7BTRACKING_ID%7D&channel=12345&utm_source=$%7BPUBLISHER_NAME%7D&utm_medium=Display&utm_content=$%7BAD_TITLE%7D&asset-id=$%7BASSET_ID%7D&ad-asset-name=$%7BAD_ASSET_NAME%7D&ad-id=$%7BAD_ID%7D&cpc=$%7BCPC%7D&utm_campaign=$%7BCAMPAIGN_NAME%7D&utm_term=$%7BCONTENT_NAME%7D",
            "thumbnail_url": "http://cdn.taboola.com/libtrc/static/thumbnails/IMAGE_UPSCALER/EIU/3668bc03-196c-4489-8e5c-decc89320cdf__r8LxXGIz.jpg",
            "title": "new campaign item 01",
            "description": null,
            "approval_state": "PENDING",
            "is_active": false,
            "status": "PENDING_APPROVAL",
            "policy_review": {
                "reject_reason": null,
                "reject_reason_description": null,
                "status_reason": null,
                "reviewer_notes": null
            },
            "cta": null,
            "creative_focus": {
                "type": "AUTOMATIC",
                "coordinates": null
            },
            "verification_pixel": null,
            "viewability_tag": null,
            "app_install": null,
            "rating": null,
            "logo": null,
            "disclaimer": null,
            "creative_crop": null,
            "performance_video_data": null,
            "hierarchy_rep_item_id": null,
            "hierarchy_data": null,
            "custom_data": {
                "creative_name": null,
                "custom_id": null
            },
            "start_date": null,
            "end_date": null,
            "activity_schedule": null
     * }
     * 
     * Create Campaign Item
     * 
     * @link https://developers.taboola.com/backstage-api/reference/create-a-campaign-item
     */
    public function createCampaignItem($campaign_id, $data) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->post('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id.'/items', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * updateCampaignItem
     * 
     * @param $campaign_id
     * @param $campaign_item_id
     * @param $data
     * @return array
     * 
     * @throws \Exception
     * 
     * {
            "campaign_id": "42654912",
            "type": "ITEM",
            "url": "https://newamc.com/article/property-valuation-made-easy-use-home-calculators-to-understand-your-assets?key=t39z98jjndkz4c1scebp&tracking_id=$%7BTRACKING_ID%7D&channel=12345&utm_source=$%7BPUBLISHER_NAME%7D&utm_medium=Display&utm_content=$%7BAD_TITLE%7D&asset-id=$%7BASSET_ID%7D&ad-asset-name=$%7BAD_ASSET_NAME%7D&ad-id=$%7BAD_ID%7D&cpc=$%7BCPC%7D&utm_campaign=$%7BCAMPAIGN_NAME%7D&utm_term=$%7BCONTENT_NAME%7D",
            "thumbnail_url": "http://cdn.taboola.com/libtrc/static/thumbnails/IMAGE_UPSCALER/EIU/3668bc03-196c-4489-8e5c-decc89320cdf__r8LxXGIz.jpg",
            "title": "new campaign item 01",
            "description": null,
            "approval_state": "PENDING",
            "is_active": false,
            "status": "PENDING_APPROVAL",
            "policy_review": {
                "reject_reason": null,
                "reject_reason_description": null,
                "status_reason": null,
                "reviewer_notes": null
            },
            "cta": null,
            "creative_focus": {
                "type": "AUTOMATIC",
                "coordinates": null
            },
            "verification_pixel": null,
            "viewability_tag": null,
            "app_install": null,
            "rating": null,
            "logo": null,
            "disclaimer": null,
            "creative_crop": null,
            "performance_video_data": null,
            "hierarchy_rep_item_id": null,
            "hierarchy_data": null,
            "custom_data": {
                "creative_name": null,
                "custom_id": null
            },
            "start_date": null,
            "end_date": null,
            "activity_schedule": null
     * }
     * 
     * Update Campaign Item
     * 
     * @link https://developers.taboola.com/backstage-api/reference/update-a-campaign-item
     */
    public function updateCampaignItem($campaign_id, $campaign_item_id, $data) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->put('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id.'/items/'.$campaign_item_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    /**
     * deleteCampaignItem
     * 
     * @param $campaign_id
     * @param $campaign_item_id
     * @return array
     * 
     * @throws \Exception
     * 
     * Delete Campaign Item
     * 
     * @link https://developers.taboola.com/backstage-api/reference/delete-a-campaign-item
     */
    public function deleteCampaignItem($campaign_id, $campaign_item_id) {
        $token = $this->getToken();

        try {
            
            $response = $this->client->delete('backstage/api/1.0/'.$this->getPlatformAccountId().'/campaigns/'.$campaign_id.'/items/'.$campaign_item_id, [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;

        }
    }

    public function getReports($query = [])
    {
        $token = $this->getToken();

        try {
                
                $response = $this->client->get('backstage/api/1.0/'.$this->getPlatformAccountId().'/reports/campaign-summary/dimensions/day', [
                    'headers' => [
                        'Authorization' => 'Bearer '.$token,
                        'Content-Type' => 'application/json'
                    ],
                    'query' => $query
                ]);

                $data = json_decode($response->getBody(), true);

                return $data;
        }catch (\Exception $e) {

            $error = [];
            $error['error']['message'] = $e->getMessage();
            $error['error']['code'] = $e->getCode();
            return $error;
        }


    }
}