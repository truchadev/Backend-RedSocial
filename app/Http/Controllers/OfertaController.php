<?php

namespace App\Http\Controllers;

use App\Oferta;
use App\Ofertas_Tecnologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfertaController extends Controller
{
    public function index()
    {
        // if (Auth::check()) {
//        $marcas = Marca::paginate(8,['id','nombre']);
//        return view('marca.lista', ['marcas' => $marcas]);
        // }else{
        // Session::flash('warning', "Debes Identificarte para acceder a esta página");
        // return redirect()->to('home');
        // }
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'nombre' => 'required|max:50|unique:marcas',
//        ], ['nombre.unique' => 'No se ha grabado porque la marca introducida ya la has usado antes. Introduce otra por favor.',
//            'nombre.required' => 'Introduce la marca por favor.']);
//        if ($validator->fails()) {
//            return redirect('marcas/create')
//                ->withErrors($validator)
//                ->withInput();
//        }
//        Marca::create($request->except('_token'));
//        Session::flash('success', 'Marca insertada');
//        return redirect()->route('marcas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
//        $tipo = 'delete';
//        return View('marca.show', compact('marca', 'tipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
//        return View('marca.edit',['marca' => $marca]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
//        $validator = Validator::make($request->all(), [
//            'nombre' => 'required|max:50|unique:marcas',
//        ], [
//            'nombre.unique' => 'No se ha grabado porque la marca introducida ya la has usado antes. Introduce otra por favor.',
//            'nombre.required' => 'Introduce la marca por favor.'
//        ]);
//        if ($validator->fails()) {
//            return redirect()->route('marcas.edit', $marca->id)->withErrors($validator)->withInput();
//            // equivalente redirect('marcas/'. $marca->id.'/edit')->withErrors($validator)->withInput();
//        }
//        $input = $request->all();
//        $marca->fill($input)->save();
//        Session::flash('success', 'Marca "' . $marca->id . '" actualizada');
//        return redirect()->route('marcas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
//        $marca->delete();
//        Session::flash('success', 'Marca "' . $marca->nombre . '" eliminada');
//        return redirect()->route('marcas.index');
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
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec','tipo_est'
            )
            ->get();

        if (!$ofertas) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }
    }

    //mostrar ofertas de una empresa
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
//            ->whereColumn([
//                ['ofertas.id', '=', 'ofertas__tecnologias.oferta_id'],
//                ['ofertas__tecnologias.tecnologia_id', '=', 'tecnologias.id']
//            ])
//            ->having('ofertas.id', '=', $id)
            ->where('ofertas.id', '=', $id)
            ->select('ofertas.id', 'puesto', 'salario_min', 'salario_max', 'descripcion', 'name', 'cif', 'email', 'about', 'direccion',
                'imagen_logo', 'name_responsable', 'telefono', 'web', 'name_ciu', 'tipo_jorn', 'tipo_cont', 'name_tec','tipo_est'
                )
            ->first();


        if (!$ofertas) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha mostrado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json([
                "message" => "Petición correctamente.",
                "obj" => $ofertas,
                "state" => 200
            ], 200);
        }

        //url
        Route::get('ofertas/{id}', 'OfertaController@mostrarId');
    }

    public function provincia($id)
    {

        $ofertasProvincia = DB::table('ofertas')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->where('ciudad_id', '=', $id)
            ->get();

        if (!$ofertasProvincia) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasProvincia,
                "state" => 200]
            ], 200);
        }
    }

    public function contrato($id)
    {

        $ofertasContrato = DB::table('ofertas')
            ->join('contratos', 'contratos.id', '=', 'ofertas.tipo_contrato_id')
            ->where('tipo_contrato_id', '=', $id)
            ->get();

        if (!$ofertasContrato) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasContrato,
                "state" => 200]
            ], 200);
        }
    }

    public function j_laboral($id)
    {

        $ofertasJornada = DB::table('ofertas')
            ->join('j__laborals', 'j__laborals.id', '=', 'ofertas.tipo_jornada_id')
            ->where('tipo_jornada_id', '=', $id)
            ->get();

        if (!$ofertasJornada) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasJornada,
                "state" => 200]
            ], 200);
        }
    }

    public function salario(Request $request, $id)
    {
        try {
            $ofertasSalario = DB::table('ofertas')
                ->where('salario_min', '<=', $id)
                ->where('salario_max', '>=', $id)
                ->orderBy('salario_min', 'desc')
                ->get();


            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasSalario,
                "state" => 200]
            ], 200);

        } catch (\Illuminate\Database\QueryException  $e) {

            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);

        }
    }

    public function experiencia($id)
    {

        if (is_numeric($id)) {
            $ofertasExp = DB::table('ofertas')
                ->where('experiencia_min', '<=', $id)
                ->orderBy('experiencia_min', 'desc')
                ->get();

            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasExp,
                "state" => 200]
            ], 200);

        } else {
            return response()->json(["data" => [
                "error" => "Error. Comprueba tus parámetros de consulta.",
                "state" => 400]
            ], 400);
        }
    }

    public function estudios($id)
    {

        $ofertasEstu = DB::table('ofertas')
            ->join('estudios', 'estudios.id', '=', 'ofertas.estudios_min_id')
            ->where('estudios_min_id', '=', $id)
            ->get();


        if (!$ofertasEstu) {

            return response()->json(["data" => [
                "error" => "Error. La oferta no se ha eliminado correctamente",
                "state" => 400]
            ], 400);

        } else {
            return response()->json(["data" => [
                "message" => "Oferta creada correctamente.",
                "data" => $ofertasEstu,
                "state" => 200]
            ], 200);
        }
    }


}
