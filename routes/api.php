<?php

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

Route::group([], function() {
    Route::get('items', 'App\Http\Controllers\API\ItemController@index');
    Route::post('items', 'App\Http\Controllers\API\ItemController@store');
    Route::get('items/{id}', 'App\Http\Controllers\API\ItemController@show');
    Route::patch('items/{id}', 'App\Http\Controllers\API\ItemController@update');
    Route::delete('items/{id}', 'App\Http\Controllers\API\ItemController@destroy');
});
