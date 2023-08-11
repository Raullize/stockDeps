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
echo 'var entradas = ' . json_encode($entradas) . ';';
echo '</script>';

echo '<script>';
echo 'var saidas = ' . json_encode($saidas) . ';';
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
      <img class="iconesBarraLateral" id="iconeContabilidade" src="<?= url('assets/app/icones/iconeContabilidade.png') ?>" alt="">
      <p class="nomesBarraLateral">Contabilidade</p>
    </button>
    <a href="<?= url('clientes') ?>">
      <button class="botaoBarraLateral">
        <img class="iconesBarraLateral" id="iconeClientes" src="<?= url('assets/app/icones/iconeClientes.png') ?>" alt="">
        <p class="nomesBarraLateral">Clientes</p>
      </button>
    </a>
  </div>



  <div class="container1">
    <div class="card">
      <div class="cartao-pequeno">
        <p class="titulo-relatorio">Vendas</p>
        <p class="resposta" id="qtd-vendas"></p>
      </div>
    </div>

    <div class="card">
      <div class="cartao-medio">
        <p class="titulo-relatorio">Mais vendidos:</p>
        <p class="resposta-letra" id="ranking-categorias"></p>

      </div>
    </div>

    <div class="card">
      <div class="cartao-pequeno">
        <p class="titulo-relatorio">Renda</p>
        <p class="resposta">R$ 20000 </p>
      </div>
    </div>

    <div class="card">
      <div class="cartao-medio">
        <p class="titulo-relatorio">Clientes</p>
        <p class="resposta" id="qtd-clientes"></p>
      </div>
    </div>




    <div class="card">
      <div class="cartao-grande" id="conta-itens">
        <p class="titulo-relatorio mb-4">Itens em cada categoria:</p>
        <p class="resposta-letra" id="lava-roupas-qtd">Lava roupas = 0</p>
        <p class="resposta-letra" id="lava-loucas-qtd">Lava louças = 0</p>
        <p class="resposta-letra" id="lava-carros-qtd">Lava carro = 0</p>
        <p class="resposta-letra" id="limpeza-ambiente-qtd">Limpeza de Ambiente = 0</p>
        <p class="resposta-letra" id="outros-qtd">Outros = 0</p>
        <p class="resposta mt-3" id="total-produtos-qtd">Total = 0</p>
      </div>
    </div>
  </div>



  <script src="<?= url('assets/app/js/home.js') ?>"></script>
  <script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>