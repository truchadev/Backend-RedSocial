<?php

namespace App\Http\Controllers;

use App\Notifications\SignupActivate;
use App\User;
use App\Empresa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Exception;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        if ($request->tipo === "usuario") {

            //Validamos los campos
            $validator = $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'ciudad_id' => 'required|min:1',
            ]);

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id
            ]);

            $user->save();

            //notificacion por email de datos
//            $user->notify(new SignupActivate($user));

            return response()->json(["data" => [
                "message" => "Usuario registrado correctamente",
                "state" => 200]
            ], 200);

        } else {

            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:empresas',
                'password' => 'required|min:6',
                'ciudad_id' => 'min:1',
            ]);

            $empresas = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id
            ]);

            $empresas->save();

            //notificacion por email de datos
//            $empresas->notify(new SignupActivate($empresas));

            return response()->json(["data" => [
                "message" => "Usuario registrado",
                "state" => 200]
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:empresas',
            'password' => 'required|min:6',
            'remember_me' => 'boolean',
        ]);

        //LLamada a BBDD y traemos datos cliente
        $consulta = DB::table('users')->where('email', $request->email)->get();

        //Comprobamos si array estrá vacío. Si lo está, no ha encontrado datos en BBDD que coincidan.
        if (sizeof($consulta) == "") {
            return response()->json(["data" => [
                "error" => "Error en Login. Revise sus datos.",
                "status" => 400,
            ]]);
        }

        if ($request->tipo === 'usuario') {
            $cliente = User::find($consulta[0]->id);
        } else {
            $cliente = Empresa::find($consulta[0]->id);
        }

        if (!$cliente) {
            return response()->json(["data" => [
                "error" => 'Error. Compruebe acceso como "usuario" o como "empresa".',
                "status" => 400,
            ]]);
        }
        $tokenResult = $cliente->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(4);
        }

        return response()->json(["data" => [
            'user' => $consulta,
            'remember_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at)
                ->toDateTimeString(),]
        ]);
    }

    public function logout(Request $request)
    {

            $request->user()->token()->revoke();
            return response()->json(['message' =>
                'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
