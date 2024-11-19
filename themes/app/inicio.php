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
            <button class="btn btn-primary btn-quick-action"><i class="fas fa-plus-circle"></i> Nova Ação</button>
        </div>

        <!-- Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total de Produtos</h5>
                        <h3>145</h3>
                        <p><i class="fas fa-box"></i> Atualizado hoje</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Produtos em Estoque</h5>
                        <h3>120</h3>
                        <p><i class="fas fa-check-circle"></i> Suficiente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Estoque Baixo</h5>
                        <h3>15</h3>
                        <p><i class="fas fa-exclamation-triangle"></i> Repor itens</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Lucro</h5>
                        <h3 id="lucro-total">R$ 0,00</h3>
                        <p><i class="fas fa-chart-line"></i> Período: <span id="periodo-lucro">Mensal</span></p>
                    </div>
                </div>
                <label for="filtro-periodo" class="form-label mt-2">Alterar Período:</label>
                <select id="filtro-periodo" class="form-select">
                    <option value="diario">Diário</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensal" selected>Mensal</option>
                    <option value="anual">Anual</option>
                    <option value="personalizado">Personalizado</option>
                </select>
            </div>
        </div>


        <!-- Gráficos -->
        <div class="row mt-5 g-4">
            <div class="col-md-6">
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produtos Mais Vendidos</h5>
                        <ul class="list-group list-group-flush" id="produtos-mais-vendidos">
                            <li class="list-group-item">Aveia em Flocos <span class="badge bg-success float-end">120</span></li>
                            <li class="list-group-item">Castanha-do-Pará <span class="badge bg-success float-end">85</span></li>
                            <li class="list-group-item">Farinha de Trigo Integral <span class="badge bg-success float-end">65</span></li>
                            <li class="list-group-item">Mel Orgânico <span class="badge bg-success float-end">50</span></li>
                            <li class="list-group-item">Óleo de Coco <span class="badge bg-success float-end">40</span></li>
                            <li class="list-group-item">Chia <span class="badge bg-success float-end">30</span></li>
                            <li class="list-group-item">Linhaça Dourada <span class="badge bg-success float-end">25</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= url('assets/app/js/home.js') ?>">

    </script>
</body>