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


<div class="container">
  <div class="card">Card 1 Content</div>
  <div class="card">Card 2 Content</div>
  <div class="card">Card 3 Content</div>
  <div class="card">Card 4 Content</div>
  <div class="card">Card 5 Content</div>
</div>
</div>





<script src="<?= url('assets/app/js/home.js') ?>"></script>
<script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>