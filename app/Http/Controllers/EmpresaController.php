<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Oferta;
use App\Empresa;
use Laravel\Passport\HasApiTokens;

class EmpresaController extends Controller
{

    //mostrar ofertas de una empresa
//    public function mostrarId($id)
//    {
//
//        $ofertas = DB::table('ofertas')
//            ->where('ofertas.id', '=', $id)
//            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
//            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
//            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
//            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
//            ->join('ofertas__tecnologias', 'ofertas__tecnologias.oferta_id','=','ofertas.id' )
//            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas__tecnologias.tecnologia_id')
//            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
//            ->get();
//
//
//        if (!$ofertas) {
//
//            return response()->json(["data" => [
//                "error" => "Error. La oferta no se ha mostrado correctamente",
//                "state" => 400]
//            ], 400);
//
//        } else {
//            return response()->json([
//                "message" => "Petición correctamente.",
//                "obj" => $ofertas,
//                "state" => 200
//            ], 200);
//        }
//
//        //url
//        Route::get('ofertas/{id}', 'EmpresaController@mostrarId');
//    }

    //Muestra ofertas por ID de empresa
    public function showOfertas(Request $request)
    {
       //return $request->user();
        $ofertasEmpresa = DB::table('ofertas')
            ->where('empresa_id', '=', $request->user()->id)
            ->get();

        if(!$ofertasEmpresa){
            return response()->json([
                "error" => "No se ha encontrado nada",
                "state" => 400
            ], 400);
        }else {
            return response()->json([
                "message" => "Petición aceptada.",
                "obj" => $ofertasEmpresa,
                "state" => 200
            ], 200);
        }
    }

    //Muestra usuarios por oferta
    public function showUsuarios(Request $request, $param)
    {
        $usuariosOfertas = DB::table('oferta__users')
            ->join('users', 'users.id', '=', 'oferta__users.user_id')
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
            ->join('estudios', 'estudios.id', '=', 'users.estudios_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'users.tecnologia_id')
            ->join('experiencia__users', 'experiencia__users.id', '=', 'users.id')
           ->join('estados', 'estados.id', '=', 'oferta__users.estado_id')
            ->where('ofertas.empresa_id', '=', $request->user()->id)
            ->where('oferta_id', '=', $param)
            ->select('ofertas.id','oferta__users.id as ofer_user_id', 'users.name', 'prim_apellido', 'seg_apellido', 'users.email', 'users.about', 'users.direccion', 'imagen', 'sexo',
                'users.telefono', 'estudios.tipo_est', 'name_tec', 'experiencia__users.puesto', 'experiencia__users.descripcion', 'fecha_inicio', 'fecha_fin', 'estado_id', 'estados.tipo_est as tipo_estado')
            ->get();

        if(!$usuariosOfertas){
            return response()->json([
                "error" => "No se ha encontrado nada",
                "state" => 400]
            , 400);

        }else {
            return response()->json([
                "message" => "Petición aceptada.",
                "obj" => $usuariosOfertas,
                "state" => 200]
            , 200);
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
                'tecnologia_id' => $request->input('tecnologia_id'),

                'created_at' => null,
            'updated_at' => null
        ]);

            if(!$newOferta){

                return response()->json(["data" => [
                    "error" => "Error. La oferta no se ha creado correctamente",
                    "state" => 400]
                ], 400);

            }else {
                return response()->json(["data" => [
                    "message" => "Oferta creada correctamente.",
                    "data" => $newOferta,
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

                    return response()->json([
                        "message" => "Ofeta eliminada correctamente.",
                        "state" => 200
                    ], 200);

                }else {

                    return response()->json([
                        "error" => "Error. La oferta no se ha eliminado correctamente",
                        "state" => 400
                    ], 400);
                }

    }

    //Borrar empresa
    public function deleteEmpresa(Request $request, $param)
    {

        $userOferta = DB::table('oferta__users')
            ->join('ofertas', 'ofertas.id', '=', 'oferta__users.oferta_id')
            // ->where('oferta__users.oferta_id', '=', 'oferta.id')
            ->where('ofertas.empresa_id', '=', $param)
            ->where('ofertas.empresa_id', '=', $request->user()->id)
            ->delete();

        $oferta = DB::table('ofertas')
            ->where('ofertas.empresa_id', '=', $param)
            ->delete();

        $empresa = DB::table('empresas')
            ->where('id', '=', $param)
            ->delete();



        if ($userOferta && $oferta && $empresa){

            return response()->json(["data" => [
                "message" => "Empresa eliminada correctamente.",
                "state" => 200]
            ], 200);

        }else {

            return response()->json(["data" => [
                "error" => "Error. La empresa no se ha eliminado correctamente",
                "state" => 400]
            ], 400);
        }
    }






    //Editar Perfil
    public function editar(Request $request)
    {

        $request->user();
//        $validator = $this->validate($request, [
//            'name' => 'max:255',
//            'cif' => 'max:255',
//            'name_responsable'=> 'alpha|max:255',
//            'email' => 'email|unique:empresas',
//            'password' => 'min:6',
//            'about' => 'max:255',
//            'ciudad_id' => 'numeric',
//            'direccion' => 'max:255',
//            'imagen_log' => 'url',
//            'telefono' => 'numeric',
//            'web' => 'url',
//        ]);

//        $datos = $request->all();

        $user = DB::table('empresas')
            ->where('id', $request->user()->id)
            ->update($request->all());

        if (!$user) {
            return response()->json([
                "error" => "Algo falló en el servidor. Inténtelo más tarde."
            ]);
        }
        return response()->json([
            "message" => "Cambios realizados correctamente.",
            "obj" => $user,
            "state" => 200
        ], 200);

    }

    // MOSTRAR TODAS LAS EMPRESAS POR NOMBRE

    public function showEmpresasName (){
        $empresa = DB::table('empresas')
            ->select('id','name')
            ->get();

        if (!$empresa) {
            return response()->json(['data' => [
                "error" => "Algo falló en el servidor. Inténtelo más tarde."
            ]]);
        }
        return response()->json( [
            "message" => "Aceptada",
            "obj" => $empresa,
            "state" => 200]
        , 200);
    }




}

