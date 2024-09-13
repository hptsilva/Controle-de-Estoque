<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('estilos/estilo_entrada.css')}}">
    <title>Entrada</title>
  </head>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script type="text/javascript">
    function inputCodigo(){
        const inputCodigo = document.getElementById('codigo');
        const alterarCodigoBtn = document.getElementById('alterar-codigo-btn');
        if (alterarCodigoBtn.disabled === false) {
            alterarCodigoBtn.disabled = true;
            inputCodigo.disabled = true;
        } else {
            alterarCodigoBtn.disabled = false;
            inputCodigo.disabled = false;
        }
    }
</script>
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
                <li class="nav-item">
                    <a href="{{route("index")}}">Voltar</a>
                </li>
            </ul>
        </div>
      </div>
    </nav>
    <main class="container text-center">
      <section class="mt-5">
        <form method="POST" id="formulario-entrada">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="nome_produto">Nome do Produto:</label>
                    <select class="form-select" name="nome_produto" id="nome_produto" required>
                        <option value="" selected disabled>Escolha o nome do produto</option>
                        @foreach ($produtos as $produto)
                            <option value="{{$produto->id}}">{{$produto->nome_produto}}</option>
                        @endforeach
                    </select>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#nome_produto').change(function() {
                            jQuery.ajax(
                                {
                                url: "{{route('entrada.dados')}}",
                                data: {id_produto:$('#nome_produto').val()},
                                type: 'GET',
                                success: function(result)
                                {
                                    $('#marca').val(result.produto[0].marca);
                                    $('#categoria').val(result.produto[0].categoria);
                                    $('#unidade').val(result.produto[0].unidade);
                                }
                            });
                        });
                    });
                </script>
                <div class="col-auto">
                    <label for="marca">Marca:</label>
                    <input value="" class="form-control" name="marca" id="marca" disabled required>
                </div>
                <div class="col-auto">
                    <label for="categoria">Categoria:</label>
                    <input value="" class="form-control" name="categoria" id="categoria" disabled required>
                </div>
                <div class="col-auto">
                    <label for="unidade">Unidade de medida:</label>
                    <input value="" class="form-control" name="unidade" id="unidade" disabled required>
                </div>
                <div class="col-auto">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" value="" class="form-control" name="quantidade" id="quantidade" min="0" step="0.01" required>
                </div>
                <div class="col-auto">
                    <label for="fornecedor">Fornecedor:</label>
                    <select class="form-select" name="fornecedor" id="fornecedor" required>
                        <option value="" selected disabled>Fornecedor do produto</option>
                        @foreach ($fornecedores as $fornecedor)
                            <option value="{{$fornecedor->id}}">{{$fornecedor->nome_fornecedor}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-start mt-4">
                <strong>*Preencha todo o formulário</strong><br>
                <button type="submit" class="btn btn-success">+</button>
                <button type="button" class="btn btn-warning">Lista</button>
            </div>
        </form>
        <div class="d-block text-end mb-5">
            <button type="submit" class="btn btn-success">Confirmar</button>
        </div>
        @if($_SESSION['produtos_entrada'] != [])
            <div class="mb-5">
                <table class="table">
                    <thead>
                        <tr>
                          <th scope="col">Produto</th>
                          <th scope="col">Marca</th>
                          <th scope="col">Categoria</th>
                          <th scope="col">Unidade</th>
                          <th scope="col">Qtd</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"></th>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        <tr>
                      </tbody>
                </table>
            </div>
        @endif
        <script>
            (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
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
        <script>
            const toastTrigger = document.getElementById('listaProdutosBtn')
            const toastLiveExample = document.getElementById('listBoxProdutos')

            if (toastTrigger) {
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                toastTrigger.addEventListener('click', () => {
                    toastBootstrap.show()
                })
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $('#formulario-entrada').on('submit', function(event)
                {
                    event.preventDefault();

                    jQuery.ajax(
                        {
                        url: "{{route('entrada.processar')}}",
                        data: jQuery('#formulario-entrada').serialize(),
                        type: "POST",
                        success:function(result)
                        {
                            alert('Entrada adicionada');
                        },
                        error:function(xhr, status, error)
                        {
                            alert('Erro');
                        }

                    })
                })
            })
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