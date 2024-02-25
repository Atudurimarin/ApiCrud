<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use \stdClass;


class AuthController extends Controller
{
   
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function register(Request $request){
        
        $validate = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email',            // VALIDAR DATOS
            'password' => 'required|min:8|max:12'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());   // SI FALLA VALIDACIÓN LANZAR ERROR
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,                     // SI LA VALIDACIÓN ES CORRECTA CREAR USUARIO
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken; // CREAR TOKEN

        return response()->json([
            'user' => $user,                // DEVOLVER RESPUESTA CON TOKEN
            'Access_token' => $token
        ]);
    }

    public function login (Request $request){

        if(! Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Unauthorized'   // SI FALLA LA AUTENTICACIÓN DEVOLVER MENSAJE DE ERROR
            ], 401);
        }

        $user = User::whereEmail($request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Hola '.$user.' Bienvenido de nuevo!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout (){
        
        //auth()->user()->tokens()->delete();   <-- POR QUÉ SIGUE DANDO ERROR!!?!?!?!?!!?!?

        return response()->json([
           
            'message' => 'Se ha hecho el logout satisfactoriamente!'

        ]);
    }
        
}
