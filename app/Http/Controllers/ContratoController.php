<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function show()
    {

        $contratos = DB::table('contratos')->get();

        if (!$contratos) {

            return response()->json([
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Oferta creada correctamente.",
                "obj" => $contratos,
                "state" => 200
            ], 200);
        }
    }
}
