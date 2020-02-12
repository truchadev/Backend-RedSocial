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
Route::get('empresas', 'EmpresaController@showEmpresasName');


//busquedas
//Route::get('ofertas/{id}', 'OfertaController@mostrarId');//mostrar ofertas de empresas por id de empresa

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

//PARA USERS
Route::group(['middleware' => 'auth:api'], function () {//todas las rutas así en postman http://127.0.0.1:8000/api/user
    //USERS
    //aquí las rutas de users...
    Route::post('user/update', 'UserController@update');
    Route::post('user/experiencia/create', 'ExperienciaUserController@create');
    Route::post('user/experiencia/update/{id}', 'ExperienciaUserController@update');
    Route::post('user/experiencia/destroy/{id}', 'ExperienciaUserController@destroy');
    Route::get('user/experiencia/show', 'ExperienciaUserController@show');
    Route::delete('user/estudios/destroy/{id}', 'EstudioUserController@destroy');
    Route::get('user/estudios/show', 'EstudioUserController@show');
    Route::post('user/estudios/update/{id}', 'EstudioUserController@update');
    Route::post('user/estudios/create', 'EstudioUserController@create');
    Route::post('user/ofertas/create', 'OfertaUserController@create');
    Route::get('user/mostrar-ofertas', 'OfertaUserController@mostrarOfertas');
    Route::delete('user/ofertas/delete/{id}', 'OfertaUserController@delete');//el usuario elimina oferta

    //probadas
    Route::get('ofertas/{id}', 'OfertaController@mostrarId');//mostrar ofertas de empresas por id de empresa
    Route::get('ofertas/provincia/{id}', 'OfertaController@provincia');//ofertas por id ciudades
    Route::get('ofertas/estudios/{id}', 'OfertaController@estudios');//ofertas por estudios
    Route::get('ofertas/experiencia/{id}', 'OfertaController@experiencia');//ofertas por experiencia
    Route::get('ofertas/salario/{id}', 'OfertaController@salario');//ofertas por salario
    Route::get('ofertas/jornada/{id}', 'OfertaController@jornada');//ofertas por jornada
    Route::get('ofertas/contratos/{id}', 'OfertaController@contratos');//ofertas por contrato
    Route::get('ofertas/empresas/{id}', 'OfertaController@empresas');//ofertas por nombre de empresa



});

//PARA EMPRESAS
Route::group(['middleware' => 'auth:empresas'], function (){//todas las rutas así en postman http://127.0.0.1:8000/api/empresa

    //EMPRESAS
        //aquí las rutas de empresas...

    Route::get('empresa/ofertas', 'EmpresaController@showOfertas');
    Route::get('empresa/users-ofertas/{id}', 'EmpresaController@showUsuarios');
    Route::post('empresa/new-oferta', 'EmpresaController@nuevaOferta');
    Route::delete('empresa/oferta-delete/{id}', 'EmpresaController@deleteOferta');
    Route::delete('empresa/delete/{id}', 'EmpresaController@deleteEmpresa');
    Route::post('empresa/editar', 'EmpresaController@editar');
    Route::post('empresa/estado/update/{id}', 'OfertaUserController@update');


});
//fin nuevas rutas
;
//Route::post('empresa/editar', 'EmpresaController@editar');

// CUALQUIER RUTA NO EXISTENTE RECIBIRÁ NOT FOUND
Route::fallback(function () {
    return response()->json(['message' => 'OOOOPS! Algo no fué bien. La ruta no existe.'], 404);
})->name('api.fallback.404');

//RUTAS OFERTAS
//Route::get('ofertas/populares', 'OfertaController@showOfertasPopularidad');
//Route::get('ofertas/provincia/{id}', 'OfertaController@provincia');
//Route::get('ofertas/contrato/{id}', 'OfertaController@contrato');
//Route::get('ofertas/j-laboral/{id}', 'OfertaController@j_laboral');
//Route::get('ofertas/salario/{id}', 'OfertaController@salario');
//Route::get('ofertas/experiencia/{id}', 'OfertaController@experiencia');



