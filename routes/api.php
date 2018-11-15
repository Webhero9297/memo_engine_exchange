<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1/public', 'namespace' => 'Services'], function () {
    Route::post('/account', 'CoreProcessorController@getAccount');
    Route::post('/address/{uid}', 'CoreProcessorController@getAddress');
    Route::post('/balance/{uid}', 'CoreProcessorController@getBalance');
    Route::post('/bankroll', 'CoreProcessorController@getBankRoll');
});