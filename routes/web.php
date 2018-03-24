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

//Informations de(s) utilisateur(s)
Route::resource('user', 'UserController', ['only' => ['index', 'show']]);

/*Routes accessibles uniquement aux invités*/
Route::middleware(['guest'])->group(function(){
    Auth::routes();
    //Confirmation de l'email d'inscription
    Route::get('/user/verify/{confirmation_code}', ['as' => 'verify', 'uses' => 'UserController@confirmAccount']);
});

/*Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
});

Route::namespace('Admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
});
