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

if(env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', 'HomeController@index');

/*Routes accessibles uniquement aux invités*/
Route::middleware(['guest'])->group(function(){
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    //Confirmation de l'email d'inscription
    Route::get('/user/verify/{confirmation_code}', 'Auth\RegisterController@confirmAccount')->name('verify');
});

/* Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    
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
        Route::get('/home', 'AccountController@index')->name('home.index');    
        Route::patch('/updateInfos', 'AccountController@updateInfos')->name('home.updateInfos');
        Route::delete('/destroy', 'AccountController@destroy')->name('home.destroy');
        
    /*Messages privées entre utilisateurs */
        Route::get('/messages', 'MessageController@index');
});


/* Interface d'administration Voyager */
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/* Routes accessibles à tous */

//Informations des streams
Route::resource('stream', 'StreamController', ['only' => ['index', 'show']]);
Route::post('stream', 'StreamController@index')->name('index');

// Recuperation du status
Route::get('/getStreamStatusInfo', 'ViewerController@getStreamStatusInfo');

//Recherche d'une chaine
Route::get('/autocomplete', 'StreamController@autocomplete')->name('autocomplete');

//Informations d'un utilisateur
Route::get('/home/{pseudo}', 'AccountController@show')->name('home.show');
Route::get('/stats/{pseudo}', 'AccountController@stats')->name('home.stats');
Route::get('/fans/{pseudo}', 'AccountController@fans')->name('home.fans');
Route::get('/follows/{pseudo}', 'AccountController@follows')->name('home.follows');

//Accord d'utilisation des cookies
Route::post('/valid_cookie', 'HomeController@valid_cookie');

/* Support technique pour utilisateur */
Route::post('/support', 'HomeController@support');
Route::get('/support', 'HomeController@support');

//Vérification de nouveaux messages
Route::get('/checkMessage', 'HomeController@checkMessage');



/* SI AUCUNE ROUTE N'EST CORRECTE */
Route::any('{all}', function(){
    return view('errors.404');
})->where('all', '.*');