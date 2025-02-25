<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class ProductsController
{
    public function mostrarProdutos(){

        $produtos = new Produto();
        $produtos = $produtos->orderByRaw('created_at')->paginate(10);
        return view('produtos.products', ['produtos' => $produtos]);
        
    }

    public function adicionarProduto(Request $request){

        $erro = $request->get('erro');
        $sucesso = $request->get('sucesso');
        $produtos = new Produto();
        $marcas = $produtos->select('marca')->get();
        if(isset($erro)){
            return view('produtos.add_products', ['erro' => $erro, 'marcas' => $marcas]);
        }else if(isset($sucesso)){
            return view('produtos.add_products', ['sucesso' => $sucesso, 'marcas' => $marcas]);
        }
        return view('produtos.add_products', ['marcas' => $marcas]);

    }

    public function processarProdutos(Request $request){

        $regras = [
            'nome-produto' => 'required',
            'categoria-produto' => 'required',
            'marca-produto' => 'required',
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
            return redirect()->route('produtos.adicionar', ['erro' => $erro->getMessage()]);
        }
    }

    public function deletarProduto(Request $request){

        $produtos = new Produto();
        $produto = $produtos->where('id', '=', $request->route('id'))->get()->first();
        if(!isset($produto)){
            return response()->json(['mensagem' => 'Produto não encontrado'], 404);
        }
        $produto->delete();
        return response()->json(['mensagem' => 'Produto deletado com sucesso'], 200);

    }

}
