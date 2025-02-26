<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('estilos/add_products_style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Adicionar produtos</title>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#produtos").css("color", "#925f35");
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
                    <h1>ADICIONAR PRODUTO</h1>
                    <form class="needs-validation" action="{{route('produtos.adicionar.processar')}}" method="POST" id="formulario-adicionar-produtos" novalidate>
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-auto text-start">
                                <label class="form-label" for="nomeProduto">Nome do Produto: </label>
                                <input type="text" class="form-control" placeholder="Nome do Produto" id="nomeProduto" name="nome-produto" required>
                            </div>
                            <div class="col-auto text-start">
                                <label class="form-label" for="categoriaProduto">Categoria: </label>
                                <select class="form-select" placeholder="Escolha a categoria..." id="categoriaProduto" name="categoria-produto" required>
                                    <option selected disabled value="">Escolha a categoria</option>
                                    <option value="eletrônicos">Eletrônicos</option>
                                    <option value="vestuários">Vestuários</option>
                                    <option value="alimentos">Alimentos</option>
                                </select>
                            </div>
                            <div class="col-auto text-start">
                                <label class="form-label" for="marcaProduto">Marca</label>
                                <input class="form-control" list="listaMarcas" id="marcaProduto" placeholder="Marca do produto..." name="marca-produto" required>
                                <datalist id="listaMarcas">
                                    @foreach ($marcas as $marca)
                                        <option value="{{$marca->marca}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-auto text-start">
                                <label class="form-label" for="medidadeProduto">Unidade: </label>
                                <select class="form-select" placeholder="Escolha a unidade..." id="medidaProduto" name="medida-produto" required>
                                    <option selected disabled value="">Escolha a unidade de medida</option>
                                    <option value="unitario">Unitário(un)</option>
                                    <option value="grama">Grama(g)</option>
                                    <option value="kilograma">Kilograma(kg)</option>
                                    <option value="tonelada">Tonelada(t)</option>
                                    <option value="mililitros">Mililitro(ml)</option>
                                    <option value="litros">Litro(l)</option>
                                </select>
                            </div>
                            <div class="col-auto text-start">
                                <label class="form-label" for="precoCustoProduto">Preço de custo (R$)</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Preço de custo" id="precoCustoProduto" name="preco-custo-produto" required>
                            </div>
                            <div class="col-auto text-start">
                                <label class="form-label" for="precoVendaProduto">Preço de Venda (R$)</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Preço de venda" id="precoVendaProduto" name="preco-venda-produto" required>
                            </div>
                        </div>
                        <div class="text-start mt-4 mb-5">
                            <strong>*Preencha todo o formulário</strong><br>
                            <button type="submit" class="btn btn-success">Enviar</button>
                            <br><br>
                            @php
                                if(isset($erro)){
                                    echo "<strong style=\"color: Red\">".$erro."</strong>";
                                }else if(isset($sucesso)){
                                    echo "<strong style=\"color: Green\">".$sucesso."</strong>";
                                }
                            @endphp
                        </div>
                    </form>
                    <script>
                        (() => {
                        'use strict'
                        const forms = document.querySelectorAll('.needs-validation')
                        Array.from(forms).forEach(form => {
                            form.addEventListener('submit', event => {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
    
                            form.classList.add('was-validated')
                            }, false)
                        })
                        })()
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