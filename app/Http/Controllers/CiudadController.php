<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CiudadController extends Controller
{
    public function show(){

        $ciudades = DB::table('ciudads')->get();
        return $ciudades;
    }

    public function mostrarId(){

    }
}
