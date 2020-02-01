<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function show(){

        $contratos = DB::table('contratos')->get();
        return $contratos;
    }
}
