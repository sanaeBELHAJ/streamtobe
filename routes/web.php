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

/*Routes accessibles uniquement aux membres loggés */
Route::group(['middleware' => 'auth'], function(){

    /* Actions sur le stream */
        //FAVORIS : route "stream.favorites" à placer avant la route de la ressource "stream"
        Route::get('stream/favorites', 'StreamController@favorites')->name('stream.favorites');

        //Edit stream
        Route::post('/updateStream', 'StreamController@updateStream');
    
    /* Actions sur le compte */
        Route::patch('/home/infos/', 'HomeController@updateInfos')->name('home.updateInfos');
        Route::patch('/home/stream/', 'HomeController@updateStream')->name('home.updateStream');
        Route::patch('/home/stats/', 'HomeController@updateStats')->name('home.updateStats');
        Route::patch('/home/subscription/', 'HomeController@updateSubscription')->name('home.updateSubscription');
        Route::resource('home', 'HomeController', ['only' => ['index','destroy']]);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/* Routes accessibles à tous */

//Informations des streams
Route::resource('stream', 'StreamController', ['only' => ['index', 'show']]);

//Recherche d'une chaine
Route::get('/autocomplete', 'StreamController@autocomplete')->name('autocomplete');
