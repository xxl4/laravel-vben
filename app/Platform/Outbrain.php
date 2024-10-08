<?php

namespace App\Platform;

use App\Platform\PlatformInterface;
use GuzzleHttp\Client;

class Outbrain implements PlatformInterface
{
    protected $client;

    protected $params = [];

    protected $api_prefix = '/amplify/v0.1';

    public function __construct($params = [])
    {
        if(empty($client)) {
            $this->client = new Client([
                'base_uri' => $this->getPlatformApiUrl().$this->api_prefix,
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
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // Get Supported Languages From Api
    // @link https://amplifyv01.docs.apiary.io/#reference/geo-locations/retrieve-all-supported-languages/retrieve-all-supported-language
    public function getSupportLanguages() {
        try {

            $response = $this->client->get('/amplify/v0.1/metadata/supportedLanguages', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // Create Campaign
    // @param array $params
    // @return array
    // @link https://amplifyv01.docs.apiary.io/#reference/campaigns/campaigns/create-a-new-campaign
    /**
     * 
     * 
     * @param array $params
     * 
     * {
  "name": "new campaign 01",
  "cpc": 0.05,
  "enabled": true,
  "budgetId": "0027a7068fc5da2b40c8356b5fd3352c41",
  "targeting": {
    "platform": [
      "DESKTOP",
      "MOBILE"
    ],
    "locations": [
      "567c6368ea1c2697aeb72e3a6e117967"
    ],
    "operatingSystems": [
      "MacOs",
      "Windows"
    ],
    "browsers": [
      "Chrome"
    ],
    "language": "EN"
  },
  "suffixTrackingCode": "utm_source=outb&utm_medium=cpc&utm_campaign=abc%20def",
  "feeds": [
    "http://myfeedurl.com/feed/first",
    "http://myfeedurl.com/feed/another"
  ],
  "bids": {
    "bySection": [
      {
        "sectionId": "000620da8a5a58f0a0a835f896392080dd",
        "cpcAdjustment": 0.1
      }
    ]
  },
  "onAirType": "Scheduled",
  "scheduling": {
    "cpc": [
      {
        "startDay": "Sunday",
        "endDay": "Monday",
        "startHour": 3,
        "endHour": 1,
        "cpcAdjustment": 0.1
      }
    ],
    "onAir": [
      {
        "startDay": "Sunday",
        "endDay": "Sunday",
        "startHour": 8,
        "endHour": 12
      }
    ]
  },
  "objective": "Awareness",
  "creativeFormat": "Standard"
}
     * 
     * 
     */
    public function createCampaign($params) {
        try {

            $response = $this->client->post('/amplify/v0.1/campaigns', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'query' => [
                    'extraFields' => 'CustomAudience,Locations,InterestsTargeting,BidBySections,BlockedSites,PlatformTargeting,CampaignOptimization,Scheduling,IABCategories,CampaignPixels',
                ],
                'json' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // Delete Campaign
    // @param string $campaignId
    // @return array
    public function deleteCampaign($campaignId) {
        try {

            $response = $this->client->delete('/amplify/v0.1/campaigns/'.$campaignId, [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // Get Marketers
    public function getMarketers($params = []) {
        try {

            $response = $this->client->get('/amplify/v0.1/marketers', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // Create Marketer Conversion
    //@link https://amplifyv01.docs.apiary.io/#reference/multiple-conversions/conversion-event/create-a-conversion-event
    public function createMarketerConversion($marketerId, $params = []) {
        try {

            $response = $this->client->post('/amplify/v0.1/marketers/'.$marketerId.'/conversionEvents', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'json' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // getMarketerConversions
    public function getMarketerConversions($marketerId, $params = []) {
        try {

            $response = $this->client->get('/amplify/v0.1/marketers/'.$marketerId.'/conversionEvents', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // getMarketerBudgets
    // @link https://amplifyv01.docs.apiary.io/#reference/budgets/budgets-collection/list-budgets-for-a-marketer
    public function getMarketerBudgets($marketerId, $params = []) {
        try {

            $response = $this->client->get('/amplify/v0.1/marketers/'.$marketerId.'/budgets', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // createMarketerBudget
    //@link https://amplifyv01.docs.apiary.io/#reference/budgets/budgets-collection/create-a-budget-for-a-marketer
    public function createMarketerBudget($marketerId, $params = []) {
        try {

            $response = $this->client->post('/amplify/v0.1/marketers/'.$marketerId.'/budgets', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'json' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }

    // getSections
    // @link https://amplifyv01.docs.apiary.io/#reference/sections/sections-collection-response/list-all-metadata-for-section-ids
    public function getSections($params = []) {
        try {

            $response = $this->client->post('/amplify/v0.1/sections', [
                'headers' => [
                    'OB-TOKEN-V1' => $this->getToken()
                ],
                'json' => $params
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e) {
            $error = [];
            $error['message'] = $e->getMessage();
            $error['code'] = $e->getCode();
            return $error;
        }
    }
        


}