<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('estilos/estilo_produtos.css')}}">
    <title>Adicionar Produtos</title>
  </head>
  <body>
    <header>
        <div class='text-center'>
            <h1>CONTROLE DE ESTOQUE</h1>
        </div>
    </header>
    <?php
    if(isset($_SESSION['id'])){
    ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="navegacao">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('index')}}"><img id="logo-img" src="{{asset('img/box.png')}}"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <strong>
                            Bem-vindo(a) 
                            @php
                            echo '<span class="nome-usuario">'.$_SESSION['nome'].'</span>';
                            @endphp
                        </strong></li> 
                        <li class="nav-item"><a href="{{route('produtos')}}">Voltar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container text-center">
            <section class="mt-5">
                <form class="needs-validation" action="{{route('produtos.processar')}}" method="POST" id="formulario-adicionar-produtos" novalidate>
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
                                <option value="eletronicos">Eletrônicos</option>
                                <option value="vestuario">Vestuários</option>
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
                            <label class="form-label" for="unidadeProduto">Unidade: </label>
                            <select class="form-select" placeholder="Escolha a unidade..." id="unidadeProduto" name="unidade-produto" required>
                                <option selected disabled value="">Escolha a unidade de medida</option>
                                <option value="unitario">Unitário(un)</option>
                                <option value="grama">Grama(g)</option>
                                <option value="kilograma">Kilograma(kg)</option>
                                <option value="tonelada">Tonelada(t)</option>
                                <option value="mililitro">Mililitro(ml)</option>
                                <option value="litro">Litro(l)</option>
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
            </section>
        </main>
    <?php
    }
    ?>
    <footer>
        <div class="text-center">
            <strong>Controle de estoque de Humberto Silva</strong>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>