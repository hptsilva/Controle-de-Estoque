<div class="col-2">
    <section>
        <h5>Olá, {{$_SESSION['username']}}.</h5>
        <div class="opcoes">
            <div class="inicio">
                <a href="{{route('index')}}" id="inicio">Início</a>
            </div>
            <div class="configuracoes">
                <a href="{{route('configuracoes')}}" id="configuracoes">Configurações</a>
            </div>
            <div class="produtos">
                <a href="{{route('produtos')}}" id="produtos">Produtos</a>
            </div>
            <div class="fornecedores">
                <a href="{{route('fornecedores')}}" id="fornecedores">Fornecedores</a>
            </div>
            <div class="logout">
                <a href="{{route('logout')}}" id="sair">Sair</a>
            </div>
        </div>
    </section>
</div>