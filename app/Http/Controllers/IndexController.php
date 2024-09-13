<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index(Request $request){

        session_start();
        $erro = $request->get('erro');
        if(isset($erro)){
            return view('index', ['erro' => $erro] );
        }
        return view('index');
    }

    public function autenticacao(Request $request){

        $regras = [
            'usuario' => 'required',
            'senha' => 'required'
        ];

        $feedback = [
            'usuario.required' => 'O campo usuário é obrigatório',
            'senha.required' => 'O campo senha é obrigatório',
        ];

        $request->validate($regras, $feedback);

        $user = new User();
        $usuario = $request->get('usuario');
        $senha = $request->get('senha');
        $conta = $user->where('email', '=', $usuario)->get()->first();

        if(isset($conta)){

            if (Hash::check($senha,$conta->password)) 
            {
                session_start();
                $_SESSION['id'] = session_id();
                $_SESSION['nome'] = $conta->name;
                return redirect()->route('index');
            } else
            {
                return redirect()->route('index', ['erro' => 'Usuário não encontrado']);
            }
        }
        else {
            return redirect()->route('index', ['erro' => 'Usuário não encontrado']);
        }
    }

    public function sair(){
        session_start();
        session_destroy();
        session_abort();
        return redirect()->route('index');
    }
}
