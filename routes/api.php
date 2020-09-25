<?php

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

Route::group(['prefix' => 'cars'], function () {
    Route::get('/', 'CarController@index');

    Route::post('create', 'CarController@create')->middleware('proceed.vin');
    Route::post('edit/{id}', 'CarController@edit')->middleware('proceed.vin');

    Route::get('remove/{id}', 'CarController@remove');
    Route::get('export', 'CarController@export');
    Route::post('models', 'CarController@models');
});

