<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Post;
use App\Http\Controllers\TestApi;
use App\Models\Attendance;
use App\Models\J1939_vehicle_realtime_data;
use App\Models\Vehicle_realtime_information_123;
use App\Models\Diver_information_123;
use App\Models\Commercial_vehicle_specification_123;
use App\Http\Controllers\Diver_information_123_Controller;
use App\Http\Controllers\CommercialVehicleSpecification_123;
use App\Http\Controllers\DriverBehaviorStatistics_123;
use App\Http\Controllers\FleetOwnerInformation_123;
use App\Http\Controllers\VehicleAndDriverBindingRegistrationInformation_123;
use App\Http\Controllers\VehicleAttendanceRecord_123;
use App\Http\Controllers\UploadVehicleRealtimeInformationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetVehicleRealtimeDetailInformationController;
use App\Http\Controllers\AllVehicleInformationController;
use App\Http\Controllers\GetAttendanceRecordController;
use App\Http\Controllers\GetAttendanceDetailController;
use App\Http\Controllers\GetHistoryDataController;
use App\Http\Controllers\UploadObdiiVehicleDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('photos', Post::class);

Route::resource('/getDiverInformation', Diver_information_123_Controller::class);

//Route::resource('/getCommercialVehicleSpecification', CommercialVehicleSpecification_123::class);
//Route::resource('/getDriverBehaviorStatistics', DriverBehaviorStatistics_123::class);
//Route::resource('/getFleetOwnerInformation', FleetOwnerInformation_123::class);
//Route::resource('/getVehicleAndDriverBindingRegistrationInformation', VehicleAndDriverBindingRegistrationInformation_123::class);
//Route::resource('/getVehicleAttendanceRecord', VehicleAttendanceRecord_123::class);


Route::resource('/getVehicleDetailInformation', GetVehicleRealtimeDetailInformationController::class);

Route::resource('uploadVehicleRealtimeInformation', UploadVehicleRealtimeInformationController::class);
Route::resource('allVehicleInformation', AllVehicleInformationController::class);
Route::resource('get-attendance-record', GetAttendanceRecordController::class);
Route::resource('get-attendance-detail-record', GetAttendanceDetailController::class);
Route::resource('get-history-data', GetHistoryDataController::class);
//以下小客車相關api--------------------------------------------------------------------------------------------
//

Route::resource('upload-obdii-vehicle-data', UploadObdiiVehicleDataController::class);



//以下登入相關api--------------------------------------------------------------------------------------------
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register',    [AuthController::class, 'register']);       // 使用者註冊
    Route::post('/login',       [AuthController::class, 'login']);          // 使用者登入 (回傳 JWT token 及使用者資訊)
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    // 以 JWT token 取得使用者資訊
    Route::post('/refresh',     [AuthController::class, 'refresh']);        // 更新 JWT token
    Route::post('/logout',      [AuthController::class, 'logout']);         // 使用者登出，移除 JWT token
});




