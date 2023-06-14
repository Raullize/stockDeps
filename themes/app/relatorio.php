<?php 
$this->layout("_theme");
?>

<div class="card-group">

<div class="card text-center" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Relatório de Clientes</h5>
    <p class="card-text">Relatório com as informações de cada cliente do sistema, neste documento apresenta dados como: nome, email, celular, entre outros.</p>
    <a href="<?= url("pdf-r-c") ?>" class="btn btn-primary">Baixar</a>
  </div>
</div>

<div class="card text-center" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Relatório de Produtos</h5>
    <p class="card-text">Relatório com as informações de cada produto do sistema, neste documento apresenta dados como: nome, preço, descrição, entre outros.</p>
    <a href="<?= url("pdf-r-p") ?>" class="btn btn-primary">Baixar</a>
  </div>
</div>

<div class="card text-center" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>

</div>