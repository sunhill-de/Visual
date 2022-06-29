<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ObjectsController;

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

Route::get('/ajax/searchTags', 'Sunhill\Visual\Controllers\AjaxController@searchTags');
Route::get('/ajax/searchObjects', 'Sunhill\Visual\Controllers\AjaxController@searchTags');
