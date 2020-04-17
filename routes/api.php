<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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

Route::post('login', 'API\UserController@login')->name('api.login');
Route::post('register', 'API\UserController@register')->name('api.register');
Route::get('actives', 'API\UserController@getActives')->name('api.actives');
Route::get('update', 'API\UserController@update')->name('api.update');
Route::get('destroy', 'API\UserController@destroy')->name('api.destroy');
