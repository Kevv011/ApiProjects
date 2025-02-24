<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    //Metodo para el LOGIN
    public function login(Request $request)
    {
        //Validacion de campos "email" y "password"
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Si los datos evaluados por "attempt()" desde la DB son incorrectos, se devuelve status 401 (Acceso invalido)
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Accesos inválidos'], 401);
        }

        //Se obtiene al usuario que ha sido autenticado
        $user = Auth::user();      
        
        //Se genera el token de acceso para el usuario autenticado, donde el token tendra todos los permisos [*]
        $token = $user->createToken('auth_token', ['*']);

        //Respuesta de exito que devuelve el access token
        return response()->json([
            'access_token' => $token->plainTextToken
        ], 200);
    }

    //Metodo para el Cierre de sesion de un usuario autenticado
    public function logout(Request $request)
    {

        try {
            $request->user()->tokens()->delete();   //Se eliminan todos los tokens del usuario autenticado

            return response()->json([               //Respuesta de exito ante esta eliminacion de tokens
                'message' => 'Session closed'
            ]);
        } catch (Exception $error) {        
            return response()->json([               //Respuesta de error obtenida en caso de alguna falla
                'error' => $error->getMessage()
            ], 400);
        }
    }

    //Metodo que verifica si el usuario logueado tiene un token valido
    public function validateToken()
    {
        //Guard() de sanctum para obtener al usuario y validar el token
        $user = Auth::guard('sanctum')->user();

        //Respuesta de exito si el token es verificado, devolviendo al usuario
        return response()->json(['message' => 'El token es válido', 'detail' =>  $user]);
    }
}
