<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JLaboralController extends Controller
{
    public function show(){

        $jornada = DB::table('j__laborals')->get();

        if(!$jornada){

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        }else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $jornada,
                "state" => 200]
            ], 200);
        }
    }
}
