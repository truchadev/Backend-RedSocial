<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CiudadController extends Controller
{
    public function show(){

        $ciudades = DB::table('ciudads')->get();

        if(!$ciudades){

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        }else {
            return response()->json( [
                "message" => "Oferta creada correctamente.",
                "obj" => $ciudades,
                "state" => 200
            ], 200);
        }

    }

}
