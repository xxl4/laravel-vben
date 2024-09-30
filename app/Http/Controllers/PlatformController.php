<?php
namespace App\Http\Controllers;

use App\Platform\Taboola;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        
    }

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
        $data = [
            'campaigns' => $campaigns
        ];
        return $this->success('success',$data);
    }

    public function getCampaign($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaign = $platform->getCampaign($campaign_id);
        $data = [
            'campaign' => $campaign
        ];
        return $this->success('success',$data);
    }

    public function getCampaignItems($platform, $campaign_id) {

        $platform = 'App\Platform\\'.$platform;

        $platform = new $platform;
        $campaignItems = $platform->getCampaignItems($campaign_id);
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
        $data = [
            'campaign' => $campaign
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