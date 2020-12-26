<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class autenticadorController extends Controller
{
    public function registro(Request $request)
    {   
        //Mensagens erros
        $messages = [
            'required' => 'O :attribute está vazio',
            'string' => 'O :attribute deve ser um texto',
            'email' => 'O :attribute não é um email válido',
            'unique' => 'O :attribute já existe'
        ];

        //Validando nome e senha
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|',
            'genre' => 'required|string'
        ],$messages);

        //Criando usuario
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'genre' => $request->genre
        ]);
        
        if($user->save()){
            return response()->json(["mensagem" => "Usuário criado com sucesso"], 200);
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
