<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Fornecedore;
use Ramsey\Uuid\Uuid;

class EntradaController extends Controller
{
    public function entrada(Request $request) {

        $produtos = new Produto();
        $fornecedor = new Fornecedore();

        if (!isset($_SESSION['produtos_entrada'])){
            $_SESSION['produtos_entrada'] = [];
        }

        $produtos = $produtos->orderBy('nome_produto')->get()->all();
        $fornecedores = $fornecedor->orderByRaw('nome_fornecedor')->get()->all();
        return view('entrada.entrada', ['produtos' => $produtos, 'fornecedores' => $fornecedores,'sucesso' => $request->get('sucesso'), 'erro' => $request->get('erro')]);
    }

    public function entradaProcessar(Request $request){

        $regras = [
            'nome_produto' => 'required',
            'quantidade' => 'required|numeric',
            'fornecedor' => 'required',
        ];
        $feedback = [];
        $request->validate($regras, $feedback);

        $id_produto = $request->get('nome_produto');
        $quantidade = $request->get('quantidade');
        $id_fornecedor = $request->get('fornecedor');

        $produtos = new Produto();
        $fornecedores = new Fornecedore();

        $produto = $produtos->where('id', '=', $id_produto)->get()->first();
        $fornecedor = $fornecedores->where('id', '=', $id_fornecedor)->get()->first();
        
        if(isset($produto) && isset($fornecedor)){
            
            $entradas = $_SESSION['produtos_entrada'];
            if ($entradas != []){
                if ($entradas[$id_produto]){
                    $entrada = $entradas[$id_produto];
                    $quantidade_atual = $entrada[0]; // Dado de quantidade do produto;
                    $entradas[$id_produto] = [$quantidade + $quantidade_atual, $fornecedor];
                }
                else {
                    $entradas[$id_produto] = [$quantidade , $fornecedor];
                }
            }else {
                $entradas[$id_produto] = [$quantidade , $fornecedor];
            }

            return response()->json([
                'mensagem' => "Produto adicionado",
            ]);
        }

        return redirect()->route('entrada', ['erro' => 'Não foi possível completar a solicitação.']);

    }

    public function entradaEnviar(Request $request) {

        if(isset($_SESSION['entrada_produto'][1])){
            $entrada = new Entrada();
            $uuid = Uuid::uuid4();

        }else {
            return redirect()->route('entrada', ['erro', 'Entrada vazia']);
        }
    }

    public function excluirEntrada(Request $request){
        
        return response()->json([
            'sucesso' => true,
        ]);

    }

    public function dadosProduto(Request $request){

        $id_produto = $request->get('id_produto');
        $produtos = new Produto();
        $produto = $produtos->where('id', '=', $id_produto)->get()->all();
        return response()->json(
            ['produto' => $produto]
        );
    }
}
