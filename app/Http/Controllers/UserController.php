<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50|unique:marcas',
        ], ['nombre.unique' => 'No se ha grabado porque la marca introducida ya la has usado antes. Introduce otra por favor.',
            'nombre.required' => 'Introduce la marca por favor.']);
        if ($validator->fails()) {
            return redirect('marcas/create')
                ->withErrors($validator)
                ->withInput();
        }
        Marca::create($request->except('_token'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')->first('usuario_id', $id);
//        return response()->json(["data" => [
//            "user" => $user,
//            "status" => 200,
//        ]]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50|unique:marcas',
        ], [
            'nombre.unique' => 'No se ha grabado porque la marca introducida ya la has usado antes. Introduce otra por favor.',
            'nombre.required' => 'Introduce la marca por favor.'
        ]);
        if ($validator->fails()) {
            return redirect()->route('marcas.edit', $marca->id)->withErrors($validator)->withInput();
            // equivalente redirect('marcas/'. $marca->id.'/edit')->withErrors($validator)->withInput();
        }
        $input = $request->all();
        $marca->fill($input)->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        $marca->delete();

    }
}
