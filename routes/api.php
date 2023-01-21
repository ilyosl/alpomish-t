<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(\App\Http\Controllers\Api\KassaController::class)->group(function (){
        Route::post('/kassa/get-data', 'getData')->middleware('cors');
        Route::post('/kassa/check-qrcode', 'checkQrcode')->middleware('cors');
        Route::post('/kassa/status-qrcode', 'countEnter')->middleware('cors');
        Route::post('/kassa/extend-qrcode', 'extendQrcode')->middleware('cors');
        Route::get('/kassa/feed', 'getFeedKatok')->middleware(['cors','throttle:none']);
        Route::get('/kassa/stat ', 'staticsInfo')->middleware(['cors']);
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup', 'register');
    Route::post('/login', 'login');
    Route::post('/send-sms', 'sendSms');
    Route::post('/auth-phone', 'loginWithSms');
});
Route::resource('/event', \App\Http\Controllers\Api\EventsController::class);
Route::resource('/news', \App\Http\Controllers\Api\NewsController::class);
Route::controller(\App\Http\Controllers\Api\EventPlaceController::class)->group(function (){
   Route::post('/event-place', 'index');
});
Route::controller(\App\Http\Controllers\Api\CoachServiceController::class)->group(function (){
    Route::post('/coach-service', 'store');
    Route::get('/coach-service', 'getStatic');
});
//Route::resource('/event-place', \App\Http\Controllers\Api\EventPlaceController::class, ['except' => ['index']]);
Route::post('/open-door', [\App\Http\Controllers\Api\KassaController::class,'opendDoor']);
