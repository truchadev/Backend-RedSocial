<?php

namespace App\Http\Controllers;

use App\User;
use App\Empresa;
use Illuminate\Http\Request;
use App\Notifications\SignupActivate;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
            $validator = $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'ciudad_id' => 'required|min:1',
            ]);
            if ($validator->fails()) {
                return json(['error' => 'Usuario registrado con éxito'], 400);
            }

            //comprobación si el correo está asociado a una cuenta
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['message' => "El correo ya está asociado a una cuenta"], 400);
            }

//            return response()->json([$request->name, $request->email, $request->ciudad_id], 200);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ciudad_id' => $request->ciudad_id,

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
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

//        $credentials = [
//            'email' => $request->email,
//            'password' => $request->password
//        ];

//        //SI ES CORRECTO EL lOGIN CAMBIAMOS VALORES DE TABLA
//        $credentials['active'] = 1;
//        $credentials['deleted_at'] = null;

//        if (Auth::guard('web')->attempt($credentials)) {
//            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
//            return response()->json(['token' => $token], 200);
//        } else {
//            return response()->json(['error' => 'UnAuthorised'], 401);
//        }

//        return $request->password . ' = ' . Hash::check('TutsForWeb', $request->password);
//        $user = User::where('password', $request->password);

//        $userPassword = DB::table('users')->where('email', $request->email)->first()->password;
//        $userPassword = DB::table('users')->where('email', $request->email)->first();
        $user = DB::table('users')->where('email', $request->email)->get();
//    return $user[0]->password;
        if (Hash::check($request->password, $user[0]->password)) {
            $resultToken = $user->createToken('TutsForWeb');
            return response()->json(['data' => $user, 'token' =>$resultToken], 200);
        }
//        if (($request->email === auth()->user()->email && Hash::check('TutsForWeb', $request->email) === auth()->user()->password)) {
//            return response()->json(['data' => auth()->user()], 200);
//        } else {
//            return response()->json(['error' => 'UnAuthorised'], 401);
//        }
//
//
//        if (comprueba()) {
//            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
////            return response()->json(['token' => $token], 200);
//            return response()->json(['data' => auth()->user()], 200);
//        } else {
//            return response()->json(['error' => 'UnAuthorised'], 401);
//        }
    }

    //LOGOUT
    public function logout()
    {
        Auth::logout();
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        Auth::user();
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
