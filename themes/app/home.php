<?php
    $this->layout("_theme");
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
            <p class="resposta">20000 R$</p>
          </div>

          <div class="cartao-medio">
            <p class="titulo-relatorio">Clientes</p>
            <p class="resposta">30</p>
          </div>
        </div>
        <div class="block">
          <div class="cartao-grande">
            <p class="titulo-relatorio mb-4">Itens em cada categoria:</p>
            <p class="resposta-letra">Lava roupas = 24</p>
            <p class="resposta-letra">Lava louças = 24</p>
            <p class="resposta-letra">Lava carro = 24</p>
            <p class="resposta-letra">Limpeza de Ambiente = 24</p>
            <p class="resposta mt-5">Total = 24</p>
          </div>
        </div>
        
    </div>
  </div>