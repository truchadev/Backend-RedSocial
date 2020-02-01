<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function show(){

        $estado = DB::table('estados')->get();
        return $estado;
    }
}
