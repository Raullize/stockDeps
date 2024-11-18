<?php
$this->layout("_theme");
echo '<script>';
echo 'var categorias = ' . json_encode($categorias) . ';';
echo '</script>';

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

<link rel="stylesheet" href="<?= url('assets/app/css/home.css') ?>">

<body onload="loadDashboardData()">


<div class="dashboard">
    <h1>Painel de Controle - Visão Geral</h1>

    <!-- Cards com Métricas Importantes -->
    <div class="card-container">
        <div class="card-custom">
            <h2>Total de Produtos</h2>
            <p id="totalProdutos">0</p>
        </div>
        <div class="card-custom">
            <h2>Total de Categorias</h2>
            <p id="totalCategorias">0</p>
        </div>
        <div class="card-custom">
            <h2>Total de Clientes</h2>
            <p id="totalClientes">0</p>
        </div>
        <div class="card-custom">
            <h2>Entradas Totais</h2>
            <p id="totalEntradas">R$ 0,00</p>
        </div>
        <div class="card-custom">
            <h2>Saídas Totais</h2>
            <p id="totalSaidas">R$ 0,00</p>
        </div>
        
        <!-- Card de Lucro com Select -->
        <div class="card-custom">
            <h2>Lucro</h2>
            <select class="lucro-select" id="lucroPeriodo" onchange="atualizarLucro()">
                <option value="dia">Hoje</option>
                <option value="semana">Última Semana</option>
                <option value="mes">Último Mês</option>
            </select>
            <p id="lucroPeriodoValor">R$ 200,00</p>
        </div>

        <div class="card-custom">
            <h2>Vendas no Dia</h2>
            <p id="vendasDia">R$ 0,00</p>
        </div>
    </div>

    <!-- Contêiner para Gráficos -->
    <div class="chart-container">
        <h2>Relatório de Vendas e Despesas</h2>
        <div class="chart" id="chartVendas"></div>
    </div>
    <div class="chart-container">
        <h2>Comparação de Entradas e Saídas</h2>
        <div class="chart" id="chartEntradasSaidas"></div>
    </div>
</div>


  <script src="<?= url('assets/app/js/home.js') ?>"></script>
  <script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>
</body>