<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TecnologiaController extends Controller
{
    public function show(){

        $tecnologias = DB::table('tecnologias')->get();

        if(!$tecnologias){

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        }else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $tecnologias,
                "state" => 200]
            ], 200);
        }
    }
}
