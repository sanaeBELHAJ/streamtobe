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

/**
 * 
 * Pour consulter l'ensemble des routes mises en place : 
 * php artisan route:list
 */

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'HomeController@index');
//Routes basiques d'inscription/connexion/déconnexion
//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*Routes accessibles uniquement aux invités*/
Route::middleware(['guest'])->group(function(){
    //Confirmation de l'email d'inscription
    Route::get('/user/verify/{confirmation_code}', 'Auth\RegisterController@confirmAccount')->name('verify');
});

/*Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){

    /* Actions sur le stream */
        //Edit stream
        Route::post('/updateStream', 'StreamController@updateStream');
        //(Un-)follow stream
        Route::post('/followStream', 'ViewerController@updateFollow');
        //Report stream
        Route::post('/reportStream', 'ViewerController@report')->name('report');
        //Dons Paypal
        Route::post('/validGiveaway', 'PaypalController@validGiveaway');
        //Liste des bannis et Modérateurs du chatbox
        Route::get('/getStreamViewer', 'ViewerController@getStreamViewer');
        //Bannissement / Modérateur du chatbox
        Route::post('/updateViewer', 'ViewerController@updateViewer');

    /* Actions sur le compte */
        Route::patch('/home/infos/', 'AccountController@updateInfos')->name('home.updateInfos');
        Route::patch('/home/stream/', 'AccountController@updateStream')->name('home.updateStream');
        Route::patch('/home/stats/', 'AccountController@updateStats')->name('home.updateStats');
        Route::resource('home', 'AccountController', ['only' => ['index','destroy','show']]);
        
        Route::get('/stats', 'AccountController@stats');
        Route::get('/fans', 'AccountController@fans');
        Route::get('/follows', 'AccountController@follows');

    
    /*Messages privées entre utilisateurs */
        Route::get('/messages', 'MessageController@index');

    /* Support technique pour utilisateur */
        Route::post('/support', 'HomeController@support');
        Route::get('/support', 'HomeController@support');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/* Routes accessibles à tous */

//Informations des streams
Route::resource('stream', 'StreamController', ['only' => ['index', 'show']]);
Route::post('stream', 'StreamController@index')->name('index');

//Recherche d'une chaine
Route::get('/autocomplete', 'StreamController@autocomplete')->name('autocomplete');

//Accord d'utilisation des cookies
Route::post('/valid_cookie', 'HomeController@valid_cookie');