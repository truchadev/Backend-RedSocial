<?php

namespace App\Http\Controllers;
use App\Ciudad;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CiudadController extends Controller
{
    public function show($id){

        $ciudad = DB::table('ciudads')
           ->join('ofertas', 'ofertas.ciudad_id', '=', 'ciudad_id' )
            ->select('puesto')
            ->where('ciudad_id', '=', $id)
            ->get();
        return $ciudad;

    }
}
