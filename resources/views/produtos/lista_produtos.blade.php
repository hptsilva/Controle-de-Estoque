<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('estilos/estilo_produtos.css')}}">
    <title>Produtos</title>
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
                <li class="nav-item"><a href="{{route('produtos.adicionar')}}">Cadastrar Produto</a></li>
            </ul>
        </div>
      </div>
    </nav>
    <main class="container text-center">
      <section class="mt-5 mb-5" id="tabela-mercadorias">
        <h1>Tabela de Produtos</h1>
        <br>
        <div class="table-responsive">
          <table class="table table-dark table-hover" id="tabela">
              <thead>
                <tr>
                  <th scope="col">Produto</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Unidade</th>
                  <th scope="col">Preço Custo (R$)</th>
                  <th scope="col">Preço Venda (R$)</th>
                  <th scope="col">Estoque Atual</th>
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
                <tr>
                @endforeach
              </tbody>
            </table>
        </div>
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