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

    public function mostrar(){

        $ofertas = DB::table('ofertas')->get();
        return $ofertas;
    }

    public function provincia($id){

        $ofertasProvincia = DB::table('ofertas')
            ->join('ciudads', 'ciudads.id', '=', 'ofertas.ciudad_id')
            ->where('ciudad_id', '=', $id)
            ->get();
        return $ofertasProvincia;
    }




}
