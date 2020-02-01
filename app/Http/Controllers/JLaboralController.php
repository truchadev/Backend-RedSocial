<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JLaboralController extends Controller
{
    public function show(){

        $jornada = DB::table('j__laborals')->get();
        return $jornada;
    }
}
