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
Route::group(['middleware' => ['auth','web']], function () {
    Route::auth();
    //Route::get('/home', 'HomeController@index');



    Route::get('/PersonalSanitario', 'Sanitarios\SanitariosController@index');

    Route::get('/sanitario/{id}', 'Sanitarios\SanitariosController@getSanitario');
    Route::get('/sanitarios', 'Sanitarios\SanitariosController@getAllSanitario');
    Route::get('/todos', 'Sanitarios\SanitariosController@todos');
    Route::get('/new', 'Sanitarios\SanitariosController@postSanitario');

    Route::delete('/borrar/{id}', 'Sanitarios\SanitariosController@deleteSoft');
    Route::get('/delete/{id}', 'Sanitarios\SanitariosController@deleteHard');
    Route::get('/deleteAll', 'Sanitarios\SanitariosController@deleteAllHard');


    Route::get('/', function () {
        return view('welcome');
    });




    Route::get('/limpiarCache', function () {
        $exitCode = Artisan::call('cache:clear');
        //return redirect()->action('Sanitarios\SanitariosController@getPrueba');
        return "Cache limpiada";
    });
});

//Route::get('/home', 'HomeController@index');


/**
 * con el middleware ('auth') obliga a pasar por el login
 */
Route::get('/', function () {
    return view('welcome');
    //return redirect()->action('Sanitarios\SanitariosController@getPrueba');
})->middleware('auth');

Route::get('/prueba', 'Sanitarios\SanitariosController@getPrueba');
Route::get('/prueba/{id?}', 'Sanitarios\SanitariosController@getSanitario');