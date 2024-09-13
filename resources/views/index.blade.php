<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('estilos/estilo_index.css')}}">
    <title>Controle de Estoque</title>
  </head>
  <body>
    <header>
        <div class='text-center'>
            <h1>CONTROLE DE ESTOQUE</h1>
        </div>
    </header>
    <?php
        if(!isset($_SESSION['id'])){
            ?>
            <div class="container text-center">
                <form action="{{route('autenticacao')}}" method="POST" id="form-login">
                    @csrf
                    <input class="text-center" type="text" name="usuario" placeholder="{{$errors->has('usuario') ? $errors->first('usuario'): 'Usuário' }}"><br>
                    <input class="text-center" type="password" name="senha" placeholder="{{$errors->has('senha') ? $errors->first('senha'): 'Senha' }}">
                    <br>
                    <button type="submit" class="btn btn-primary">Acessar</button>
                    <br>
                    <div>
                        <strong>
                            @php
                                if(isset($erro)){
                                    echo $erro;
                                }
                            @endphp
                        </strong>
                    </div>
                </form>
            </div>
            <?php
        }
    ?>
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
                        <li class="nav-item"><a href="#">Alterar nome de usuário</a></li>
                        <li class="nav-item"><a href="#">Alterar senha</a></li>
                        <a href="{{route('sair')}}" class="btn btn-danger">Sair</a>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div class="container mt-2 mb-5">
                <div class="row text-center justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <img src="{{asset('img/produto.jpeg')}}" class="card-img-top" id="imagem-card" alt="Imagem Mercadoria">
                        <div class="card-body">
                            <h5 class="card-title">Produtos</h5>
                            <p class="card-text">Ver produtos em estoque</p>
                            <a href="{{route('produtos')}}" class="btn btn-primary">Clique aqui</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem;">
                        <img src="{{asset('img/fornecedor.png')}}" class="card-img-top" id="imagem-card" alt="Imagem Fornecedor">
                        <div class="card-body">
                            <h5 class="card-title">Fornecedores</h5>
                            <p class="card-text">Ver fornecedores</p>
                            <a href="{{route('fornecedores')}}" class="btn btn-primary">Clique aqui</a>
                        </div>
                    </div>
                </div>
                <div class="row text-center justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Entrada</h5>
                            <p class="card-text">Entrada de produtos</p>
                            <a href="{{route('entrada')}}" class="btn btn-success">Clique aqui</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Saída</h5>
                            <p class="card-text">Saída de produtos</p>
                            <a href="#" class="btn btn-danger">Clique aqui</a>
                        </div>
                    </div>
                </div>
            </div>
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