<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GoogleAdsenseReportController;
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
    Route::get('/google/adsense/report/accounts', [GoogleAdsenseReportController::class, 'accounts']);
    Route::get('/google/adsense/report/custom-channels', [GoogleAdsenseReportController::class, 'customChannels']);
    Route::get('/google/adsense/report/list-accounts-ad-clients', [GoogleAdsenseReportController::class, 'listAccountsAdclients']);
    Route::get('/google/adsense/report/generate', [GoogleAdsenseReportController::class, 'generate']);
    Route::get('/google/adsense/report/ads', [GoogleAdsenseReportController::class, 'ads']);
    Route::get('/google/adsense/report/ads-performance', [GoogleAdsenseReportController::class, 'adsPerformance']);
    Route::get('/google/adsense/report/ads-performance-dimensions', [GoogleAdsenseReportController::class, 'adsPerformanceDimensions']);
    Route::get('/google/adsense/report/ads-performance-metrics', [GoogleAdsenseReportController::class, 'adsPerformanceMetrics']);
    Route::get('/google/adsense/report/ads-performance-dimensions-metrics', [GoogleAdsenseReportController::class, 'adsPerformanceDimensionsMetrics']);





});


    




