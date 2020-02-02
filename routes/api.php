<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
//});
//
//Route::post('usuario/login', 'PassportController@login');
//Route::post('usuario/register', 'PassportController@register');
////Route::post('empresa/login', 'PassportController@login');
//Route::post('empresa/register', 'PassportController@register');
////ruta para activacion de cuenta por notificación por email
//Route::get('register/activate/{token}', 'PassportController@signupActivate');
//
///*
// * TODAS LAS RUTAS QUE NECESITEN AUTENTICACIÓN DEBEN ESTAR
// * DENTRO DE ROUTE:MIDDLEWARE.
// *
// * **/
//Route::middleware('auth:api')->group(function () {
////    Route::post('usuario/login', 'PassportController@login');
//
//    Route::post('empresa/login', 'PassportController@login');
//
//    Route::get('usuario/user', 'PassportController@details');
//});
//
//
//Route::post('empresa/empleo/create', 'OfertaController@create');

//NUEVAS RUTAS PARA API
//PÚBLICOS
Route::get('ciudades', 'CiudadController@show');
Route::get('tecnologias', 'TecnologiaController@show');
Route::get('estudios', 'EstudioController@show');
Route::get('contratos', 'ContratoController@show');
Route::get('jornadas', 'JLaboralController@show');
Route::get('estados', 'EstadoController@show');
Route::get('ofertas', 'OfertaController@mostrar');

//AUTH
Route::group(['prefix' => 'auth'], function () {//todas las rutas así en postman http://127.0.0.1:8000/api/auth/login
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        //PARA CONSULTAR PERFIL DE EMPRESA Y USUARIO CON EL TOKEN
        Route::get('user', 'AuthController@user');

    });
});

//PARA EL RESTO CON VALIDACIÓN TOKEN
//Route::group(['middleware' => 'auth:api'], function (){//todas las rutas así en postman http://127.0.0.1:8000/api/empresa
    //USERS
        //aquí las rutas de users...

    //EMPRESAS
        //aquí las rutas de empresas...
    Route::get('empresa/ofertas-empresa/{id}', 'EmpresaController@showOfertas');
    Route::get('empresa/ofertas-user/{id}', 'EmpresaController@showUsuarios');
    Route::patch('empresa/modificar-estado/{id}', 'EmpresaController@modificarEstado');
    Route::post('empresa/oferta', 'EmpresaController@nuevaOferta');
    Route::delete('empresa/oferta-delete/{id}', 'EmpresaController@deleteOferta');
    Route::delete('empresa/delete/{id}', 'EmpresaController@deleteEmpresa');
    Route::patch('empresa/editar/{id}', 'EmpresaController@editar');
//});
//fin nuevas rutas


// CUALQUIER RUTA NO EXISTENTE RECIBIRÁ NOT FOUND
Route::fallback(function () {
    return response()->json(['message' => 'OOOOPS! Algo no fué bien. La ruta no existe.'], 404);
})->name('api.fallback.404');


