<?php

namespace App\Http\Controllers;

use App\Oferta;
use App\Ofertas_Tecnologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfertaController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Oferta::create([
            'puesto' => $request->puesto,
            'ciudad_id' => $request->ciudad_id,
            'salario_min' => $request->salario_min,
            'salario_max' => $request->salario_max,
            'descripcion' => $request->descripcion,
            'experiencia_min' => $request->experiencia_min,
            'empresa_id' => $request->empresa_id,
            'estudios_min_id' => $request->estudios_min_id,
            'tipo_contrato_id' => $request->tipo_contrato_id,
            'tipo_jornada_id' => $request->tipo_jornada_id
        ]);
        DB::table('Ofertas_Tecnologia')->insert(array(
            array('oferta_id' => $request->ofer1, 'tecnologia_id' => $request->tecno1),
            array('oferta_id' => $request->ofer2, 'tecnologia_id' => $request->tecno2),
            array('oferta_id' => $request->ofer3, 'tecnologia_id' => $request->tecno3)
        ));

    }


//mostrar oferats
    public function mostrar()
    {

        $ofertas = DB::table('ofertas')
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
//            ->join('ofertas__tecnologias', 'ofertas__tecnologias.oferta_id','=','ofertas.id' )
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas', 'OfertaController@mostrar');
    }

    //mostrar ofertas de una empresa por id oferta
    public function mostrarId($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->first();


        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correcta.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }

        //url
        Route::get('ofertas/{id}', 'OfertaController@mostrarId');
    }

    //mostrar ofertas por id de provincia
    public function provincia($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.ciudad_id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
//            ->join('ofertas__tecnologias', 'ofertas__tecnologias.oferta_id','=','ofertas.id' )
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/provincia/{id}', 'OfertaController@provincia');//ofertas por id ciudades
    }

    //mostrar ofertas por id de provincia
    public function experiencia($id)
    {
        $ofertas = DB::table('ofertas')
            ->where('ofertas.experiencia_min', '<=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/experiencia/{id}', 'OfertaController@experiencia');//ofertas por experiencia
    }

    //mostrar ofertas por id de provincia
    public function salario($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.salario_min', '>=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/salario/{id}', 'OfertaController@experiencia');//ofertas por salario
    }

    //mostrar ofertas por id de provincia
    public function jornada($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.tipo_jornada_id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/jornada/{id}', 'OfertaController@jornada');//ofertas por jornada
    }

    //mostrar ofertas por id de provincia
    public function contratos($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.tipo_contrato_id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/contratos/{id}', 'OfertaController@contratos');//ofertas por contrato
    }

    //mostrar ofertas por id de provincia
    public function estudios($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.estudios_min_id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
        Route::get('ofertas/estudios/{id}', 'OfertaController@estudios');//ofertas por contrato
    }

    //mostrar ofertas por id de emprsa
    public function empresas($id)
    {

        $ofertas = DB::table('ofertas')
            ->where('ofertas.empresa_id', '=', $id)
            ->join('empresas', 'empresas.id', '=', 'ofertas.empresa_id')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->join('tecnologias', 'tecnologias.id', '=', 'ofertas.tecnologia_id')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec', 'tipo_est', 'experiencia_min'
            )
            ->get();

        if (!$ofertas) {

            return response()->json([
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }

    }


}