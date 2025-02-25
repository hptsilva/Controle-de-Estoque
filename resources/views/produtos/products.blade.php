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
                            <label for="pesquisar-produto"></label>
                            <input class="form-control" type="text" id="pesquisar-produto" name="pesquisar" placeholder="Pesquisar produto">
                        </form>
                        <div style="margin-top: 20px; margin-bottom: 20px;">
                            <a href="{{route('produtos.adicionar')}}"><img src="{{asset('icons/btn-add.png')}}"></a>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Unidade</th>
                                <th scope="col">Custo (R$)</th>
                                <th scope="col">Venda (R$)</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                            <tr>
                              <th scope="row">{{$produto->nome_produto}}</th>
                              <td>{{$produto->categoria}}</td>
                              <td>{{$produto->marca}}</td>
                              <td>{{$produto->unidade}}</td>
                              <td>{{$produto->preco_custo}}</td>
                              <td>{{$produto->preco_venda}}</td>
                              <td>{{$produto->estoque_atual}}</td>
                              <td>
                                <form id="form-excluir-{{$produto->id}}" action="">
                                    @csrf
                                    <input type="hidden" name="id-produto" value="{{$produto->id}}">
                                    <button type="submit"><img src="{{asset('icons/btn-delete.png')}}"></button>
                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function()
                                    {
                                        $('#form-excluir-{{$produto->id}}').on('submit', function(event)
                                        {
                                            event.preventDefault();
                                            $('#submit').prop('disabled', true);
                
                                            jQuery.ajax(
                                                {
                                                url: "{{route('produtos.deletar', ['id' => $produto->id])}}",
                                                data: jQuery('#form-excluir-{{$produto->id}}').serialize(),
                                                type: "DELETE",
                                                success:function(result)
                                                {
                                                    alert(result.mensagem)
                                                    location.reload();
                                                },
                                                error:function(xhr, status, error)
                                                {
                                                    alert(xhr.responseJSON.mensagem)
                                                    location.reload();
                                                    $('#submit').prop('disabled', false);
                                                }
                
                                            })
                                        })
                                    })
                                </script>
                              </td>
                            <tr>
                            @endforeach
                          </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>