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
/*
    Route::get('/PersonalSanitario', 'Sanitarios\SanitariosController@index');

    Route::get('/sanitario/{id}', 'Sanitarios\SanitariosController@getSanitario');

    Route::get('/sanitarios/lista', 'Sanitarios\SanitariosController@getAllSanitario');
    Route::post('/sanitarios/lista', 'Sanitarios\SanitariosController@postAllSanitario');

    Route::get('/todos', 'Sanitarios\SanitariosController@todos');

    Route::get('/sanitarios/nuevo', 'Sanitarios\SanitariosController@nuevoSanitario');
    Route::post('/sanitarios/nuevo', 'Sanitarios\SanitariosController@postSanitario');
    Route::post('/sanitarios/update/{id}', 'Sanitarios\SanitariosController@putSanitario');
    Route::post('/sanitarios/avatar', 'Sanitarios\SanitariosController@putAvatar');

    Route::post('/sanitarios/borrar', 'Sanitarios\SanitariosController@deleteSoft');
    Route::post('/sanitarios/delete/{id}', 'Sanitarios\SanitariosController@deleteHard');
    Route::post('/deleteAll', 'Sanitarios\SanitariosController@deleteAllHard');
*/

    Route::post('/sanitario/lista', 'Sanitarios\SanitariosController@postAllSanitario');
    Route::put('/sanitario/avatar', 'Sanitarios\SanitariosController@putAvatar');
    Route::resource('sanitario', 'Sanitarios\SanitariosController');

    Route::post('/residente/lista', 'Residentes\ResidentesController@postAllResidente');
    Route::put('/residente/avatar', 'Residentes\ResidentesController@putAvatar');
    Route::resource('residente', 'Residentes\ResidentesController');

    Route::post('/actividad/lista', 'Actividades\ActividadesController@postAllActividad');
    Route::resource('actividad', 'Actividades\ActividadesController');




    Route::get('/', function () {
        return view('welcome');
    });




    Route::get('/limpiarCache', function () {
        $exitCode = Artisan::call('cache:clear');
        //return redirect()->action('Sanitarios\SanitariosController@getPrueba');
        return "Cache limpiada";
    });


});

Route::get('/logon', function(){
    if(Auth::check()){

       // return 'Logado';
      //  return 'Administrador'.Auth::user();
    }else{
        //return Redirect('/login');
      //  return 'invitado: '.Auth::guest()."    ".Auth::user();
    }

})->middleware('is_check'); //.Auth::check();

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