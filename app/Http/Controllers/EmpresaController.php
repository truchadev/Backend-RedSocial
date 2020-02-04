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
    public function showOfertas(Request $request)
    {
       //return $request->user();
        $ofertasEmpresa = DB::table('ofertas')
            ->where('empresa_id', '=', $request->user()->id)
            ->get();

        if(!$ofertasEmpresa){
            return response()->json(["data" => [
                "error" => "No se ha encontrado nada",
                "state" => 400]
            ], 400);
        }else {
            return response()->json(["data" => [
                "message" => "Petición aceptada.",
                "state" => 200]
            ], 200);
        }
    }

    //Muestra usuarios por oferta
    public function showUsuarios(Request $request, $param)
    {
        $usuariosOfertas = DB::table('oferta__users')
            ->join('users', 'users.id', '=', 'oferta__users.user_id')
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
            ->where('ofertas.empresa_id', '=', $request->user()->id)
            ->where('oferta_id', '=', $param)
            ->get();

        if(!$usuariosOfertas){
            return response()->json(["data" => [
                "error" => "No se ha encontrado nada",
                "state" => 400]
            ], 400);
        }else {
            return response()->json(["data" => [
                "message" => "Petición aceptada.",
                "state" => 200]
            ], 200);
        }
    }

    //Crear ofertas
    public function nuevaOferta(Request $request)
    {

       // return $request->user();
            $newOferta = DB::table('ofertas')
            ->where('ofertas.empresa_id', '=', $request->user()->id)
            ->insert([
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

            if(!$newOferta){

                return response()->json(["data" => [
                    "error" => "Error. La oferta no se ha eliminado correctamente",
                    "state" => 400]
                ], 400);

            }else {
                return response()->json(["data" => [
                    "message" => "Oferta creada correctamente.",
                    "state" => 200]
                ], 200);
            }
    }


    //Borrar oferta
    public function deleteOferta(Request $request, $param)
    {

            $ofertaUser = DB::table('oferta__users')
                ->join('ofertas', 'ofertas.id', '=',  'oferta__users.oferta_id')
                ->where('oferta__users.oferta_id', '=', $param)
                ->where('ofertas.empresa_id', '=', $request->user()->id)
                ->delete();

            $ofertaId = DB::table('ofertas')
                ->where('ofertas.empresa_id', '=', $request->user()->id)
                ->where('id', '=', $param)
                ->delete();


                if ($ofertaUser && $ofertaId){

                    return response()->json(["data" => [
                        "message" => "Ofeta eliminada correctamente.",
                        "state" => 200]
                    ], 200);

                }else {

                    return response()->json(["data" => [
                        "error" => "Error. La oferta no se ha eliminado correctamente",
                        "state" => 400]
                    ], 400);
                }

    }

    //Borrar empresa
    public function deleteEmpresa(Request $request, $param){

       $userOferta = DB::table('oferta__users')
           ->join('ofertas', 'ofertas.id', '=',  'oferta__users.oferta_id')
          // ->where('oferta__users.oferta_id', '=', 'oferta.id')
           ->where('ofertas.empresa_id', '=', $request->user()->id)
           ->delete();

       $oferta = DB::table('ofertas')
           ->where('ofertas.empresa_id', '=', $request->user()->id)
           ->delete();




        DB::table('empresas')
           ->join('oferta__users','oferta__users.id','=','ofertas.id')
           ->where('id','=', $param)
           ->delete();
      }


    //Editar Perfil
    public function editar(Request $request)
    {
        $request->user();
        $validator = $this->validate($request, [
            'name' => 'alpha|max:255',
            'cif' => 'alpha|max:255',
            'name_responsable'=> 'alpha|max:255',
            'email' => 'email|unique:users',
            'password' => 'min:6',
            'about' => 'max:6|alpha_num',
            'ciudad_id' => 'numeric',
            'direccion' => 'max:255',
            'imagen_log' => 'url',
            'telefono' => 'numeric',
            'web' => 'url',
        ]);

        $datos = $request->all();

        $user = DB::table('empresas')
            ->where('id', $request->user()->id)
            ->update($datos);

        if (!$user) {
            return response()->json(['data' => [
                "error" => "Algo falló en el servidor. Inténtelo más tarde."
            ]]);
        }
        return response()->json(["data" => [
            "message" => "Cambios realizados correctamente.",
            "state" => 200]
        ], 200);

    }


}

