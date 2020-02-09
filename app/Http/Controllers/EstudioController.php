<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function show(){

        $estudios = DB::table('estudios')->get();

        if(!$estudios){

            return response()->json([
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400
            ], 400);

        }else {
            return response()->json([
                "message" => "Oferta creada correctamente.",
                "obj" => $estudios,
                "state" => 200
            ], 200);
        }
    }
}
