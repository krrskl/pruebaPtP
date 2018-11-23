<?php

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

Route::get('/ptp/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');
Route::get('/getBankList', ['as' => 'getBankList', 'uses' => 'SoapController@getBankList']);
Route::post('/createTransaction', ['as' => 'createTransaction', 'uses' => 'SoapController@PSETransactionRequest']);
Route::get('/resultTransaction', ['as' => 'resultTransaction', 'uses' => 'SoapController@resultTransaction']);

