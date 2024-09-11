<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Google_Client;
use Google_Service_Adsense;
use stdClass;


/**
 * @group Google Adsense
 *
 * APIs for Google Adsense
 */
class GoogleAdsenseController extends Controller {

    private $client;
    private $service;

    public function __construct()
    {
        //$this->middleware('auth:api');

        // google adsense
        //$this->middleware('permission:report-google-adsense', ['only' => ['googleAdsense']]);

        $this->client = new Google_Client();
        $this->client->addScope('https://www.googleapis.com/auth/adsense.readonly');
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');
        $this->client->setAuthConfig(storage_path('app/client_secret_33839582772-7bqi2gto92jms75ujbhvfo22je2haold.apps.googleusercontent.com.json'));

        $this->client->setRedirectUri('https://adsapi.heomai.com/adsense-sample.php');

        $token = unserialize(file_get_contents(storage_path('app/tokens.dat')));

        $this->client->fetchAccessTokenWithRefreshToken($token['refresh_token']);

        $this->service = new Google_Service_Adsense($this->client);


    }


    // base use google adsense report generate
    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.reports/generate
     * 
     * 
     */
    public function generate(Request $request)
    {
        $accountId = $request->input('account');

        $optParams = new stdClass();
        
        $report = $this->service->accounts_reports->generate($accountId, $optParams);

        return $this->success("success",$report);

    }

    public function accounts(Request $request)
    {
        
        $accounts = $this->service->accounts->listAccounts();
        return $this->success("success",$accounts);
    }

    public function listAccountsAdclients(Request $request)
    {
        $accounts = $this->service->accounts->listAccounts();
        $result = [];
        foreach ($accounts as $account) {
            $result[$account['name']] = $this->service->accounts_adclients->listAccountsAdclients($account['name']);
        }
        return $this->success("success",$result);
    }

    public function CustomChannels(Request $request)
    {
        $accounts = $this->service->accounts->listAccounts();

        $result = [];
        foreach ($accounts as $account) {

            var_dump($account['name']);

            continue;

            $result[$account['name']] = $this->service->accounts_customchannels->listAccountsCustomchannels($account['name']);
        }
        return $this->success("success",$result);
    }

    public function CustomChannelsForAdUnit(Request $request)
    {
        $accounts = $this->service->accounts->listAccounts();
        $result = [];
        foreach ($accounts as $account) {
            $result[$account->getId()] = $this->service->accounts_customchannels->listAccountsCustomchannels($account->getId());
        }
        return response()->json($result);
    }

    public function AdUnits(Request $request)
    {
        $accounts = $this->service->accounts->listAccounts();
        $result = [];
        foreach ($accounts as $account) {
            $result[$account->getId()] = $this->service->accounts_adunits->listAccountsAdunits($account->getId());
        }
        return response()->json($result);
    }

    

}