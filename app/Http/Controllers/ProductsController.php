<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductsController
{
    public function mostrarProdutos(){

        $url = env('URL_API').'produtos';
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return view('produtos.products', ['produtos' => $response->json()]);
            } else {
                return view('produtos.products', ['produtos' => []]);
            }
        } catch (Exception $e) {
            return view('produtos.products', ['produtos' => []]);
        }
        
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

                $url = env('URL_API')."produtos/".$request->get('pesquisar-input-text');
                
                try {

                    $response = Http::get($url);

                    if ($response->successful()) {
                        $resposta = $response->json();
                        return response()->json([
                            'produtos' => [$resposta['produto']],
                        ],200);
                    } else {
                        return response()->json([
                            'mensagem' => "Produto não encontrado",
                        ], 404);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'mensagem' => "Erro ao processar a requisição.",
                    ], 500);
                }

            default:
                return response()->json([
                    'mensagem' => 'Escolha uma opção de pesquisa válida.'
                ], 500);

        }

    }


    public function adicionarProdutos(Request $request){

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

    public function processoAdicionarProdutos(Request $request){

        $regras = [
            'nome-produto' => 'required',
            'categoria-produto' => 'required',
            'marca-produto' => 'required',
            'medida-produto' => 'required',
            'preco-custo-produto' => 'required|min:0',
            'preco-venda-produto' => 'required|min:0',
        ];

        $feedback = [
            'nome-produto.required' => 'Preencha o campo Nome do Produto.',
            'categoria-produto.required' => 'Escolha a categoria do Produto.',
            'marca-produto.required' => 'Preencha o campo Marca do Produto.',
            'medida-produto.required' => 'Escolha a Unidade de Medida.',
            'preco-custo-produto.required' => 'Preencha o campo Preço de Custo.',
            'preco-venda-produto.required' => 'Preencha o campo Preço de Venda.',
            'preco-custo-produto.min' => 'O Preço de Custo deve ser um valor positivo.',
            'preco-venda-produto.min' => 'O Preço de Venda deve ser um valor positivo.',
        ];

        $validator = Validator::make($request->all(), $regras, $feedback);

        if ($validator->fails()) {
            return response()->json([
                'mensagem' => $validator->messages(),
            ], 400);
        }

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
            return response()->json([
                'mensagem' => 'Produto adicionado.'
            ], 200);

        } catch(Exception){

            return response()->json([
                'mensagem' => 'Erro ao processar a requisição.'
            ], 400);
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

    public function editarProduto(Request $request){

        $marcas = Produto::select('marca')->get();
        $produto = Produto::where('id', '=', $request->route('id'))->get()->first();
        if (isset ($produto)){
            return view('produtos.edit_products', ['marcas' => $marcas, 'produto' => $produto]);
        }
        else {
            return redirect()->route('produtos');
        }

    }

    public function processoEditarProduto(Request $request){

        $regras = [
            'nome-produto' => 'required',
            'categoria-produto' => 'required',
            'marca-produto' => 'required',
            'medida-produto' => 'required',
            'preco-custo-produto' => 'required|min:0',
            'preco-venda-produto' => 'required|min:0',
        ];

        $feedback = [
            'nome-produto.required' => 'Preencha o campo Nome do Produto.',
            'categoria-produto.required' => 'Escolha a categoria do Produto.',
            'marca-produto.required' => 'Preencha o campo Marca do Produto.',
            'medida-produto.required' => 'Escolha a Unidade de Medida.',
            'preco-custo-produto.required' => 'Preencha o campo Preço de Custo.',
            'preco-venda-produto.required' => 'Preencha o campo Preço de Venda.',
            'preco-custo-produto.min' => 'O Preço de Custo deve ser um valor positivo.',
            'preco-venda-produto.min' => 'O Preço de Venda deve ser um valor positivo.',
        ];

        $validator = Validator::make($request->all(), $regras, $feedback);

        if ($validator->fails()) {
            return response()->json([
                'mensagem' => $validator->messages(),
            ], 400);
        }
        $produtos = new Produto();

        $produto = Produto::where('id', '=', $request->get('id'))->get()->first();
        if (isset($produto)){

            try {
                $produto->nome_produto = $request->get('nome-produto');
                $produto->categoria = $request->get('categoria-produto');
                $produto->marca = $request->get('marca-produto');
                $produto->medida = $request->get('medida-produto');
                $produto->preco_custo = $request->get('preco-custo-produto');
                $produto->preco_venda = $request->get('preco-venda-produto');
                $produto->estoque_atual = 0;
                $produto->save();
                return response()->json([
                    'mensagem' => 'Produto editado.'
                ], 200);
            } catch(Exception){
                return response()->json([
                    'mensagem' => ['mensagem' => 'Erro ao processar requisição.']
                ], 400);
            }

        } else {
            return response()->json([
                'mensagem' =>  [
                    'mensagem' => 'O produto não existe.',
                    'id' => $request->get('id')
                ]
            ], 404);
        }

    }

}
