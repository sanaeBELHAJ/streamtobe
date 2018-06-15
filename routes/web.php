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
 * Pour consulter l'ensemble des routes mises en place : php artisan route:list
 * 
 */

Route::get('/', function () {
    return view('welcome');
});

//Routes basiques d'inscription/connexion/déconnexion
Auth::routes();

/*Routes accessibles uniquement aux invités*/
Route::middleware(['guest'])->group(function(){
    //Confirmation de l'email d'inscription
    Route::get('/user/verify/{confirmation_code}', 'Auth\RegisterController@confirmAccount')->name('verify');
});


/*Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
Route::post('paypal/notify', 'PaypalController@notify');
*/

/*Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){

    /* Actions sur le stream */
        //Edit stream
        Route::post('/updateStream', 'StreamController@updateStream');
        //(Un-)follow stream
        Route::post('/followStream', 'ViewerController@updateFollow');
        //Report stream
        Route::post('/reportStream', 'ViewerController@report')->name('report');
        
    /* Actions sur le compte */
        Route::patch('/home/infos/', 'AccountController@updateInfos')->name('home.updateInfos');
        Route::patch('/home/stream/', 'AccountController@updateStream')->name('home.updateStream');
        Route::patch('/home/stats/', 'AccountController@updateStats')->name('home.updateStats');
        Route::patch('/home/subscription/', 'AccountController@updateSubscription')->name('home.updateSubscription');
        Route::resource('home', 'AccountController', ['only' => ['index','destroy']]);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/* Routes accessibles à tous */

//Informations des streams
Route::resource('stream', 'StreamController', ['only' => ['index', 'show']]);

//Recherche d'une chaine
Route::get('/autocomplete', 'StreamController@autocomplete')->name('autocomplete');
