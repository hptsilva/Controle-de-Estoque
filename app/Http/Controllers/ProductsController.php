<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductsController
{
    public function mostrarProdutos(){

        $produtos = new Produto();
        $produtos = $produtos->orderByRaw('created_at')->paginate(10);
        return view('produtos.products', ['produtos' => $produtos]);
        
    }

    public function pesquisarProduto(Request $request){

        $regras = [
            'pesquisar-input-text' => 'required',
            'op' => 'required',
        ];

        $feedback = [
            'pesquisar-input-text.required' => 'Preencha o campo Pesquisar',
            'op' => 'Preencha o campo Opção de Pesquisa'
        ];

        $validator = Validator::make($request->all(), $regras, $feedback);

        if ($validator->fails()) {
            return response()->json([
                'mensagem' => $validator->messages(),
            ], 400);
        }

        switch($request->get('op')){
            case 'op-nome':

                $produtos = Produto::where('nome_produto', 'LIKE', '%' . strtolower($request->get('pesquisar-input-text')) . '%')
                    ->orWhere('nome_produto', 'LIKE', '%' . strtoupper($request->get('pesquisar-input-text')) . '%')
                    ->get();

                if (isset($produtos)){

                    return response()->json([
                        'produtos' => $produtos,
                    ],200);

                } else {

                    return response()->json([
                        'mensagem' => "Produto não encontrado",
                    ], 404);

                }

            case  'op-id':

                $produto = Produto::where('id', '=', $request->get('pesquisar-input-text'))->get();
                if (isset($produto)){

                    return response()->json([
                        'produtos' => $produto,
                    ],200);
                    
                } else {

                    return response()->json([
                        'mensagem' => "Produto não encontrado",
                    ], 404);

                }

            default:
                return response()->json([
                    'mensagem' => 'Escolha uma opção de pesquisa válida.'
                ], 500);

        }

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
            'medida-produto' => 'required',
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
            $produtos->medida = $request->get('medida-produto');
            $produtos->preco_custo = $request->get('preco-custo-produto');
            $produtos->preco_venda = $request->get('preco-venda-produto');
            $produtos->estoque_atual = 0;
            $produtos->save();
            return redirect()->route('produtos.adicionar', ['sucesso' => 'Produto adicionado.']);
        } catch(Exception $erro){
            return redirect()->route('produtos.adicionar', ['erro' => 'Erro ao processar requisição.']);
        }
    }

    public function deletarProduto(Request $request){

        $produto = Produto::where('id', '=', $request->route('id'))->get()->first();
        if(!isset($produto)){
            return response()->json([
                'mensagem' => 'Produto não encontrado'
            ], 404);
        }
        $id_produto = $produto->id;
        $produto->delete();
        return response()->json([
            'mensagem' => 'Produto deletado com sucesso',
            'id' => $id_produto
        ], 200);

    }

}
