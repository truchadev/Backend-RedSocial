<?php

namespace App\Http\Controllers;

use App\Oferta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class OfertaUserController extends Controller
{
    /**
     * Create the specified resource from storage.
     *              OFERTA-USERS
     */
    public function create(Request $request, $id)
    {

        $idUser = $request->user()->id;
        try {

            $oferta = DB::table('oferta__users')
                ->where('oferta_id', $id)
                ->where('user_id', $idUser);


            if ($oferta->first()) {
                return response()->json(['data' => [
                    "error" => "Ya estás registrado en esta oferta."
                ]]);
            }

            $oferta = DB::table('oferta__users')
                ->insert(['oferta_id' => $id, 'user_id' => $idUser, 'estado_id' => 1]);


            return response()->json(["data" => [
                "message" => "Creado correctamente.",
                'obj' => $oferta,
                "state" => 200]
            ], 200);

        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);

        };

        //Route
        Route::get('user/ofertas/create/{id}', 'OfertaUserController@create');
    }


    /**
     * Update the specified resource from storage.
     *              OFERTA-USERS
     */
    public function update(Request $request)
    {

        //PROBAR CON EMPRESA REGISTRADA PARA CAPTURAR ID DESDE TOKEN
        try {
            $validator = $this->validate($request, [
                'user_id' => 'numeric',
                'estado_id' => 'numeric',
                'oferta_id' => 'numeric',
            ]);

            $datos = $request->all();

            $oferta = DB::table('oferta__users')
                ->where('user_id', '=',$request->user_id)
                ->where('oferta_id', '=', $request->oferta_id)
                ->join('ofertas', 'oferta__users.oferta_id', '=', 'ofertas.id')
                ->where('empresa_id', '=', 9)//CAMBIAR POR EL USER DEL TOKEN

//                ->where('user_id', $request->user_id)
//                ->update('estado_id', $datos->estado_id);
                ->update($datos);

            if($oferta === 0){
                return response()->json(["data" => [
                    "error" => "La consulta contiene los mismos parámetros",
                    "state" => 400]
                ], 400);
            }

            return response()->json(["data" => [
                "message" => "Creado correctamente.",
                'obj' => $oferta,
                "state" => 200]
            ], 200);

        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);

        }

        //Route
        Route::post('empresa/estado/update/{id}', 'OfertaUserController@update');
    }
}
