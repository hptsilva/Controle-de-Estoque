<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('estilos/suppliers_style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Fornecedores</title>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#fornecedores").css("color", "#FFF1D0");
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
                    <h1>FORNECEDORES</h1>
                    <div class="opcoes-fornecedores">
                        <form id="form-pesquisar">
                        @csrf
                            <div class='formulario'>
                                <label for="pesquisar-fornecedor"></label>
                                <input class="form-control input-text" type="text" id="pesquisar-fornecedor" name="pesquisar-input-text" placeholder="Pesquisar fornecedor" required>
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
                                        url: "{{route('fornecedores.pesquisar')}}",
                                        data: jQuery('#form-pesquisar').serialize(),
                                        type: "GET",
                                        success:function(result)
                                        {
                                            fornecedores = result.fornecedores
                                            var tabela = $('#tabelaFornecedores');
                                            tabela.empty();
                                            var cabecalho = '<thead><tr><th style="text-align: left" scope="col">Nome</th><th scope="col">Categoria</th><th scope="col">Marca</th><th scope="col">Unidade</th><th scope="col">Custo (R$)</th><th scope="col">Venda (R$)</th><th scope="col">Quantidade</th><th scope="col">Ações</th></tr></thead>'
                                            tabela.append(cabecalho);
                                            tabela.append('<tbody>');
                                            fornecedores.forEach(fornecedor => {
                                                corpo = '';
                                                corpo += '<tr id=\'' + fornecedor.id + '\'>';
                                                corpo += '<th scope="row">' + fornecedor.nome_fornecedor +'</th>';
                                                console.log("Nome do Fornecedor:", fornecedor.nome_fornecedor);
                                                corpo += '<td>' + fornecedor.cnpj + '</td>';
                                                console.log("CNPJ:", fornecedor.cnpj);
                                                corpo += '<td>' + fornecedor.endereco + '</td>';
                                                console.log("Endreço:", fornecedor.endereco);
                                                corpo += '<td>' + fornecedor.telefone + '</td>';
                                                console.log("Telefone:", fornecedor.telefone);
                                                corpo += '<td>' + fornecedor.email + '</td>';
                                                console.log("E-mail:", fornecedor.email);
                                                corpo += '<td>' + fornecedor.contato + '</td>';
                                                console.log("Contato:", fornecedor.contato);
                                                console.log("-----------------------------");
                                                corpo += '<td>';
                                                corpo += '<form class="acoes-fornecedor form-excluir">';
                                                corpo += '@csrf';
                                                corpo += '<input type="hidden" name="id-fornecedor" value="' + fornecedor.id + '">';
                                                corpo += '<button type="submit"><img src="{{asset('icons/btn-delete.png')}}"></button>';
                                                corpo += '</form>';
                                                corpo += '<a href="' + '{{ url("fornecedores/editar") }}/' + fornecedor.id + '"><img src="{{ asset("icons/btn-edit.png") }}"></a>';
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
                            <a href="{{route('fornecedores.adicionar')}}"><img src="{{asset('icons/btn-add.png')}}"></a>
                            <a href="{{route('fornecedores')}}"><img src="{{asset('icons/btn-refresh.png')}}" width="50"></a>
                        </div>
                    </div>
                    <table class="table table-hover" id="tabelaFornecedores">
                        <thead>
                            <tr>
                                <th style="text-align: left" scope="col">Nome</th>
                                <th scope="col">CNPJ</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Contato</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fornecedores as $fornecedor)
                            <tr id="{{$fornecedor->id}}">
                            <th scope="row">{{$fornecedor->nome_fornecedor}}</th>
                            <td>{{$fornecedor->cnpj}}</td>
                            <td>{{$fornecedor->endereco}}</td>
                            <td>{{$fornecedor->telefone}}</td>
                            <td>{{$fornecedor->email}}</td>
                            <td>{{$fornecedor->contato}}</td>
                            <td>
                                <form class="acoes-fornecedor form-excluir">
                                    @csrf
                                    <input type="hidden" name="id-fornecedor" value="{{$fornecedor->id}}">
                                    <button type="submit"><img src="{{asset('icons/btn-delete.png')}}"></button>
                                </form>
                                <a href="{{route('fornecedores.editar', [ 'id' => $fornecedor->id])}}"><img src="{{asset('icons/btn-edit.png')}}"></a>
                            </td>
                            <tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        $(document).on('submit', '.form-excluir', function(event) {
                            event.preventDefault();

                            if (!confirm("Deseja excluir o fornecedor?")) {
                                return
                            }
                            var form = $(this);
                            var fornecedorId = form.find('input[name="id-fornecedor"]').val();
                            $('#submit').prop('disabled', true);
                            jQuery.ajax({
                                url: "{{route('fornecedores.deletar', ['id' => ''])}}/" + fornecedorId,
                                data: form.serialize(),
                                type: "DELETE",
                                success: function(result) {
                                    alert(result.mensagem);
                                    console.log(result.id);
                                    $('#' + result.id).remove();
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