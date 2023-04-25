<?php
$this->layout("_theme");

//PEGA OS DADOS DOS CLIENTES DO BANCO DE DADOS
echo '<script>';
echo 'var cliente = ' . json_encode($clientes) . ';';
echo '</script>';
?>
<!-- Carrega o Jquery-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!--Link biblioteca carrossel-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!--Link css clientes-->
<link rel="stylesheet" href="<?= url('assets/app/css/styleClientes.css') ?>">

       
    <div class="titulo">
        <div class="radios">
          <input type="radio" class="botao-selecionavel" name="checks" id="checkCarrossel" checked>
            <label for="checkCarrossel">
            <p class="botao-produtos">
            Carrossel
            </p>
            </label>
            <input type="radio" class="botao-selecionavel" name="checks" id="checkBloco">
            <label for="checkBloco">
            <p class="botao-produtos">
            Bloco
            </p>
            </label>
        </div>
        <h3>Clientes</h3>
    </div>
    <div id="carousel" class="owl-carousel">

    </div>
    <div class="bloco">

    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?= url('assets/app/js/clientes.js') ?>"></script>