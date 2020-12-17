<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class autenticadorController extends Controller
{
    public function registro(Request $request)
    {
        //Validando nome e senha
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|',
            'genre' => 'required|string'
        ]);
        //Criando usuario
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'genre' => $request->genre
        ]);

        if ($user->save()) {
            return response()->json('Usuário criado com sucesso', 201);
        } else {
            return response()->json('Erro tente ao criar o usuário', 400);
        }
    }

    public function login(Request $request)
    {
        //Validando nome e senha
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credenciais)) {
            return response()->json('Email ou senha incorretos', 200);
        }
        $user = $request->user();
        $token = $user->createToken('Token acesso')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json("Usuário deslogado", 200);
    }
}
