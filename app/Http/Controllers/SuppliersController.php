<?php

namespace App\Http\Controllers;
use App\Models\Fornecedore;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SuppliersController
{
    public function mostrarFornecedor(){

        $fornecedores = Fornecedore::orderByRaw('created_at')->paginate(10);
        return view('fornecedores.suppliers', ['fornecedores' => $fornecedores]);
        
    }

    public function pesquisarFornecedor(Request $request){

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

                $fornecedores = Fornecedore::where('nome_fornecedor', 'LIKE', '%' . strtolower($request->get('pesquisar-input-text')) . '%')
                    ->orWhere('nome_fornecedor', 'LIKE', '%' . strtoupper($request->get('pesquisar-input-text')) . '%')
                    ->get();

                if (isset($fornecedores)){

                    return response()->json([
                        'fornecedores' => $fornecedores,
                    ],200);

                } else {

                    return response()->json([
                        'mensagem' => "Fornecedor não encontrado",
                    ], 404);

                }

            case  'op-id':

                $fornecedor = Fornecedore::where('id', '=', $request->get('pesquisar-input-text'))->get();
                if (isset($fornecedor)){

                    return response()->json([
                        'fornecedores' => $fornecedor,
                    ],200);
                    
                } else {

                    return response()->json([
                        'mensagem' => "Fornecedor não encontrado",
                    ], 404);

                }

            default:
                return response()->json([
                    'mensagem' => 'Escolha uma opção de pesquisa válida.'
                ], 500);

        }

    }


    public function adicionarFornecedor(Request $request){

        $erro = $request->get('erro');
        $sucesso = $request->get('sucesso');
        if(isset($erro)){
            return view('fornecedores.add_suppliers', ['erro' => $erro,]);
        }else if(isset($sucesso)){
            return view('fornecedores.add_suppliers', ['sucesso' => $sucesso,]);
        }
        return view('fornecedores.add_suppliers');

    }

    public function processoAdicionarFornecedores(Request $request){

        $regras = [
            'nome-fornecedor' => 'required',
            'cnpj' => 'required',
            'endereco' => 'required',
            'telefone' => 'required',
            'email' => 'required|email',
            'contato' => 'required',
        ];

        $feedback = [
            'nome-fornecedor.required' => "Preencha o campo Nome do Fornecedor.",
            'cnpj.required' => 'Preencha o campo CNPJ.',
            'endreco.required' => 'Preencha o endereço.',
            'telefone.required' => 'Preencha o telefone.',
            'email.required' => 'Preencha o e-mail.',
            'contato.required' => 'Preencha o contato.'
        ];

        $validator = Validator::make($request->all(), $regras, $feedback);

        if ($validator->fails()) {
            return response()->json([
                'mensagem' => $validator->messages(),
            ], 400);
        }

        $fornecedor = new Fornecedore();

        try {

            $fornecedor->nome_fornecedor = $request->get('nome-fornecedor');
            $fornecedor->cnpj = $request->get('cnpj');
            $fornecedor->endereco = $request->get('endereco');
            $fornecedor->telefone = $request->get('telefone');
            $fornecedor->email = $request->get('email');
            $fornecedor->contato = $request->get('contato');
            $fornecedor->estoque_atual = 0;
            $fornecedor->save();
            return response()->json([
                'mensagem' => 'Fornecedor adicionado.'
            ], 200);

        } catch(Exception){

            return response()->json([
                'mensagem' => 'Erro ao processar a requisição.'
            ], 400);
        }
    }

    public function deletarFornecedor(Request $request){

        $fornecedor = Fornecedore::where('id', '=', $request->route('id'))->get()->first();
        if(!isset($fornecedor)){
            return response()->json([
                'mensagem' => 'Produto não encontrado'
            ], 404);
        }
        $id_fornecedor = $fornecedor->id;
        $fornecedor->delete();
        return response()->json([
            'mensagem' => 'Produto deletado com sucesso',
            'id' => $id_fornecedor
        ], 200);

    }

    public function editarFornecedor(Request $request){

        $marcas = Fornecedore::select('marca')->get();
        $fornecedor = Fornecedore::where('id', '=', $request->route('id'))->get()->first();
        if (isset ($fornecedor)){
            return view('fornecedores.edit_suppliers', ['marcas' => $marcas, 'produto' => $fornecedor]);
        }
        else {
            return redirect()->route('fornecedores');
        }

    }

    public function processoEditarFornecedor(Request $request){

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
        $produtos = new Fornecedore();

        $produto = Fornecedore::where('id', '=', $request->get('id'))->get()->first();
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
