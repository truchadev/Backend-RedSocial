<?php

namespace App\Http\Controllers;

use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Hash;
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
            return response()->json([
                "message" => "Usuario registrado correctamente",
                "state" => 200
            ], 200);
        } else {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:empresas',
                'password' => 'required|min:6',
                'ciudad_id' => 'min:1',
                // 'name_responsable'=>'max:255|alpha'
            ]);
            $empresas = new Empresa([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id,
                'name_responsable' => $request->name_responsable
            ]);
            $empresas->save();
            //notificacion por email de datos
//            $empresas->notify(new SignupActivate($empresas));
            return response()->json([
                "message" => "Empresa registrada",
                "state" => 200
            ], 200);
        }
    }

    public function login(Request $request)
    {
        try {
            if ($request->tipo === 'usuario') {

                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                    'remember_me' => 'boolean',
                ]);

                //LLamada a BBDD y traemos datos cliente
                $clientes = DB::table('users')->where('email', $request->email)->first();

                if (!Hash::check($request->password, $clientes->password) || $clientes->email != $request->email) {
                    return response()->json([
                        "error" => "Error en Login. Revise sus datos.",
                        "status" => 400,
                    ]);
                }

            } else {

                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                    'remember_me' => 'boolean',
                ]);

                //LLamada a BBDD y traemos datos empresa
                $clientes = DB::table('empresas')->where('email', $request->email)->first();

                if (!Hash::check($request->password, $clientes->password) || $clientes->email != $request->email) {
                    return response()->json([
                        "error" => "Error en Login. Revise sus datos.",
                        "status" => 400,
                    ]);
                }
            }

            //Comprobamos si array estrá vacío. Si lo está, no ha encontrado datos en BBDD que coincidan.
            //if (sizeof($consulta) == "") {
            if (!$clientes) {
                return response()->json([
                    "error" => "Error en Login. Revise sus datos.",
                    "status" => 400
                ]);
            }

            if ($request->tipo === 'usuario') {
                $cliente = User::find($clientes->id);
            } else {
                $cliente = Empresa::find($clientes->id);
            }

            if (!$cliente) {
                return response()->json([
                    "error" => 'Error. Compruebe acceso como "usuario" o como "empresa".',
                    "status" => 400,
                ]);
            }


            $tokenResult = $cliente->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(4);
            }

            return response()->json([
                'state' => 200,
                'obj' => $clientes,
                'remember_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at)
                    ->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Error en Login. Revise sus datos.",
                "status" => 400,
            ]);
        }
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
