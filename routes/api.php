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
Route::get('/', function (){
    return ['success'=>1];
});
Route::controller(\App\Http\Controllers\Api\PaymeController::class)->prefix('/payme')->group(function (){
   Route::post('/', 'index');
});
Route::controller(\App\Http\Controllers\Api\ClickController::class)->prefix('/click')->group(function (){
    Route::post('/prepare-click','prepare');
    Route::post('/complete-click','complete');
});
Route::controller(\App\Http\Controllers\Api\ApplicationForKatokServiceController::class)->prefix('/app-katok')->group(function (){
    Route::post('/add', 'store');
});
Route::controller(\App\Http\Controllers\Api\OrdersController::class)->prefix('/order')->middleware('auth:sanctum')->group(function (){
    Route::post('/add', 'store');
    Route::get('/view/{id}', 'edit');
    Route::get('/', 'index');
});
Route::controller(\App\Http\Controllers\Api\IceSubsController::class)->prefix('/subs')->group(function (){
    Route::post('/','store')->middleware('cors');
    Route::get('/list','list')->middleware('cors');

});
Route::controller(\App\Http\Controllers\Api\KatokServiceController::class)->prefix('/katok-service')->group(function (){
    Route::get('/', 'index');
    Route::post('/', 'store')->middleware('auth:sanctum');
});
Route::controller(\App\Http\Controllers\Api\UserProfileController::class)->prefix('/user-profile')->middleware('auth:sanctum')->group(function (){
    Route::post('/edit', 'edit');
    Route::get('/', 'index');

});

Route::controller(\App\Http\Controllers\Api\SectionPageController::class)->prefix('/section-page')->group(function (){
    Route::post('/add', 'store')->middleware('auth:sanctum');
    Route::get('/', 'index');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::controller(\App\Http\Controllers\Api\AdditionalServiceController::class)->prefix('add-service')->group(function (){
        Route::post('/', 'store')->middleware('cors');
        Route::get('/', 'index')->middleware('cors');
    });
    Route::controller(\App\Http\Controllers\Api\KassaController::class)->group(function (){
        Route::post('/kassa/get-data', 'getData')->middleware('cors');
        Route::post('/kassa/add-data', 'addData')->middleware('cors');
        Route::post('/kassa/check-qrcode', 'checkQrcode')->middleware('cors');
        Route::post('/kassa/status-qrcode', 'countEnter')->middleware('cors');
        Route::post('/kassa/extend-qrcode', 'extendQrcode')->middleware('cors');
        Route::get('/kassa/feed', 'getFeedKatok')->middleware(['cors','throttle:none']);
        Route::get('/kassa/stat ', 'staticsInfo')->middleware(['cors']);
    });

    //Chat
    Route::controller(\App\Http\Controllers\ChatController::class)->prefix('chat')->group(function (){
        Route::get('/', 'index');
        Route::get('/messages', 'messages');
        Route::post('/send', 'send');
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
Route::controller(\App\Http\Controllers\Api\BasketController::class)->prefix('basket')->middleware('auth:sanctum')->group(function (){
    Route::get('/', 'index');
    Route::post('/view', 'show');
    Route::post('/add', 'store');
    Route::post('/delete-ticket', 'destroy');
    Route::post('/delete-all', 'deleteAll');
});

//Route::resource('/event-place', \App\Http\Controllers\Api\EventPlaceController::class, ['except' => ['index']]);
Route::post('/open-door', [\App\Http\Controllers\Api\KassaController::class,'opendDoor']);
