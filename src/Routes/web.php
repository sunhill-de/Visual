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

Route::get('/ajax/searchTags/{class?}', 'Sunhill\Visual\Controllers\AjaxController@searchTags');
Route::get('/ajax/searchObjects/{class}/{field}', 'Sunhill\Visual\Controllers\AjaxController@searchObjects');
Route::get('/ajax/searchArrayOfString/{class}/{field}', 'Sunhill\Visual\Controllers\AjaxController@getArrayOfStringSuggestion');

//Route::get('/Computer', 'Sunhill\Visual\Controllers\ComputerController@index');
Route::post('/Computer/Database/Import/ExecImportPersons', 'Sunhill\Visual\Controllers\ComputerController@ExecImportPersons');