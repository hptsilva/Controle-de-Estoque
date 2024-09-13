<?php

namespace App\Http\Controllers;

use App\Models\Fornecedore;
use Exception;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;


class FornecedoresController extends Controller
{
    public function mostrarFornecedores(Request $request){

        $fornecedores = new Fornecedore();
        $fornecedores = $fornecedores->orderByRaw('created_at')->paginate(10);
        return view('fornecedores.lista_fornecedores', ['fornecedores' => $fornecedores]);

    }

    public function adicionarFornecedores(Request $request){

        $erro = $request->get('erro');
        $sucesso = $request->get('sucesso');
        if(isset($erro)){
            return view('fornecedores.adicionar_fornecedores', ['erro' => $erro]);
        }else if(isset($sucesso)){
            return view('fornecedores.adicionar_fornecedores', ['sucesso' => $sucesso]);
        }
        return view('fornecedores.adicionar_fornecedores');
    }

    public function processarFornecedores(Request $request){

        $regras = [
            'nome-fornecedor' => 'required',
            'cnpj-fornecedor' => 'required|cnpj',
            'endereco-fornecedor' => 'required',
            'telefone-fornecedor' => 'required|telefone_com_ddd',
            'email-fornecedor' => 'required|email',
            'contato-fornecedor' => 'required',
        ];

        $feedback = [
            'nome-fornecedor.required' => 'O campo nome do fornecedor é necessário.',
            'cnpj-forneceodor.required' => 'O campo CNPJ é necessário.',
            'cnpj-fornecedor.cnpj' => 'O CNPJ não é válido.',
            'endereco-fornecedor.required' =>  'O campo endereço do fornecedor é necessário.',
            'telefone-fornecedor.required' => 'O campo telefone do fornecedor é necessário.',
            'telefone-fornecedor.telefone_com_ddd' => 'O telefone não é válido.',
            'email-fornecedor.required' => 'O campo email do fornecedor é necessário.',
            'email-fornecedor.email' => 'O email do fornecedor não é válido.',
            'contato-fornecedor.required' => 'O contato do fornecedor é necessário.',
        ];

        $request->validate($regras, $feedback);
        $fornecedor = new Fornecedore();

        try {
            $fornecedor->nome_fornecedor = $request->get('nome-fornecedor');
            $fornecedor->cnpj = $request->get('cnpj-fornecedor');
            $fornecedor->endereco = $request->get('endereco-fornecedor');
            $fornecedor->telefone = $request->get('telefone-fornecedor');
            $fornecedor->email = $request->get('email-fornecedor');
            $fornecedor->contato = $request->get('contato-fornecedor');
            $fornecedor->save();
            return redirect()->route('fornecedores.adicionar', ['sucesso' => 'Fornecedor adicionado']);
        } catch(Exception $erro){
            echo $erro;
            return redirect()->route('fornecedores.adicionar', ['erro' => $erro]);
        }

    }

}
