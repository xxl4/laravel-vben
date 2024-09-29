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
}