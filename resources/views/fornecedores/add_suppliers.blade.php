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
                    <h1>ADICIONAR PRODUTO</h1>
                    <form class="needs-validation" id="formulario-adicionar-produtos">
                        @csrf
                        
                        <script type="text/javascript">
                            $(document).ready(function()
                            {
                                $('#formulario-adicionar-produtos').on('submit', function(event)
                                {
                                    event.preventDefault();
                                    $('#submit').prop('disabled', true);

                                    jQuery.ajax(
                                        {
                                        url: "{{route('produtos.adicionar.processar')}}",
                                        data: jQuery('#formulario-adicionar-produtos').serialize(),
                                        type: "POST",
                                        success:function(result)
                                        {
                                            alert(result.mensagem)
                                            location.reload()
                                        },
                                        error:function(xhr, status, error)
                                        {
                                            var mensagens = xhr.responseJSON.mensagem;
                                            var alerta = '';
                                            for (const chave in mensagens) {
                                                alerta = alerta + mensagens[chave] + '\n';
                                            }
                                            alert(alerta)
                                            $('#submit').prop('disabled', false);
                                        }

                                    })
                                })
                            })
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>