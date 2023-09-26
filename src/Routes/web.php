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
Route::get('/css/sunhill.css', 'Sunhill\Visual\Controllers\SystemController@css');
Route::get('/js/sunhill.js', 'Sunhill\Visual\Controllers\SystemController@js');
Route::get('/ajax/{topic}/{additional1?}/{additional2?}', 'Sunhill\Visual\Controllers\AjaxController@ajax');

if (App::environment(['local','staging'])) {
    Route::get('/dialog', 'Sunhill\Visual\Controllers\TestController@dialog')->name('dialog');
    Route::post('/dialog/execute', 'Sunhill\Visual\Controllers\TestController@execute')->name('execute');
}