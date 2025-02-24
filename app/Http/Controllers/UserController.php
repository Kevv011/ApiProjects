<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    //Metodo para registrar un usuario
    public function register(Request $request)
    {
        try {
            //Se genera la validacion de los campos previamente con validate()
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]);

            //Creacion de un nuevo usuario por medio de create() simulando un insert
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            //Respuesta de exito
            return response()->json([
                'message' => 'New user added Successfully',
                'data' => $user
            ], 201);

        //Try-catch para el manejo de errores
        } catch (Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ], 400);
        }
    }
}
