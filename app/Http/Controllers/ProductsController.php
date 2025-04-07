<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use App\Models\TokensApi;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ProductsController
{

    private function getCategoriaNome($id, $categorias)
    {
        foreach ($categorias as $categoria) {
            if ($categoria['id'] == $id) {
                return $categoria['nome'];
            }
        }
        return 'Desconhecido';
    }
    
    private function getMarcas($id, $marcas)
    {
        foreach ($marcas as $marca) {
            if ($marca['id'] == $id) {
                return $marca['nome'];
            }
        }
        return 'Desconhecido';
    }

    private function getUnidadeNome($id, $unidades) 
    {
        foreach ($unidades as $unidade) {
            if ($unidade['id'] == $id) {
                return $unidade['nome'];
            }
        }
        return 'Desconhecido';
    }

    public function mostrarProdutos()
    {

        $url_produtos = env('URL_API').'produtos';
        $url_unidades = env('URL_API').'unidades';
        $url_categorias = env('URL_API').'categorias';
        $url_marcas = env('URL_API').'marcas';

        $token = new TokensApi();
        $token = $token->where('id_user', '=', $_SESSION['id'])->get()->first();
        $token = Crypt::decrypt($token->token);

        try {

            $resposta_produtos = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_produtos);
            
            $resposta_unidades = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_unidades);
            
            $resposta_categorias = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_categorias);
            
            $respostas_marcas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_marcas);

            if ($resposta_produtos->successful() && $resposta_unidades->successful() && $resposta_categorias->successful()) {

                $unidades = $resposta_unidades->json();
                $categorias = $resposta_categorias->json();
                $produtos = $resposta_produtos->json();
                $marcas = $respostas_marcas->json();

                // Mapear IDs para valores
                foreach ($produtos as &$produto) {
                    $produto['categoria'] = $this->getCategoriaNome($produto['categoria'], $categorias);
                    $produto['unidade_medida'] = $this->getUnidadeNome($produto['unidade_medida'], $unidades);
                    $produto['marca'] = $this->getMarcas($produto['marca'], $marcas);
                }

                return view('produtos.products', ['produtos' => $produtos]);
            } else {
                session_abort();
                session_destroy();
                return redirect()->route('index');
            }
        } catch (Exception $e) {
            return view('produtos.products', ['produtos' => []]);
        }

    }

    public function pesquisarProduto(Request $request)
    {

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


    public function adicionarProdutos(Request $request)
    {

        $erro = $request->get('erro');
        $sucesso = $request->get('sucesso');
        $url_marcas = env('URL_API').'marcas';
        $url_categorias = env('URL_API').'categorias';
        $url_unidades = env('URL_API').'unidades';
        $token = new TokensApi();
        $token = $token->where('id_user', '=', $_SESSION['id'])->get()->first();
        $token = Crypt::decrypt($token->token);

        try{
            $resposta_unidades = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_unidades);
            
            $resposta_categorias = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_categorias);
            
            $resposta_marcas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_marcas);

            $unidades = $resposta_unidades->json();
            $categorias = $resposta_categorias->json();
            $marcas = $resposta_marcas->json();

            if ($resposta_marcas->successful() && $resposta_unidades->successful() && $resposta_categorias->successful()) {

                if(isset($erro)){
                    return view('produtos.add_products', ['erro' => $erro, 'marcas' => $marcas, 'unidades' => $unidades, 'categorias' => $categorias]);
                }else if(isset($sucesso)){
                    return view('produtos.add_products', ['sucesso' => $sucesso, 'marcas' => $marcas, 'unidades' => $unidades, 'categorias' => $categorias]);
                }

                return view('produtos.add_products', ['sucesso' => $sucesso, 'marcas' => $marcas, 'unidades' => $unidades, 'categorias' => $categorias]);

            } else {
                session_abort();
                session_destroy();
                return redirect()->route('index');
            }
        } catch (Exception){
            return response()->json([
                'mensagem' => ['mensagem' => 'Erro ao processar requisição.']
            ], 500);
        }

    }

    public function processoAdicionarProdutos(Request $request)
    {

        $regras = [
            'nome-produto' => 'required',
            'descricao-produto' => 'nullable|max:255',
            'categoria-produto' => 'required',
            'marca-produto' => 'required|max:255',
            'medida-produto' => 'required',
            'preco-custo-produto' => 'required|min:0',
            'preco-venda-produto' => 'required|min:0',
        ];

        $feedback = [
            'nome-produto.required' => 'Preencha o campo Nome do Produto.',
            'descricao-produto.max:255' => 'O número máximo de caracteres na descrição são 256.',
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

        $url_produtos = env('URL_API').'produtos';

        try {

            $data = [
                'nome' => $request->get('nome-produto'),
                'marca' => $request->get('marca-produto'),
                'descricao' => $request->get('descricao-produto'),
                'categoria' => $request->get('categoria-produto'),
                'unidade_medida' => $request->get('medida-produto'),
                'preco_custo' => $request->get('preco-custo-produto'),
                'preco_venda' => $request->get('preco-venda-produto'),
                'quantidade' => 0
            ];

            $token = new TokensApi();
            $token = $token->where('id_user', '=', $_SESSION['id'])->get()->first();
            $token = Crypt::decrypt($token->token);

            $resposta = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post($url_produtos, $data);

            return response()->json([
                'mensagem' => isset($resposta['mensagem']) ? $resposta['mensagem'] : "Produto adicionado"
            ], isset($resposta['status_code']) ? $resposta['status_code'] : 201);

        } catch(Exception $e){

            return response()->json([
                'mensagem' => ["mensagem" => $e->getMessage() ],
            ], 400);
        }
    }

    public function deletarProduto(Request $request)
    {

        $url_produtos = env('URL_API').'produtos/';

        try {

            $token = new TokensApi();
            $token = $token->where('id_user', '=', $_SESSION['id'])->get()->first();
            $token = Crypt::decrypt($token->token);

            $resposta = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete($url_produtos.$request->route('id'));

            return response()->json([
                'mensagem' => $resposta['mensagem'],
            ], $resposta['status_code']);

        } catch(Exception){
            return response()->json([
                'mensagem' => 'Erro ao processar a requisição.',
            ], 500);
        }

    }

    public function editarProduto(Request $request)
    {

        $produto = Produto::where('id', '=', $request->route('id'))->get()->first();
        if (isset ($produto)){
            return view('produtos.edit_products', ['marcas' => [], 'produto' => $produto]);
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
