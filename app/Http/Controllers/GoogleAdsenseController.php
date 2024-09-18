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

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts/list
     * 
     */
    public function AccountsList(Request $request)
    {

        $pageSize = $request->input('pageSize',10);
        $pageToken = $request->input('pageToken',null);

        
        $accounts = $this->service->accounts->listAccounts();
        return $this->success("success",$accounts);
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients/list
     * 
     */
    public function AccountsAdclientsList(Request $request)
    {
        $parent = $request->input('parent');

        if(!$parent) {

            $result = $this->service->accounts_adclients->listAccountsAdclients($parent);
            return $this->success("success",$result);
        }

        $accounts = $this->service->accounts->listAccounts();
        $result = [];
        foreach ($accounts as $account) {
            $result[$account['name']] = $this->service->accounts_adclients->listAccountsAdclients($account['name']);
        }
        return $this->success("success",$result);
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients/get
     * 
     */
    public function AccountsAdclientsGet(Request $request) {
        $name = $request->input('parent');
        $result = $this->service->accounts_adclients->get($name);
        return $this->success("success",$result);
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients.adunits/list
     * 
     */
    public function AccountsAdclientsAdunitsList(Request $request)
    {
        $parent = $request->input('parent');

        //var_dump($parent);exit;

        if($parent) {

            $result = $this->service->accounts_adclients_adunits->listAccountsAdclientsAdunits($parent);
            return $this->success("success",$result);
        }

        $accounts = $this->service->accounts->listAccounts();
        $result = [];
        foreach ($accounts as $account) {
            $result[$account['name']] = $this->service->accounts_adclients_adunits->listAccountsAdclientsAdunits($account['name']);
        }
        return $this->success("success",$result);
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients.adunits/get
     * 
     */
    public function AccountsAdclientsAdunitsGet(Request $request) {
        $name = $request->input('parent');
        $result = $this->service->accounts_adclients_adunits->get($name);
        return $this->success("success",$result);
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients.adunits/getAdCode
     * 
     */
    public function AccountsAdclientsAdunitsGetAdCode(Request $request) {
        $name = $request->input('name');
        try {
            $result = $this->service->accounts_adclients_adunits->getAdCode($name);
            return $this->success("success",$result);
        } catch (\Exception $e) {
            return $this->fails($e->getMessage());
        }
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.adclients.adunits/customChannels/list
     * 
     */
    public function AccountsAdclientsAdunitsCustomChannelsList(Request $request) {
        $parent = $request->input('parent');
        try {
            $result = $this->service->accounts_adclients_customchannels->listAccountsAdclientsCustomchannels($parent);
            return $this->success("success",$result);
        } catch (\Exception $e) {
            return $this->fails($e->getMessage());
        }
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts.reports/generate
     * 
     */
    public function AccountsReportsGenerate(Request $request)
    {
        $accountId = $request->input('account');

        $optParams = [];

        $dimensions = $request->input('dimensions',[]);
        $metrics = $request->input('metrics',[]);
        $startDate = $request->input('startDate',[]);
        $endDate = $request->input('endDate',[]);
        $orderBy = $request->input('orderBy',[]);
        $filters = $request->input('filters',[]);
        $currencyCode = $request->input('currencyCode',null);
        $languageCode = $request->input('languageCode',null);
        $reportingTimeZone = $request->input('reportingTimeZone',null);
        $limit = $request->input('limit',10);
        $dateRange = $request->input('dateRange',null);
        
        $optParams['dimensions'] = $dimensions;
        $optParams['metrics'] = $metrics;
        $optParams['startDate'] = $startDate;
        $optParams['endDate'] = $endDate;
        $optParams['orderBy'] = $orderBy;
        $optParams['filters'] = $filters;
        $optParams['currencyCode'] = $currencyCode;
        $optParams['languageCode'] = $languageCode;
        $optParams['reportingTimeZone'] = $reportingTimeZone;
        //$optParams['limit'] = $limit;

        //var_dump($request->all());exit;

        $startDateYear = $request->input('startDate.year',null);
        $startDateMonth = $request->input('startDate.month',null);
        $startDateDay = $request->input('startDate.day',null);
        $endDateYear = $request->input('endDate.year',null);
        $endDateMonth = $request->input('endDate.month',null);
        $endDateDay = $request->input('endDate.day',null);

        if($dateRange) {
            switch($dateRange) {
                case 'TODAY':
                    $startDateYear = date('Y');
                    $startDateMonth = date('m');
                    $startDateDay = date('d');
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
                case 'YESTERDAY':
                    $startDateYear = date('Y',strtotime('-1 day'));
                    $startDateMonth = date('m',strtotime('-1 day'));
                    $startDateDay = date('d',strtotime('-1 day'));
                    $endDateYear = date('Y',strtotime('-1 day'));
                    $endDateMonth = date('m',strtotime('-1 day'));
                    $endDateDay = date('d',strtotime('-1 day'));
                    break;
                case 'LAST_7_DAYS':
                    $startDateYear = date('Y',strtotime('-7 day'));
                    $startDateMonth = date('m',strtotime('-7 day'));
                    $startDateDay = date('d',strtotime('-7 day'));
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
                case 'LAST_30_DAYS':
                    $startDateYear = date('Y',strtotime('-30 day'));
                    $startDateMonth = date('m',strtotime('-30 day'));
                    $startDateDay = date('d',strtotime('-30 day'));
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
                case 'THIS_MONTH':
                    $startDateYear = date('Y');
                    $startDateMonth = date('m');
                    $startDateDay = 1;
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
                case 'LAST_MONTH':
                    $startDateYear = date('Y',strtotime('-1 month'));
                    $startDateMonth = date('m',strtotime('-1 month'));
                    $startDateDay = 1;
                    $endDateYear = date('Y',strtotime('-1 month'));
                    $endDateMonth = date('m',strtotime('-1 month'));
                    $endDateDay = date('d',strtotime('-1 month'));
                    break;
                case 'MONTH_TO_DATE':
                    $startDateYear = date('Y');
                    $startDateMonth = date('m');
                    $startDateDay = 1;
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
                case 'YEAR_TO_DATE':
                    $startDateYear = date('Y');
                    $startDateMonth = 1;
                    $startDateDay = 1;
                    $endDateYear = date('Y');
                    $endDateMonth = date('m');
                    $endDateDay = date('d');
                    break;
            }     
        }
        $optParams['dateRange'] = $dateRange;

        //var_dump($optParams);exit;

        // cover optParams object to array and not include startDate and endDate




        //$optParams = json_decode(json_encode($optParams), true);

        //var_dump($optParams);

        $optParams = [];

         $optParams = array(
            'startDate.year' => $startDateYear,
            'startDate.month' => $startDateMonth,
            'startDate.day' => $startDateDay,
            'endDate.year' => $endDateYear,
            'endDate.month' => $endDateMonth,
            'endDate.day' => $endDateDay,
            'metrics' => $metrics,
            'dimensions' => $dimensions,
            'orderBy' => $orderBy,
           // 'limit' => $limit,
            'filters' => $filters,
            'currencyCode' => $currencyCode,
            'languageCode' => $languageCode,
            'reportingTimeZone' => $reportingTimeZone,
            //'dateRange' => $dateRange,
          );

          //var_dump($optParams);



        // $optParams = array(
        //     'startDate.year' => 2024,
        //     'startDate.month' => 9,
        //     'startDate.day' => 3,
        //     'endDate.year' => 2024,
        //     'endDate.month' => 9,
        //     'endDate.day' => 30,
        //     'metrics' => array(
        //       'TOTAL_IMPRESSIONS', 'PAGE_VIEWS', 'AD_REQUESTS', 'AD_REQUESTS_COVERAGE', 'CLICKS',
        //       'AD_REQUESTS_CTR', 'COST_PER_CLICK', 'AD_REQUESTS_RPM',
        //       'ESTIMATED_EARNINGS', 'FUNNEL_REQUESTS', 'FUNNEL_IMPRESSIONS'),
        //     'dimensions' => array('CUSTOM_CHANNEL_ID', 'DATE'),
        //     'orderBy' => array('+CUSTOM_CHANNEL_ID', '+DATE'),
        //   );

        try {
            $report = $this->service->accounts_reports->generate($accountId, $optParams);
            return $this->success("success",$report);
        } catch (\Exception $e) {
            return $this->fails($e->getMessage());
        }
    }

    /**
     * 
     * @link https://developers.google.com/adsense/management/reference/rest/v2/accounts/sites/list
     * 
     */

    public function AccountsSitesList(Request $request)
    {
        $parent = $request->input('parent');
        try {
            $result = $this->service->accounts_sites->listAccountsSites($parent);
            return $this->success("success",$result);
        } catch (\Exception $e) {
            return $this->fails($e->getMessage());
        }
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