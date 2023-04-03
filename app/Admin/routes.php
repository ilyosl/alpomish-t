<?php

use App\Admin\Controllers\AdditinalService;
use App\Admin\Controllers\ApplicationForKatokServiceController;
use App\Admin\Controllers\BlockController;
use App\Admin\Controllers\EventController;
use App\Admin\Controllers\EventPlaceController;
use App\Admin\Controllers\EventTimeController;
use App\Admin\Controllers\IceSubsController;
use App\Admin\Controllers\KatokListController;
use App\Admin\Controllers\KatokServiceController;
use App\Admin\Controllers\NewsController;

use App\Admin\Controllers\OrdersController;
use App\Admin\Controllers\SectionPageController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/place-control', 'PlaceController@index')->name('place');
    $router->get('/cashier', 'KassirController@index')->name('cashier');
    $router->get('/cashier/place', 'KassirController@place')->name('cashier.place');
    $router->get('/cashier/check-ticket', 'KassirController@checkTest')->name('cashier.checkticket');
    $router->post('/cashier/ticket', 'KassirController@ticket')->name('cashier.ticket');
    $router->get('/cashier/{event}', 'KassirController@view')->name('cashier.view');

    $router->get('/place-control/view', 'PlaceController@view')->name('view');
    $router->post('/place-control/set-ticket', 'PlaceController@setTicket')->name('ticket');
    $router->resource('news', NewsController::class);
    $router->resource('katok-service', KatokServiceController::class);
    $router->resource('app-service', ApplicationForKatokServiceController::class);
    $router->controller(EventController::class)->prefix('/events')->group(function(){
        Route::get('/event-place/{event}','eventPlace');
    })->name('admin.events.event-place');
    $router->controller(\App\Admin\Controllers\KatokStaticsController::class)->group(function (){
        Route::get('/katok-statics','index');
    });
  /*  $router->controller(\App\Admin\Controllers\KassirController::class)->group(function (){
        Route::get('/cashier','index')->name('cashier.index');
    });*/
    $router->resource('events', EventController::class);

    $router->resource('event-times', EventTimeController::class);

    $router->resource('event-place', EventPlaceController::class);
    $router->resource('section-page', SectionPageController::class);
    $router->resource('blocks', BlockController::class);
    $router->resource('orders', OrdersController::class);
    $router->resource('katok-qrcode', KatokListController::class);
    $router->resource('additional-service', AdditinalService::class);
    $router->resource('ice-subs', IceSubsController::class);

});
