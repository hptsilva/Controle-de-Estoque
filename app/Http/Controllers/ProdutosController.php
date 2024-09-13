<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Produto;
use Ramsey\Uuid\Uuid;

class ProdutosController extends Controller
{
    public function mostrarProdutos(){

        $produtos = new Produto();
        $produtos = $produtos->orderByRaw('created_at')->paginate(10);
        return view('produtos.lista_produtos', ['produtos' => $produtos]);
        
    }

    public function adicionarProdutos(Request $request){

        $erro = $request->get('erro');
        $sucesso = $request->get('sucesso');
        $produtos = new Produto();
        $marcas = $produtos->select('marca')->get();
        if(isset($erro)){
            return view('produtos.adicionar_produtos', ['erro' => $erro, 'marcas' => $marcas]);
        }else if(isset($sucesso)){
            return view('produtos.adicionar_produtos', ['sucesso' => $sucesso, 'marcas' => $marcas]);
        }
        return view('produtos.adicionar_produtos', ['marcas' => $marcas]);

    }

    public function processarProdutos(Request $request){

        $regras = [
            'nome-produto' => 'required',
            'categoria-produto' => 'required',
            'unidade-produto' => 'required',
            'preco-custo-produto' => 'required|min:0',
            'preco-venda-produto' => 'required|min:0',
        ];

        $feedback = [
        ];

        $request->validate($regras, $feedback);
        $produtos = new Produto();

        try {
            $produtos->nome_produto = $request->get('nome-produto');
            $produtos->categoria = $request->get('categoria-produto');
            $produtos->marca = $request->get('marca-produto');
            $produtos->unidade = $request->get('unidade-produto');
            $produtos->preco_custo = $request->get('preco-custo-produto');
            $produtos->preco_venda = $request->get('preco-venda-produto');
            $produtos->estoque_atual = 0;
            $produtos->save();
            return redirect()->route('produtos.adicionar', ['sucesso' => 'Produto adicionado']);
        } catch(Exception $erro){
            return redirect()->route('produtos.adicionar', ['erro' => 'Ocorreu um erro durante a requisição']);
        }
    }
}
