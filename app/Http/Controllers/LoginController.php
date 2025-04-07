<?php

namespace App\Http\Controllers;

use App\Models\TokensApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class LoginController
{
    public function login(){

        return view('login');

    }

    public function autenticar(Request $request)
    {

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
                session_start();
                $_SESSION['username'] = $acesso->name;
                $_SESSION['id'] = $acesso->id;
                $_SESSION['autenticado'] = True;

                $url_login = env('URL_API').'login';

                $data = [
                    'email' => $email,
                    'password' => $password
                ];

                $resposta = Http::post($url_login, $data);

                if ($resposta->successful()){

                    $token = $resposta['access_token'];

                    $token_api = new TokensApi();

                    $resultado = $token_api->where('id_user', '=', $acesso->id)->get()->first();

                    if (isset($resultado)){

                        $resultado->token = Crypt::encrypt($token);
                        $resultado->save();
                        return response()->json([
                            'mensagem' => 'Autenticado.',
                        ], 202);

                    }

                    $token_api->token = $token;
                    $token_api->id_user = $acesso->id;
                    $token_api->save();

                    return response()->json([
                        'mensagem' => 'Autenticado.',
                    ], 202);
                } else {
                    session_destroy();
                    session_abort();
                    return response()->json([
                        'mensagem' => ['mensagem' => 'Erro ao se autenticar.']
                    ], 500);
                }

            } else {
                return response()->json([
                    'mensagem' => ['mensagem' => 'E-mail e/ou senha inválidos.'],
                ], 500);
            }
        } else{
            return response()->json([
                'mensagem' => ['mensagem' => 'E-mail e/ou senha inválidos.'],
            ], 404);
        }

    }
}
