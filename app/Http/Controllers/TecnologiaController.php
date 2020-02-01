<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TecnologiaController extends Controller
{
    public function show(){

        $tecnologias = DB::table('tecnologias')->get();
        return $tecnologias;
    }
}
