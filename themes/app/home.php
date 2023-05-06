<?php
    $this->layout("_theme");
    echo '<script>';
    echo 'var categorias = ' . json_encode($categorias) . ';';
    echo '</script>';
    //PEGA OS DADOS DOS PRODUTOS DO BANCO DE DADOS
    echo '<script>';
    echo 'var produtos = ' . json_encode($produtos) . ';';
    echo '</script>';

    echo '<script>';
    echo 'var clientes = ' . json_encode($clientes) . ';';
    echo '</script>';
    
?>
   <link rel="stylesheet" href="<?= url('assets/app/css/styleSassHome.css') ?>">

   <div class="container1">
  <!--BARRA LATERAL DO SITE-->
  <div class="barraLateral">
    <a href="<?= url('estoque') ?>">
      <button class="botaoBarraLateral">
        <img class="iconesBarraLateral" id="iconeEstoque" src="<?= url('assets/app/icones/iconeEstoque.png') ?>" alt="">
        <p class="nomesBarraLateral">Estoque</p>
      </button>
    </a>
    <a href="<?= url('cadastro') ?>"> 
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeProduto" src="<?= url('assets/app/icones/iconeProduto.png') ?>" alt="">
      <p class="nomesBarraLateral">Cadastro</p>
    </button>
    </a>
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeContabilidade"
        src="<?= url('assets/app/icones/iconeContabilidade.png') ?>" alt="">
      <p class="nomesBarraLateral">Contabilidade</p>
    </button>
    <a href="<?= url('clientes') ?>"> 
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeClientes" src="<?= url('assets/app/icones/iconeClientes.png') ?>" alt="">
      <p class="nomesBarraLateral">Clientes</p>
    </button>
    </a>
  </div>

  <!--DASHBOARD-->
  <div class="relatorio">

    <div class="containerBotoesBalanco">
      <input type="radio" class="" name="checks" id="checkProduto" checked>
      <label for="checkProduto">
        <p class="botaoRelatorioBalanco">
          1m 
        </p>
      </label>

      <input type="radio" class="" name="checks" id="checkProduto2">
      <label for="checkProduto2">
        <p class="botaoRelatorioBalanco">
          3m
        </p>
      </label>
      <input type="radio" class="" name="checks" id="checkProduto3">
      <label for="checkProduto3">
        <p class="botaoRelatorioBalanco">
          6m
        </p>
      </label>
      <input type="radio" class="" name="checks" id="checkProduto4">
      <label for="checkProduto4">
        <p class="botaoRelatorioBalanco">
          Máx
        </p>
      </label>
    </div>
      <div class="flex">
        <div class="block">
          <div class="cartao-pequeno">
            <p class="titulo-relatorio">Vendas</p>
            <p class="resposta">5900</p>
          </div>

          <div class="cartao-medio">
            <p class="titulo-relatorio">Mais vendidos:</p>
            <p class="resposta-letra">1 - Lava roupas</p>
            <p class="resposta-letra">2 - Lava carros</p>
            <p class="resposta-letra">3 - Lava louças</p>
          </div>

        </div>
        <div class="block">
          <div class="cartao-pequeno">
            <p class="titulo-relatorio">Renda</p>
            <p class="resposta">R$ 20000 </p>
          </div>

          <div class="cartao-medio">
            <p class="titulo-relatorio">Clientes</p>
            <p class="resposta" id="qtd-clientes"></p>
          </div>
        </div>
        <div class="block">
          <div class="cartao-grande" id="conta-itens">
            <p class="titulo-relatorio mb-4">Itens em cada categoria:</p>
            <p class="resposta-letra" id="lava-roupas-qtd">Lava roupas = 24</p>
            <p class="resposta-letra" id="lava-loucas-qtd">Lava louças = 24</p>
            <p class="resposta-letra" id="lava-carros-qtd">Lava carro = 24</p>
            <p class="resposta-letra" id="limpeza-ambiente-qtd">Limpeza de Ambiente = 24</p>
            <p class="resposta mt-5" id="total-produtos-qtd">Total = 24</p>
          </div>
        </div>
        
    </div>
  </div>
 
  <script src="<?= url('assets/app/js/home.js') ?>"></script>
  <script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>