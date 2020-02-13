<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class JLaboralController extends Controller
{
    public function show()
    {

        $jornada = DB::table('j__laborals')->get();

        if (!$jornada) {

            return response()->json([
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Oferta creada correctamente.",
                "obj" => $jornada,
                "state" => 200
            ], 200);
        }
    }
}
