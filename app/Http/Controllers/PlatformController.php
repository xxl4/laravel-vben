<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlatformController extends Controller
{
    
    public function getToken($platform) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $token = $platform->getToken();
        $data = [
            'token' => $token
        ];
        return $this->success('success',$data);
    }

    public function getCampaigns($platform) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaigns = $platform->getCampaigns();

        if(isset($campaigns['error'])) {
            return $this->fails($campaigns['error']['message'], $campaigns['error']['code']);
        }

        $data = [
            'campaigns' => $campaigns
        ];
        return $this->success('success',$data);
    }

    public function getCampaign($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->getCampaign($campaign_id);

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    public function getCampaignItems($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaignItems = $platform->getCampaignItems($campaign_id);

        if(isset($campaignItems['error'])) {
            return $this->fails($campaignItems['error']['message'], $campaignItems['error']['code']);
        }

        $data = [
            'campaignItems' => $campaignItems
        ];
        return $this->success('success',$data);
    }

    // Get Reports from platform

    public function getReports($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $reports = $platform->getReports($request->all());

        if(isset($reports['error'])) {
            return $this->fails($reports['error']['message'], $reports['error']['code']);
        }

        $data = [
            'reports' => $reports
        ];
        return $this->success('success',$data);
    }

    // Get Geo Locations from platform
    public function getGeoLocations($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $geoLocations = $platform->getGeoLocations($request->all());

        if(isset($geoLocations['error'])) {
            return $this->fails($geoLocations['error']['message'], $geoLocations['error']['code']);
        }

        $data = [
            'geoLocations' => $geoLocations
        ];
        return $this->success('success',$data);
    }

    // Get Support Languages from platform
    public function getSupportLanguages($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $supportLanguages = $platform->getSupportLanguages($request->all());

        if(isset($supportLanguages['error'])) {
            return $this->fails($supportLanguages['error']['message'], $supportLanguages['error']['code']);
        }


        $data = [
            'supportLanguages' => $supportLanguages
        ];
        return $this->success('success',$data);
    }

    // Create Campaign on platform
    public function createCampaign($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->createCampaign($request->all());

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    // Update Campaign on platform
    public function updateCampaign($platform, $campaign_id, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->updateCampaign($campaign_id, $request->all());

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    // delete Campaign on platform
    public function deleteCampaign($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->deleteCampaign($campaign_id);

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    // Campaign Pause On platform
    public function pauseCampaign($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->pauseCampaign($campaign_id);

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    // Campaign Collect On platform
    public function collectCampaign($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->collectCampaign($campaign_id);

        if(isset($campaign['error'])) {
            return $this->fails($campaign['error']['message'], $campaign['error']['code']);
        }

        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    // Campaign Collection On platform
    public function getCampaignCollections($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaignCollections = $platform->getCampaignCollections($request->all());

        if(isset($campaignCollections['error'])) {
            return $this->fails($campaignCollections['error']['message'], $campaignCollections['error']['code']);
        }

        $data = [
            'campaignCollections' => $campaignCollections
        ];
        return $this->success('success',$data);
    }

    // Campain Collection By Budget On platform
    public function getCampaignCollectionsByBudget($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaignCollections = $platform->getCampaignCollectionsByBudget($request->all());

        if(isset($campaignCollections['error'])) {
            return $this->fails($campaignCollections['error']['message'], $campaignCollections['error']['code']);
        }

        $data = [
            'campaignCollections' => $campaignCollections
        ];
        return $this->success('success',$data);
    }

    // Get Marketers from platform
    public function getMarketers($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $marketers = $platform->getMarketers($request->all());
        $data = [
            'marketers' => $marketers
        ];
        return $this->success('success',$data);
    }

    // Create Marketer Conversion on platform
    public function createMarketerConversion($platform, $marketerId, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $marketerConversion = $platform->createMarketerConversion($marketerId, $request->all());
        $data = [
            'marketerConversion' => $marketerConversion
        ];
        return $this->success('success',$data);
    }

    // Get Marketer Conversions from platform
    public function getMarketerConversions($platform, $marketerId, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $marketerConversions = $platform->getMarketerConversions($marketerId, $request->all());
        $data = [
            'marketerConversions' => $marketerConversions
        ];
        return $this->success('success',$data);
    }

    // Get Marketer Budgets from platform
    public function getMarketerBudgets($platform, $marketerId, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $marketerBudgets = $platform->getMarketerBudgets($marketerId, $request->all());
        $data = [
            'marketerBudgets' => $marketerBudgets
        ];
        return $this->success('success',$data);
    }

    // Create Marketer Budget on platform
    public function createMarketerBudget($platform, $marketerId, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $marketerBudget = $platform->createMarketerBudget($marketerId, $request->all());
        $data = [
            'marketerBudget' => $marketerBudget
        ];
        return $this->success('success',$data);
    }

    // Get Sections from platform
    public function getSections($platform, Request $request) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $sections = $platform->getSections($request->all());
        $data = [
            'sections' => $sections
        ];
        return $this->success('success',$data);
    }

    
}