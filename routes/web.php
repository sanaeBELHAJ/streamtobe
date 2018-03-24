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

//Routes basiques d'inscription/connexion/déconnexion
Auth::routes();

//Informations de(s) utilisateur(s)
Route::resource('user', 'UserController', ['only' => ['index', 'show']]);

/*Routes accessibles uniquement aux invités*/
Route::middleware(['guest'])->group(function(){
    //Confirmation de l'email d'inscription
    Route::get('/user/verify/{confirmation_code}', 'Auth\RegisterController@confirmAccount')->name('verify');
});

/*Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){
    Route::resource('home', 'HomeController', ['only' => ['index', 'update', 'destroy']]);
});

Route::namespace('Admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
});
