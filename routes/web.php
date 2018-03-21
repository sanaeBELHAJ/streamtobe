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

/*Route::get('/', function () {
    return view('welcome');
});
*/

//Login - Sign in
Route::get('/', ['as' => 'login', 'uses' => 'UserController@index']);

Route::post('/', ['as' => 'register', 'uses' => 'UserController@register']);
Route::post('/', ['as' => 'login', 'uses' => 'UserController@login']);
Route::post('/', ['as' => 'forgot', 'uses' => 'UserController@forgot']);