<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function index(){

        
        return view('index');

    }

    public function login(Request $request){

        //regras de autenticação
        $regras = [
            'email' => 'bail|string|email:rfc,dns',
            'password' => 'required',
        ];

        //Mensagens de resposta
        $feedback = [
            'email.string' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Insira um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ];

        $validacao = Validator::make($request->all(), $regras, $feedback);
        // se a validação falhar, é retornado mensagens no formato json
        if ($validacao->fails()) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => $validacao->messages(),
            ], 422);
        }

        $email = $request->get('email');
        $password = $request->get('password');

        $user = new User();

        $acesso = $user->where('email', '=', $email)->get()->first();

        if (isset($acesso->name)){

            if (Hash::check($password, $acesso->password)){
                $_SESSION['username'] = $acesso->name;
                return response()->json([
                    'mensagem' => 'Autenticado.',
                ], 202);
            } else {
                return response()->json([
                    'mensagem' => ['mensagem' => 'E-mail e/ou senha inválidos'],
                ], 500);
            }
        } else{
            return response()->json([
                'mensagem' => ['mensagem' => 'E-mail e/ou senha inválidos'],
            ], 404);
        }

    }
}
