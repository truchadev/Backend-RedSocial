<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    public function show()
    {

        $estado = DB::table('estados')->get();

        if (!$estado) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $estado,
                "state" => 200]
            ], 200);
        }
    }
}
