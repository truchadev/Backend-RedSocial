<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class EstudioUserController extends Controller
{


    /**
     * Create the specified resource from storage.
     *              ESTUDIOS-USERS
     */
    public function create(Request $request)
    {
        $validator = $this->validate($request, [
            'centro' => 'max:255|present',
            'fecha_inicio' => 'date|present',
            'fecha_fin' => 'date|present',
            'ciudad_id' => 'numeric|present',
            'estudio_id' => 'numeric|present'
        ]);

        $datos = $request->all();

        $datos = array_merge($datos, ['user_id' => $request->user()->id]);

        $estudios = DB::table('estudio__users')
            ->insert($datos);

        if (!$estudios) {
            return response()->json(['data' => [
                "error" => "Error. No se encontró el recurso."
            ]]);
        }

        return response()->json(["data" => [
            "message" => "Creado correctamente.",
            "state" => 200]
        ], 200);

        //route
        Route::post('user/estudios/create', 'EstudioUserController@create');
    }

    /**
     * Delete the specified resource from storage.
     *              ESTUDIOS-USERS
     */
    public function destroy(Request $request, $id)
    {

        try {

            $estudio = DB::table('estudio__users')
                ->where('id', '=', $id)
                ->where('user_id', '=', $request->user()->id)
                ->delete();

            if (!$estudio) {
                return response()->json(['data' => [
                    "error" => "Error. No se encontró el recurso."
                ]]);
            }

            return response()->json(["data" => [
                "message" => "Borrado realizados correctamente.",
                "state" => 200]
            ], 200);

        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);

        }
        //route
        Route::delete('user/estudios/destroy/{id}', 'EstudioUserController@destroy');
    }

    /**
     * Update the specified resource from storage.
     *              ESTUDIOS-USERS
     */
    public function update(Request $request, $id)
    {

        try {

            $validator = $this->validate($request, [
                'centro' => 'max:255',
                'fecha_inicio' => 'date',
                'fecha_fin' => 'date',
                'ciudad_id' => 'numeric',
                'estudio_id' => 'numeric'
            ]);

            $datos = $request->all();

            $estudio = DB::table('estudio__users')
                ->where('id', '=', $id)
                ->where('user_id', '=', $request->user()->id)
                ->update($datos);

            if (!$estudio) {
                return response()->json(['data' => [
                    "error" => "Error. No se encontró el recurso."
                ]]);
            }

            return response()->json(["data" => [
                "message" => "Actualización  realizada correctamente.",
                "state" => 200]
            ], 200);
        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);

        }

        //route
        Route::post('user/estudios/update/{id}', 'EstudioUserController@update');
    }

    /**
     * Show the specified resource from storage.
     *              ESTUDIOS-USERS
     */
    public function show(Request $request)
    {
        $experiencia = DB::table('estudio__users')
            ->where('user_id', '=', $request->user()->id)
            ->get();

        if (!$experiencia) {
            return response()->json(['data' => [
                "error" => "Error. No se encontró el recurso."
            ]]);
        }

        return response()->json(["data" => [
            "message" => "Consulta realizada.",
            "elemento" => $experiencia,
            "state" => 200]
        ], 200);

        //route
        Route::get('user/estudios/show', 'EstudioUserController@show');
    }
}
