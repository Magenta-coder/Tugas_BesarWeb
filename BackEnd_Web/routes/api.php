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
Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('product','Api\ProductController@index');
    Route::get('product/{id}','Api\ProductController@show');
    Route::post('product','Api\ProductController@store');
    Route::put('product/{id}','Api\ProductController@update');
    Route::delete('product/{id}','Api\ProductController@destroy');
    

    Route::get('pegawai','Api\PegawaiController@index');
    Route::get('pegawai/{id}','Api\PegawaiController@show');
    Route::post('pegawai','Api\PegawaiController@store');
    Route::put('pegawai/{id}','Api\PegawaiController@update');
    Route::delete('pegawai/{id}','Api\PegawaiController@destroy');

    Route::get('pemesanan', 'Api\PemesananController@index');
    Route::get('pemesanan/{id}', 'Api\PemesananController@show');
    Route::get('pemesananByUser/{id}', 'Api\PemesananController@showByUser');
    Route::post('pemesanan', 'Api\PemesananController@store');
    Route::put('pemesanan/{id}', 'Api\PemesananController@update');
    Route::delete('pemesanan/{id}', 'Api\PemesananController@destroy');

    Route::put('user/{id}', 'Api\AuthController@update');
    Route::get('user/{id}', 'Api\AuthController@show');

    Route::post('logout','Api\AuthController@logout');
});



