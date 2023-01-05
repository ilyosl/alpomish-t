<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::domain('kassa.muzsaroy.uzb')->controller(\App\Http\Controllers\KassirController::class)->group(function (){
    Route::get('/', 'index');
    Route::post('/get-info-by-qr', 'getInfoByQr');
});

Route::get('/', \App\Http\Livewire\HomeComponent::class)->name('home.index');
//Route::get('/login', \App\Http\Livewire\LoginComponent::class)->name('login.index');
//Route::get('/login', \App\Http\Controllers\AuthController::class, 'sing')->name('login.index');
Route::controller(\App\Http\Controllers\AuthController::class)->group(function(){
    Route::get('/login', 'sign');
    Route::post('/login', 'sendSms');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
