<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestApi;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pusher', function () {
    return view('pusher');
});



Route::get('/test', function () {
    event(new App\Events\MessageSent('websolutionstuff_team'));
    return "Event has been sent!";
});
