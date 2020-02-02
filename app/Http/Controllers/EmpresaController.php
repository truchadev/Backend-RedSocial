<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Oferta;
use App\Empresa;
use Laravel\Passport\HasApiTokens;

class EmpresaController extends Controller
{


    //Muestra ofertas por ID de empresa
    public function showOfertas($id)
    {
        $ofertasEmpresa = DB::table('ofertas')
            ->where('empresa_id', '=', $id)
            ->get();

        return $ofertasEmpresa;
    }

    //Muestra usuarios por oferta
    public function showUsuarios($id)
    {
        $usuariosOfertas = DB::table('oferta__users')
            ->join('users', 'users.id', '=', 'oferta__users.user_id')
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
            ->where('oferta_id', '=', $id)
            ->get();

        return $usuariosOfertas;
    }

    //Modifica estados de oferta
    public function modificarEstado($id)
    {

    }

    //Crear ofertas
    public function nuevaOferta(Request $request)
    {

        DB::table('ofertas')->insert([
            'puesto' => $request->input('puesto'),
            'ciudad_id' => $request->input('ciudad_id'),
            'salario_min' => $request->input('salario_min'),
            'salario_max' => $request->input('salario_max'),
            'descripcion' => $request->input('descripcion'),
            'experiencia_min' => $request->input('experiencia_min'),
            'empresa_id' => $request->input('empresa_id'),
            'estudios_min_id' => $request->input('estudios_min_id'),
            'tipo_contrato_id' => $request->input('tipo_contrato_id'),
            'tipo_jornada_id' => $request->input('tipo_jornada_id'),
            'created_at' => null,
            'updated_at' => null
        ]);
    }


    //Borrar oferta
    public function deleteOferta($id)
    {
        DB::table('ofertas')
            ->join('oferta__users', 'empresa_id')
            ->where('id', '=', $id)
            ->delete();
    }

    //Borrar empresa
    //public function deleteEmpresa($id){
    //   DB::table('empresas')
    //        ->join('oferta__users','oferta__users.id','=','ofertas.id')
    //       ->where('id','=', $id)
    //       ->delete();
    //  }


    //Editar Perfil
    public function editar(Request $request)
    {

         DB::table('empresas')->update([
            //'name' => $request->input('name'),
            'about' => $request->input('cif'),
           // 'ciudad_id' => $request->input('ciudad_id'),
            'direccion' => $request->input('direccion'),
            'imagen_logo' => $request->input('imagen_logo'),
            'name_responsable' => $request->input('name_responsable'),
            'telefono' => $request->input('telefono'),
            'web' => $request->input('web'),
           // 'email' => $request->input('email'),
        ]);

    }


}

