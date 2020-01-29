<?php

namespace App\Http\Controllers;

use App\User;
use App\Empresa;
use Illuminate\Http\Request;
use App\Notifications\SignupActivate;

class PassportController extends Controller
{

    public function register(Request $request)
    {
        //ESTABLECER LA LÓGICA CON UNA VARIABLE EN $REQUEST DONDE PONGA SI ES EMPRESA O USUARIO. ESTARÁ OCULTA EN FORMULARIOS Y PREDEFINIDA SEGÚN ELIJA EL CLIENTE LA
        //OPCIÓN DE 'EMPRESA' O 'USUARIO'. --- IF{} ELSE{} ----

        if ($request->tipo == 'empresa') {

            //validamos campos
            $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:empresas',
                'password' => 'required|min:6',
                'ciudad_id' => 'min:1',
            ]);

            //comprobación si el correo está asociado a una cuenta
            if (Empresa::where('email', $request->email)->exists()) {
                return response()->json(['message' => "El correo ya está asociado a una cuenta"], 400);
            }

            $empresa = Empresa::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id
            ]);
            $token = $empresa->createToken('TutsForWeb')->accessToken;

            //notificacion por email para validar
            $empresa->notify(new SignupActivate($empresa));

            return response()->json(['message' => 'Usuario registrado con éxito', 'token' => $token], 200);

        } else {

            //Validamos los campos
             $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'ciudad_id' => 'required|min:1',
            ]);

            //comprobación si el correo está asociado a una cuenta
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['message' => "El correo ya está asociado a una cuenta"], 400);
            }

//            return response()->json([$request->name, $request->email, $request->ciudad_id], 200);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id
            ]);
            $token = $user->createToken('TutsForWeb')->accessToken;

            //notificacion por email para validar
            $user->notify(new SignupActivate($user));

            return response()->json(['message' => 'Usuario registrado con éxito', 'token' => $token], 200);

        }
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //SI ES CORRECTO EL lOGIN CAMBIAMOS VALORES DE TABLA
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }


    //FUNCIÓN PARA ACTIVAR LA CUENTA DEL USUARIO
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'El token de activación es inválido'], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
}
