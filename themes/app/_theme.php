<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="<?= url('assets/app/css/styleSassGeral.css') ?>">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Stock Deps</title>
</head>
<body>

 <!--TOPO DA PÁGINA-->
 <nav class="navbar">
    <a class="navbar-brand"href="<?= url() ?>">
        <p class="deps">Stock deps</p>
    </a>
        <!--BARRA DE PESQUISA-->
        <div class="inputPesquisa">
            <form class="d-flex" role="search">
                <input class="form-control form-control-lg me-2" type="search" placeholder="Procurar cliente"
                    aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Procurar</button>
            </form>
        </div>
        
    </nav>
    

<?php

   echo $this->section("content");

?>
</body>
</html>