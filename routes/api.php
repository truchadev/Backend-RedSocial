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

Route::post('usuario/login', 'PassportController@login');
Route::post('usuario/register', 'PassportController@register');
Route::post('empresa/login', 'PassportController@login');
Route::post('empresa/register', 'PassportController@register');
//ruta para activacion de cuenta por notificación por email
Route::get('register/activate/{token}', 'PassportController@signupActivate');

Route::middleware('auth:api')->group(function () {
    Route::get('usuario/user', 'PassportController@details');
});


Route::post('empresa/empleo/create', 'OfertaController@create');




// CUALQUIER RUTA NO EXISTENTE RECIBIRÁ NOT FOUND
Route::fallback(function(){
    return response()->json(['message' => 'OOOOPS! Algo no fué bien. La ruta no existe.'], 404);
})->name('api.fallback.404');


// PÚBLICOS
Route::get('ciudades', 'CiudadController@show');
Route::get('tecnologias', 'TecnologiaController@show');
Route::get('estudios', 'EstudioController@show');
Route::get('contratos', 'ContratoController@show');
Route::get('jornadas', 'JLaboralController@show');
Route::get('estados', 'EstadoController@show');
Route::get('ofertas', 'OfertaController@mostrar');

//Empresa
Route::get('empresa/ofertas-empresa/{id}', 'EmpresaController@showOfertas');
Route::get('empresa/ofertas-user/{id}', 'EmpresaController@showUsuarios');
Route::patch('empresa/modificar-estado/{id}', 'EmpresaController@modificarEstado');
Route::post('empresa/oferta', 'EmpresaController@nuevaOferta');
