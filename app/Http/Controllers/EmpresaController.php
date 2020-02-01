<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    //Muestra ofertas por ID de empresa
    public function showOfertas($id){
        $ofertasEmpresa = DB::table('ofertas' )

            ->where('empresa_id', '=', $id)
            ->get();

        return $ofertasEmpresa;
    }

    //Muestra usuarios por oferta
    public function showUsuarios($id){
        $usuariosOfertas = DB::table('oferta__users' )
           ->join('users', 'users.id','=','oferta__users.user_id')
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
           ->where('oferta_id', '=', $id)
            ->get();

        return $usuariosOfertas;
    }

    //Modifica estados de oferta
    public function modificarEstado($id){

    }

    //Crear ofertas

    public function nuevaOferta(){

    }

}




