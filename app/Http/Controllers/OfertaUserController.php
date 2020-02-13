<?php

namespace App\Http\Controllers;

use App\Oferta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Table;
use Validator;
use Illuminate\Http\Request;

class OfertaUserController extends Controller
{
    /**
     * Create the specified resource from storage.
     *              OFERTA-USERS
     */
    public function create(Request $request)
    {

        $idUser = $request->user()->id;

        try {

            $oferta = DB::table('oferta__users')
                ->where('oferta_id', '=', $request->oferta_id)
                ->where('user_id', '=', $idUser);


            if ($oferta->first()) {
                return response()->json([
                    "error" => "Ya estás registrado en esta oferta."
                ]);
            }
            $oferta = DB::table('oferta__users')
                ->insert(['oferta_id' => $request->oferta_id, 'user_id' => $idUser, 'estado_id' => 1]);


            return response()->json([
                    "message" => "Creado correctamente.",
                    'obj' => $oferta,
                    "state" => 200]
                , 200);

        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json([
                    "error" => "Error. Comprueba tus parámetros de consulta.",
                    "state" => 400]
                , 400);

        };

        //Route
        //  Route::get('user/ofertas/create/{id}', 'OfertaUserController@create');
    }


    /**
     * Update the specified resource from storage.
     *              OFERTA-USERS
     */
    public function update(Request $request)
    {

        //PROBAR CON EMPRESA REGISTRADA PARA CAPTURAR ID DESDE TOKEN


        // $datos = $request->all();
        //$user = $request->user();


        $oferta = DB::table('oferta__users')
            //   ->where('oferta__users.id', '=', $id)
            ->where('id', $request->id)
            ->update(['estado_id' => $request->estado_id]);

        if ($oferta) {
            return response()->json([
                "message" => "Creado correctamente.",
                'obj' => $oferta,
                "state" => 200
            ], 200);
        } else {
            return response()->json([
                "message" => "no correctamente.",
                'obj' => $oferta,
                "state" => 400
            ], 400);
        }

    }


    public function mostrarOfertas(Request $request)
    {

        $user = $request->user();
        $oferta = DB::table('oferta__users')
            ->where('user_id', '=', $user->id)
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
            //->join('ciudads', 'ciudads.id', '=', $user->ciudad_id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('estados', 'estados.id', '=', 'oferta__users.estado_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->select('oferta__users.oferta_id', 'puesto', 'name', 'salario_max', 'salario_min', 'tipo_est', 'descripcion', 'tipo_cont', 'tipo_jorn')
            ->get();

        if (!$oferta) {
            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);
        } else {
            return response()->json([
                    "message" => "Aceptada",
                    "obj" => $oferta,
                    "state" => 200]
                , 200);
        }
    }

    public function delete(Request $request, $id)
    {

        $user = $request->user();
        $oferta = DB::table('oferta__users')
            ->where('user_id', '=', $user->id)
            ->where('oferta_id', '=', $id)
            ->delete();

        if (!$oferta) {
            return response()->json([
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400
            ], 400);
        } else {
            return response()->json([
                    "message" => "Aceptada",
                    // "obj" => $oferta,
                    "state" => 200]
                , 200);
        }
    }
}
