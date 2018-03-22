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

Route::get('/', function () {
    return view('welcome');
});


//Routes instanciées automatiquement avec leur controlleurs
Route::resource('user', 'UserController');

/*
    Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);
    Route::post('/forgot', ['as' => 'forgot', 'uses' => 'UserController@forgot']);
*/