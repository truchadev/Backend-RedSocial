<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function show(){

        $estudios = DB::table('estudios')->get();
        return $estudios;
    }
}
