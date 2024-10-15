<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GoogleAdsenseController;
use App\Http\Controllers\PlatformController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AdminController::class, 'login']);


Route::middleware('auth:admin')->group(function () {
    // Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AdminController::class, 'logout']);
    Route::post('refresh', [AdminController::class, 'refresh']);

    Route::get('get-user-info', [AdminController::class, 'admin']);
    Route::get('get-menu', [AdminController::class, 'menu']);
});

Route::group(['middleware' => [
    'casbin',
    'auth:admin',
    ]], function () {
    Route::get('/dashboard', [AdminController::class, 'adminList']);
    // 角色相关
    Route::get('/system/role/index', [RoleController::class, 'index']);
    Route::put('/system/role/update', [RoleController::class, 'update']);
    Route::put('/system/role/set-status', [RoleController::class, 'setStatus']);
    Route::post('/system/role/create', [RoleController::class, 'create']);
    Route::delete('/system/role/delete', [RoleController::class, 'delete']);
    Route::get('/system/role/get-roles', [RoleController::class, 'getRoles']);
    // 权限相关
    Route::get('/system/permission/index', [PermissionController::class, 'index']);
    Route::put('/system/permission/update', [PermissionController::class, 'update']);
    Route::put('/system/permission/set-status', [PermissionController::class, 'setStatus']);
    Route::post('/system/permission/create', [PermissionController::class, 'create']);
    Route::delete('/system/permission/delete', [PermissionController::class, 'delete']);
    Route::get('/system/permission/get-tree', [PermissionController::class, 'getTree']); // 获取权限树

    // 管理员相关
    Route::get('/system/admin/index', [AdminController::class, 'index']);
    Route::put('/system/admin/update', [AdminController::class, 'update']);
    Route::put('/system/admin/set-status', [AdminController::class, 'setStatus']);
    Route::post('/system/admin/create', [AdminController::class, 'create']);
    Route::delete('/system/admin/delete', [AdminController::class, 'delete']);


    // Google Adsense
    Route::get('/google/adsense/accounts/list', [GoogleAdsenseController::class, 'AccountsList']);
    Route::get('/google/adsense/accounts/get', [GoogleAdsenseController::class, 'AccountsGet']);
    // Account Children
    Route::get('/google/adsense/accounts/child/list', [GoogleAdsenseController::class, 'AccountChildList']);

    Route::get('/google/adsense/accounts/adclients/list', [GoogleAdsenseController::class, 'AccountsAdclientsList']);
    Route::get('/google/adsense/accounts/adclients/get', [GoogleAdsenseController::class, 'AccountsAdclientsGet']);

    Route::get('/google/adsense/accounts/adclients/adunits/list', [GoogleAdsenseController::class, 'AccountsAdclientsAdunitsList']);
    Route::get('/google/adsense/accounts/adclients/adunits/get', [GoogleAdsenseController::class, 'AccountsAdclientsAdunitsGet']);
    Route::get('/google/adsense/accounts/adclients/adunits/get-ad-code', [GoogleAdsenseController::class, 'AccountsAdclientsAdunitsGetAdCode']);
    
    Route::get('/google/adsense/accounts/adclients/adunits/custom-channels/list', [GoogleAdsenseController::class, 'AccountsAdclientsAdunitsCustomChannelsList']);

    // Account Reports Generate
    Route::get('/google/adsense/accounts/reports/generate', [GoogleAdsenseController::class, 'AccountsReportsGenerate']);

    // Account Sites
    Route::get('/google/adsense/accounts/sites/list', [GoogleAdsenseController::class, 'AccountsSitesList']);

    Route::get('/google/adsense/report/custom-channels', [GoogleAdsenseController::class, 'customChannels']);
    Route::get('/google/adsense/report/list-accounts-ad-clients', [GoogleAdsenseController::class, 'listAccountsAdclients']);
    Route::get('/google/adsense/report/generate', [GoogleAdsenseController::class, 'generate']);
    Route::get('/google/adsense/report/ads', [GoogleAdsenseController::class, 'ads']);
    Route::get('/google/adsense/report/ads-performance', [GoogleAdsenseController::class, 'adsPerformance']);
    Route::get('/google/adsense/report/ads-performance-dimensions', [GoogleAdsenseController::class, 'adsPerformanceDimensions']);
    Route::get('/google/adsense/report/ads-performance-metrics', [GoogleAdsenseController::class, 'adsPerformanceMetrics']);
    Route::get('/google/adsense/report/ads-performance-dimensions-metrics', [GoogleAdsenseController::class, 'adsPerformanceDimensionsMetrics']);
    Route::get('/google/adsense/report/get-filter', [GoogleAdsenseController::class, 'getFilter']);

    // Method: accounts.reports.saved.list
    Route::get('/google/adsense/report/saved/list', [GoogleAdsenseController::class, 'AccountsReportsSavedList']);
    // Method: accounts.reports.saved.generate
    Route::get('/google/adsense/report/saved/generate', [GoogleAdsenseController::class, 'AccountsReportsSavedGenerate']);
    // Method: accounts.reports.getSaved 
    Route::get('/google/adsense/report/saved/get', [GoogleAdsenseController::class, 'AccountsReportsSavedGet']);

    // platform
    Route::get('/platform/{platform}', [PlatformController::class, 'index']);
    Route::get('/platform/{platform}/get-token', [PlatformController::class, 'getToken']);
    Route::get('/platform/{platform}/get-campaigns', [PlatformController::class, 'getCampaigns']);
    Route::get('/platform/{platform}/get-campaign/{campaign_id}', [PlatformController::class, 'getCampaign']);
    Route::get('/platform/{platform}/get-campaign-items/{campaign_id}', [PlatformController::class, 'getCampaignItems']);

    // create a campaign
    Route::post('/platform/{platform}/create-campaign', [PlatformController::class, 'createCampaign']);
    // update a campaign
    Route::put('/platform/{platform}/update-campaign/{campaign_id}', [PlatformController::class, 'updateCampaign']);
    // delete a campaign
    Route::delete('/platform/{platform}/delete-campaign/{campaign_id}', [PlatformController::class, 'deleteCampaign']);

    // create a campaign item
    Route::post('/platform/{platform}/create-campaign-item/{campaign_id}', [PlatformController::class, 'createCampaignItem']);
    // update a campaign item
    Route::put('/platform/{platform}/update-campaign-item/{campaign_id}/{campaign_item_id}', [PlatformController::class, 'updateCampaignItem']);
    // delete a campaign item
    Route::delete('/platform/{platform}/delete-campaign-item/{campaign_id}/{campaign_item_id}', [PlatformController::class, 'deleteCampaignItem']);


    // Campaign Collection
    Route::get('/platform/{platform}/get-campaign-collections', [PlatformController::class, 'getCampaignCollections']);
    //Campain Collection By Budget
    Route::get('/platform/{platform}/get-campaign-collections-by-budget', [PlatformController::class, 'getCampaignCollectionsByBudget']);
    //Campain Location
    Route::get('/platform/{platform}/get-campaign-locations', [PlatformController::class, 'getCampaignLocations']);
    //Platform Location
    Route::get('/platform/{platform}/get-geo-locations', [PlatformController::class, 'getGeoLocations']);
    Route::get('/platform/{platform}/get-support-languages', [PlatformController::class, 'getSupportLanguages']);

    // Marketers
    Route::get('/platform/{platform}/get-marketers', [PlatformController::class, 'getMarketers']);
    // Get marketer conversions from marketer
    Route::get('/platform/{platform}/get-marketer-conversions/{marketerId}', [PlatformController::class, 'getMarketerConversions']);
    // create a marketer conversion
    Route::post('/platform/{platform}/create-marketer-conversion/{marketerId}', [PlatformController::class, 'createMarketerConversion']);
    // Get marketer conversion stats
    Route::get('/platform/{platform}/get-marketer-conversion-stats/{marketerId}', [PlatformController::class, 'getMarketerConversionStats']);
    // Get marketer budgets
    Route::get('/platform/{platform}/get-marketer-budgets/{marketerId}', [PlatformController::class, 'getMarketerBudgets']);
    // create a marketer budget
    Route::post('/platform/{platform}/create-marketer-budget/{marketerId}', [PlatformController::class, 'createMarketerBudget']);

    // Get sections
    Route::post('/platform/{platform}/get-sections', [PlatformController::class, 'getSections']);

    // Reports
    Route::get('/platform/{platform}/get-reports', [PlatformController::class, 'getReports']);
    // Reports Full day of data
    Route::get('/platform/{platform}/get-reports-full-day', [PlatformController::class, 'getReportsFullDay']);
    //Retrieve campaigns with performance statistics for a Marketer Report
    Route::get('/platform/{platform}/get-marketer-campaigns-report', [PlatformController::class, 'getMarketerCampainsReport']);




});


    




