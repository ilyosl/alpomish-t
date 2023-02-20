<?php

use App\Admin\Controllers\ApplicationForKatokServiceController;
use App\Admin\Controllers\BlockController;
use App\Admin\Controllers\EventController;
use App\Admin\Controllers\EventPlaceController;
use App\Admin\Controllers\EventTimeController;
use App\Admin\Controllers\KatokListController;
use App\Admin\Controllers\KatokServiceController;
use App\Admin\Controllers\NewsController;

use App\Admin\Controllers\OrdersController;
use App\Admin\Controllers\SectionPageController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/place-control', 'PlaceController@index')->name('place');
    $router->get('/place-control/view', 'PlaceController@view')->name('view');
    $router->post('/place-control/set-ticket', 'PlaceController@setTicket')->name('ticket');
    $router->resource('news', NewsController::class);
    $router->resource('katok-service', KatokServiceController::class);
    $router->resource('app-service', ApplicationForKatokServiceController::class);
    $router->controller(EventController::class)->prefix('/events')->group(function(){
        \Illuminate\Support\Facades\Route::get('/event-place/{event}','eventPlace');
    })->name('admin.events.event-place');
    $router->controller(\App\Admin\Controllers\KatokStaticsController::class)->group(function (){
        \Illuminate\Support\Facades\Route::get('/katok-statics','index');
    });
    $router->resource('events', EventController::class);

    $router->resource('event-times', EventTimeController::class);

    $router->resource('event-place', EventPlaceController::class);
    $router->resource('section-page', SectionPageController::class);
    $router->resource('blocks', BlockController::class);
    $router->resource('orders', OrdersController::class);
    $router->resource('katok-qrcode', KatokListController::class);

});
