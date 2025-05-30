<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('estilos/products_style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Produtos</title>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#produtos").css("color", "#FFF1D0");
    });
</script>
<body>
@if(isset($_SESSION['autenticado']))
<main>
    <div class="container mt-2">
        <div class="row">
            @include('componentes.options')
            <div class="col">
                <div id="conteudo">
                    <h1>PRODUTOS</h1>
                    <div class="opcoes-produtos">
                        <form id="form-pesquisar">
                        @csrf
                            <div class='formulario'>
                                <label for="pesquisar-produto"></label>
                                <input class="form-control input-text" type="text" id="pesquisar-produto" name="pesquisar-input-text" placeholder="Pesquisar produto" required>
                                <button class="btn btn-success" type="submit"><img src="{{asset('icons/btn-lupa.png')}}"></button>
                            </div>
                            <div class="op-pesquisa">
                                <div class="form-check">
                                    <input class="form-check-input" name="op" type="radio" value="op-nome" id="op-nome" required>
                                    <label class="form-check-label" for="op-nome">Nome<label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="op" type="radio" value="op-id" id="op-id">
                                    <label class="form-check-label" for="op-id">ID<label>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function()
                            {
                                $('#form-pesquisar').on('submit', function(event)
                                {
                                    event.preventDefault();
        
                                    jQuery.ajax(
                                        {
                                        url: "{{route('produtos.pesquisar')}}",
                                        data: jQuery('#form-pesquisar').serialize(),
                                        type: "GET",
                                        success:function(result)
                                        {
                                            produtos = result.produtos;
                                            console.log(produtos);
                                            var tabela = $('#tabelaProdutos');
                                            tabela.empty();
                                            var cabecalho = '<thead><tr><th style="text-align: left" scope="col">ID</th><th scope="col">Nome</th><th scope="col">Marca</th><th scope="col">Descrição</th><th scope="col">Unidade</th><th scope="col">Categoria</th><th scope="col">Quantidade</th><th scope="col">Quantidade</th><th scope="col">Preço de Custo</th><th scope="col">Preço de Venda</th></tr></thead>'
                                            tabela.append(cabecalho);
                                            tabela.append('<tbody>');
                                            produtos.forEach(produto => {
                                                corpo = '';
                                                corpo += '<tr id=\'' + produto.id + '\'>';
                                                corpo += '<th scope="row">' + produto.id +'</th>';
                                                console.log("ID do Produto:", produto.id);
                                                corpo += '<td>' + produto.nome +'</td>';
                                                console.log("Nome do Produto:", produto['nome']);
                                                corpo += '<td>' + produto.marca + '</td>';
                                                console.log("Marca:", produto.marca);
                                                corpo += '<td>' + produto.descricao + '</td>';
                                                console.log("Descrição:", produto.descricao);
                                                corpo += '<td>' + produto.unidade_medida + '</td>';
                                                console.log("Medida:", produto.unidade_medida);
                                                corpo += '<td>' + produto.categoria + '</td>';
                                                console.log("Categoria:", produto.categoria);
                                                corpo += '<td>' + produto.quantidade + '</td>';
                                                console.log("Quantidade:", produto.quantidade);
                                                corpo += '<td>' + produto.preco_custo + '</td>';
                                                console.log("Preço de Custo:", produto.preco_custo);
                                                corpo += '<td>' + produto.preco_venda + '</td>';
                                                console.log("Preço de Venda:", produto.preco_venda);
                                                console.log("-----------------------------");
                                                corpo += '<td>';
                                                corpo += '<form class="acoes-produto form-excluir">';
                                                corpo += '@csrf';
                                                corpo += '<input type="hidden" name="id-produto" value="' + produto.id + '">';
                                                corpo += '<button type="submit"><img src="{{asset('icons/btn-delete.png')}}"></button>';
                                                corpo += '</form>';
                                                corpo += '<a href="' + '{{ url("produtos/editar") }}/' + produto.id + '"><img src="{{ asset("icons/btn-edit.png") }}"></a>';
                                                corpo += '</td>';
                                                corpo += '</tr>';
                                                tabela.append(corpo);
                                            });
                                            tabela.append('</tbody>');
                                            $('#submit').prop('disabled', false);
                                        },
                                        error:function(xhr, status, error)
                                        {
                                            alert(xhr.responseJSON.mensagem)
                                            $('#submit').prop('disabled', false);
                                        }
        
                                    })
                                })
                            })
                        </script>
                        <div style="margin-top: 20px; margin-bottom: 20px;">
                            <a href="{{route('produtos.adicionar')}}"><img src="{{asset('icons/btn-add.png')}}"></a>
                            <a href="{{route('produtos')}}"><img src="{{asset('icons/btn-refresh.png')}}" width="50"></a>
                        </div>
                    </div>
                    <table class="table table-hover" id="tabelaProdutos">
                        <thead>
                            <tr>
                                <th style="text-align: left" scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Unidade de Medida</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Preco de Custo</th>
                                <th scope="col">Preco de Venda</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                            <tr id="{{$produto['id']}}">
                            <th scope="row">{{$produto['id']}}</th>
                            <td>{{$produto['nome']}}</td>
                            <td>{{$produto['marca']}}</td>
                            <td>{{$produto['descricao']}}</td>
                            <td>{{$produto['unidade_medida']}}</td>
                            <td>{{$produto['categoria']}}</td>
                            <td>{{$produto['quantidade']}}</td>
                            <td>{{$produto['preco_custo']}}</td>
                            <td>{{$produto['preco_venda']}}</td>
                            <td>
                                <form class="acoes-produto form-excluir">
                                    @csrf
                                    <input type="hidden" name="id-produto" value="{{$produto['id']}}">
                                    <button type="submit"><img src="{{asset('icons/btn-delete.png')}}"></button>
                                </form>
                                <a href="{{route('produtos.editar', [ 'id' => $produto['id']])}}"><img src="{{asset('icons/btn-edit.png')}}"></a>
                            </td>
                            <tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        $(document).on('submit', '.form-excluir', function(event) {
                            event.preventDefault();

                            if (!confirm("Deseja excluir o produto?")) {
                                return
                            }
                            var form = $(this);
                            var produtoId = form.find('input[name="id-produto"]').val();
                            $('#submit').prop('disabled', true);
                            jQuery.ajax({
                                url: "{{route('produtos.deletar')}}/" + produtoId,
                                data: form.serialize(),
                                type: "DELETE",
                                success: function(result) {
                                    alert(result.mensagem);
                                    console.log('Produto Excluído.');
                                    $('#' + produtoId).remove();
                                },
                                error: function(xhr, status, error) {
                                    alert(xhr.responseJSON.mensagem);
                                    $('#submit').prop('disabled', false);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</main>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>