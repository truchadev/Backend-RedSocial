<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function show(){

        $estudios = DB::table('estudios')->get();

        if(!$estudios){

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        }else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $estudios,
                "state" => 200]
            ], 200);
        }
    }
}
