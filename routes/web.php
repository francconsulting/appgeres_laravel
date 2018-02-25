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
//Route::auth();






Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

});

//agregado el grupo para que acceda al login directamente
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/', function () {
        return view('welcome');
    });
});

//Route::get('/home', 'HomeController@index');


/**
 * con el middleware ('auth') obliga a pasar por el login
 */
Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/prueba', 'Sanitarios\SanitariosController@getPrueba');
Route::get('/prueba/{id?}', 'Sanitarios\SanitariosController@getSanitario');