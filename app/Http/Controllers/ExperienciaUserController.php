<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienciaUserController extends Controller
{
    /**
     * Create the specified resource from storage.
     *              EXPERIENCIA-USERS
     */
    public function create(Request $request)
    {
        $validator = $this->validate($request, [
            'puesto' => 'max:255|present',
            'descripcion' => 'max:255|present',
            'fecha_inicio' => 'date|present',
            'fecha_fin' => 'date|present',
            'ciudad_id' => 'numeric|present',
        ]);

        $datos = $request->all();

        $datos = array_merge($datos, ['user_id' => $request->user()->id]);

        $experiencia = DB::table('experiencia__users')
            ->insert($datos);

        if (!$experiencia) {
            return response()->json(['data' => [
                "error" => "Error. No se encontró el recurso."
            ]]);
        }

        return response()->json(["data" => [
            "message" => "Creado correctamente.",
            "state" => 200]
        ], 200);

        //route
      //  Route::post('user/experiencia/create', 'ExperienciaUserController@create');
    }

    /**
     * Update the specified resource from storage.
     *              EXPERIENCIA-USERS
     */
    public function update(Request $request, $id)
    {

        try {

            $validator = $this->validate($request, [
                'puesto' => 'max:255',
                'descripcion' => 'max:255',
                'fecha_inicio' => 'date',
                'fecha_fin' => 'date',
                'ciudad_id' => 'numeric',
            ]);

            $datos = $request->all();

            $estudio = DB::table('experiencia__users')
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
     //   Route::post('user/experiencia/update/{id}', 'ExperienciaUserController@update');
    }


    /**
     * Destroy the specified resource from storage.
     *              EXPERIENCIA-USERS
     */
    public function destroy(Request $request, $id)
    {

        try {

            $estudio = DB::table('experiencia__users')
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
      //  Route::post('user/experiencia/destroy/{id}', 'ExperienciaUserController@destroy');
    }


    /**
     * Show the specified resource from storage.
     *              EXPERIENCIA-USERS
     */
    public function show(Request $request)
    {
        $experiencia = DB::table('experiencia__users')
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
      //  Route::get('user/experiencia/show', 'ExperienciaUserController@show');
    }
}
