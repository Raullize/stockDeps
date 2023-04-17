<?php
    $this->layout("_theme");
?>
<hr>

<div class="container1">
  <!--BARRA LATERAL DO SITE-->
  <div class="barraLateral">
    <a href="estoque.html">
      <button class="botaoBarraLateral">
        <img class="iconesBarraLateral" id="iconeEstoque" src="<?= url('assets/app/icones/iconeEstoque.png') ?>" alt="">
        <p class="nomesBarraLateral">Estoque</p>
      </button>
    </a>
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeProduto" src="<?= url('assets/app/icones/iconeProduto.png') ?>" alt="">
      <p class="nomesBarraLateral">Cadastro</p>
    </button>
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeContabilidade" src="<?= url('assets/app/icones/iconeContabilidade.png') ?>" alt="">
      <p class="nomesBarraLateral">Contabilidade</p>
    </button>
    <button class="botaoBarraLateral">
      <img class="iconesBarraLateral" id="iconeClientes" src="<?= url('assets/app/icones/iconeClientes.png') ?>" alt="">
      <p class="nomesBarraLateral">Clientes</p>
    </button>
  </div>

  <!--DASHBOARD-->
  <div class="relatorio">
    <div class="card">
      <h3>Número de clientes:</h3>
      <p>28</p>
    </div>
    <div class="card">
      <h3>Itens vendidos:</h3>
      <p>50</p>
    </div>
    <div class="card">
      <h3>Itens cadastrados:</h3>
      <p>81</p>
    </div>
    <div class="card">
      <h3>Itens em estoque:</h3>
      <p>20</p>
    </div>
    <div class="card">
      <h3>Lucro/gasto:</h3>
      <p>500 reais</p>
    </div>
    <div class="card">
      <h3>Lucro/gasto:</h3>
      <p>500 reais</p>
    </div>
    <div class="card">
      <h3>Lucro/gasto:</h3>
      <p>500 reais</p>
    </div>
    <div class="card">
      <h3>Lucro/gasto:</h3>
      <p>500 reais</p>
    </div>
  </div>
</div>