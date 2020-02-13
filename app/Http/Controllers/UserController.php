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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request)
    {


    }

    /**
     * Update the specified resource in storage.
     *          PERFIL
     */
    public function update(Request $request)
    {

        $user = DB::table('users')
            ->where('id', $request->user()->id)
            ->update($request->all());

        if (!$user) {
            return response()->json(['data' => [
                "error" => "Algo falló en el servidor. Inténtelo más tarde."
            ]]);
        }
        return response()->json([
            "message" => "Cambios realizados correctamente.",
            "obj"=>$request->user(),
            "state" => 200
        ], 200);
        //route
       // Route::post('user/update', 'UserController@update');
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Marca $marca)
    {


    }
}
