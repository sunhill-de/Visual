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

if (App::environment(['local','staging','testing'])) {
    Route::get('/dialog/add', 'Sunhill\Visual\Controllers\TestController@add')->name('test.add');
    Route::post('/dialog/execadd', 'Sunhill\Visual\Controllers\TestController@execadd')->name('test.execadd');
    Route::get('/dialog/edit', 'Sunhill\Visual\Controllers\TestController@edit')->name('test.edit');
    Route::get('/dialog/execadd', 'Sunhill\Visual\Controllers\TestController@execedit')->name('test.execedit');
}