<?php

namespace App\Http\Controllers;
use App\User;
use App\Empresa;
use Illuminate\Http\Request;

class PassportController extends Controller
{

    public function register(Request $request)
    {
        //ESTABLECER LA LÓGICA CON UNA VARIABLE EN $REQUEST DONDE PONGA SI ES EMPRESA O USUARIO. ESTARÁ OCULTA EN FORMULARIOS Y PREDEFINIDA SEGÚN ELIJA EL CLIENTE LA
        //OPCIÓN DE 'EMPRESA' O 'USUARIO'. --- IF{} ELSE{} ----
        if ($request->tipo == 'empresa') {
            //return 'empresa';
            //comprobación si el correo está asociado a una cuenta
            if (Empresa::where('email', $request->email)->exists()) {
                return response()->json(['message' => "El correo ya está asociado a una cuenta"], 400);
            }
            $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            $empresa = Empresa::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $token = $empresa->createToken('TutsForWeb')->accessToken;
            return response()->json(['message' => 'Usuario registrado con éxito', 'token' => $token], 200);
        } else {
            //comprobación si el correo está asociado a una cuenta
            if (User::where('email', $request->email)->exists()) {
                return response()->json(['message' => "El correo ya está asociado a una cuenta"], 400);
            }
            $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $token = $user->createToken('TutsForWeb')->accessToken;
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
}
