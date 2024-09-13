<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('estilos/estilo_produtos.css')}}">
    <title>Adicionar Fornecedores</title>
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
                        <li class="nav-item"><a href="{{route('fornecedores')}}">Voltar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container text-center">
            <section class="mt-5">
                <form class="needs-validation" action="{{route('fornecedores.processar')}}" method="POST" id="formulario-adicionar-fornecedores" novalidate>
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-auto text-start">
                            <label class="form-label" for="nomeFornecedor">Nome do Fornecedor:</label>
                            <input class="form-control" placeholder="Nome do Fornecedor" id="nomeFornecedor" name="nome-fornecedor" required>
                        </div>
                        <div class="col-auto text-start">
                            <label class="form-label" for="cnpj">CNPJ (XX.XXX.XXX/0001-XX):</label>
                            <input class="form-control" id="cnpj" placeholder="CNPJ do Fornecedor..." name="cnpj-fornecedor" required>
                        </div>
                        <div class="col-auto text-start">
                            <label class="form-label" for="enderecoFornecedor">Endereço:</label>
                            <input class="form-control" placeholder="Endereço do Fornecedor" id="enderecoFornecedor" name="endereco-fornecedor" required>
                        </div>
                        <div class="col-auto text-start">
                            <label class="form-label" for="telefoneFornecedor">Telefone (XX)XXXX-XXXX:</label>
                            <input class="form-control" placeholder="Telefone do Fornecedor" id="telefoneFornecedor" name="telefone-fornecedor" required>
                        </div>
                        <div class="col-auto text-start">
                            <label class="form-label" for="emailFornecedor">Email:</label>
                            <input class="form-control" placeholder="Email do Fornecedor" id="emailFornecedor" name="email-fornecedor" required>
                        </div>
                        <div class="col-auto text-start">
                            <label class="form-label" for="contatoFornecedor">Contato:</label>
                            <input class="form-control" placeholder="Contato do Fornecedor" id="contatoFornecedor" name="contato-fornecedor" required>
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
                        <div style="font-family: Helvetica">
                        {{$errors->has('nome-fornecedor') ? $errors->first('nome-fornecedor'): '' }}
                        {{$errors->has('cnpj-fornecedor') ? $errors->first('cnpj-fornecedor'): '' }}
                        {{$errors->has('endereco-fornecedor') ? $errors->first('endereco-fornecedor'): '' }}
                        {{$errors->has('telefone-fornecedor') ? $errors->first('telefone-fornecedor'): '' }}
                        {{$errors->has('email-fornecedor') ? $errors->first('email-fornecedor'): '' }}
                        {{$errors->has('contato-fornecedor') ? $errors->first('contato-fornecedor'): '' }}
                        </div>
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