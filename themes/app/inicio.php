<?php
$this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url('assets/app/css/home.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>

    <div class="container mt-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
        </div>

        <!-- Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center text-white bg-primary box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Total de Produtos</h5>
                        <h3>145</h3>
                        <p><i class="fas fa-box"></i> Atualizado hoje</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-success box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Produtos em Estoque</h5>
                        <h3></h3>
                        <p><i class="fas fa-check-circle"></i> Suficiente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-warning box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Estoque Baixo</h5>
                        <h3>15</h3>
                        <p><i class="fas fa-exclamation-triangle"></i> Repor itens</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-danger box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Produtos Sem Estoque</h5>
                        <h3>0</h3>
                        <p><i class="fas fa-times-circle"></i> Reabasteça urgentemente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-dark box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Total de Clientes</h5>
                        <h3 id="total-clientes"></h3>
                        <p><i class="fas fa-users"></i> Base ativa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-secondary box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Total de Fornecedores</h5>
                        <h3 id="total-fornecedores"></h3>
                        <p><i class="fas fa-truck"></i> Fornecedores ativos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-info box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Total de Entradas</h5>
                        <h3 id="total-entradas"></h3>
                        <p><i class="fas fa-arrow-circle-up"></i> Entradas registradas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light box-hover">
                    <div class="card-body">
                        <h5 class="card-title">Total de Saídas</h5>
                        <h3 id="total-saidas"></h3>
                        <p><i class="fas fa-arrow-circle-down"></i> Saídas registradas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mt-5 g-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lucro por Período</h5>
                        <div class="chart-container">
                            <canvas id="chart-lucro"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Distribuição por Categorias</h5>
                        <div class="chart-container">
                            <canvas id="chart-categorias"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produtos Mais Vendidos</h5>
                        <ul class="list-group list-group-flush" id="produtos-mais-vendidos">
                            <!-- Os itens serão inseridos dinamicamente pelo JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= url('assets/app/js/home.js') ?>"></script>
</body>
