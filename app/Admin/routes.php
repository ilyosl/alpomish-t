<?php

use App\Admin\Controllers\ApplicationForKatokServiceController;
use App\Admin\Controllers\EventController;
use App\Admin\Controllers\EventTimeController;
use App\Admin\Controllers\KatokServiceController;
use App\Admin\Controllers\NewsController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('news', NewsController::class);
    $router->resource('katok-service', KatokServiceController::class);
    $router->resource('app-service', ApplicationForKatokServiceController::class);
    $router->controller(EventController::class)->prefix('/events')->group(function(){
        \Illuminate\Support\Facades\Route::get('/event-place','eventPlace');
    })->name('admin.events.event-place');
    $router->resource('events', EventController::class);

    $router->resource('event-times', EventTimeController::class);

});
