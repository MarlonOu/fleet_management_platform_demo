<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Post;
use App\Http\Controllers\TestApi;
use App\Models\Attendance;
use App\Models\J1939_vehicle_realtime_data;

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
Route::resource('t make:model Roleest', TestApi::class);
Route::get('/welcome', function(){
    return  J1939_vehicle_realtime_data::all();
   // $real_time = DB::table('j1939_vehicle_realtime_data')->get()->toJson();
   // echo $real_time;
});


/*Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


 $table->Increments('id');
            $table->integer('Tax_ID', 11);
            $table->char('Company Name', 50);
            $table->char('CEO', 50);
            $table->char('Contact Window', 50);
            $table->char('TEL', 50);
            $table->char('Address', 50);
            $table->timestamps();


return new class extends Migration
{

public function up(): void
{
    Schema::rename('123_fleet_owner_information', '123_fleet_owner_information_table');
}

public function down(): void
{
    Schema::rename('123_fleet_owner_information_table', '123_fleet_owner_information');
}
};


*/





