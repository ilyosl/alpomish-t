<?php

use App\Admin\Controllers\ApplicationForKatokServiceController;
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

});
