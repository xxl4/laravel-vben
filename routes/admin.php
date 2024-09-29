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

    // platform
    Route::get('/platform/{platform}', [PlatformController::class, 'index']);
    Route::get('/platform/{platform}/get-token', [PlatformController::class, 'getToken']);
    Route::get('/platform/{platform}/get-campaigns', [PlatformController::class, 'getCampaigns']);
    Route::get('/platform/{platform}/get-campaign/{campaign_id}', [PlatformController::class, 'getCampaign']);
    Route::get('/platform/{platform}/get-campaign-items/{campaign_id}', [PlatformController::class, 'getCampaignItems']);
    Route::get('/platform/{platform}/get-campaign-item', [PlatformController::class, 'getCampaignItem']);
    Route::get('/platform/{platform}/get-campaign-item-stats', [PlatformController::class, 'getCampaignItemStats']);
    Route::get('/platform/{platform}/get-campaign-item-stats-summary', [PlatformController::class, 'getCampaignItemStatsSummary']);
    Route::get('/platform/{platform}/get-campaign-item-stats-breakdown', [PlatformController::class, 'getCampaignItemStatsBreakdown']);
    Route::get('/platform/{platform}/get-campaign-item-stats-trend', [PlatformController::class, 'getCampaignItemStatsTrend']);
    Route::get('/platform/{platform}/get-campaign-item-stats-trend-summary', [PlatformController::class, 'getCampaignItemStatsTrendSummary']);
    Route::get('/platform/{platform}/get-campaign-item-stats-trend-breakdown', [PlatformController::class, 'getCampaignItemStatsTrendBreakdown']);
    Route::get('/platform/{platform}/get-campaign-item-stats-trend-summary-breakdown', [PlatformController::class, 'getCampaignItemStatsTrendSummaryBreakdown']);

    Route::get('/platform/{platform}/get-reports', [PlatformController::class, 'getReports']);



});


    




