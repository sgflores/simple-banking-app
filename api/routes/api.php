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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('client_credentials')->group(function () {
        
    Route::get('accounts/{id}', 'API\AccountController\AccountInfoController@show');

    Route::get('accounts/{id}/transactions', 'API\AccountController\AccountTransactionController@index');

    Route::post('accounts/{id}/transactions', 'API\AccountController\AccountTransactionController@store');

    Route::get('currencies', 'API\CurrencyController@index');

});
