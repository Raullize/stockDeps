<?php
$this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url('assets/app/css/home.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title text-primary fw-bold mb-0">
                            <i class="fas fa-chart-line me-2"></i>Dashboard
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Cards Estatísticos -->
                        <div class="row g-4">
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-primary h-100 box-hover">
                                    <div class="card-body d-flex flex-column statistic-cards">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Total de Produtos</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-box fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="total-produtos" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-calendar-day"></i> Atualizado hoje</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-success h-100 box-hover">
                                    <div class="card-body d-flex flex-column statistic-cards">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Produtos em Estoque</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="produtos-estoque" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-level-up-alt"></i> Suficiente</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-warning h-100 box-hover">
                                    <div class="card-body d-flex flex-column statistic-cards">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Estoque Baixo</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="estoque-baixo" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-arrow-down"></i> Repor itens</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-danger h-100 box-hover">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Produtos Sem Estoque</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-times-circle fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="produtos-sem-estoque" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-exclamation-circle"></i> Reabasteça urgentemente</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-light bg-dark h-100 box-hover">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Total de Clientes</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-users fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="total-clientes" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-user-check"></i> Base ativa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-secondary h-100 box-hover">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Total de Fornecedores</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-truck fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="total-fornecedores" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-handshake"></i> Fornecedores ativos</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center text-white bg-info h-100 box-hover">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title text-white mb-0">Total de Entradas</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-arrow-circle-down fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="total-entradas" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-calendar-check"></i> Entradas registradas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm text-center bg-light h-100 box-hover">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title mb-0">Total de Saídas</h5>
                                            <div class="icon-wrapper">
                                                <i class="fas fa-arrow-circle-up fa-2x"></i>
                                            </div>
                                        </div>
                                        <h3 id="total-saidas" class="mt-3 mb-2">0</h3>
                                        <p class="mt-auto"><i class="fas fa-calendar-check"></i> Saídas registradas</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráficos e Dados Financeiros -->
                        <div class="row mt-4">
                            <div class="col-lg-5 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="card-title text-primary fw-bold mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>Lucro por Período
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Filtro para selecionar o período -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="periodo" class="form-label fw-semibold">Selecione o Período</label>
                                                <select id="periodo" class="form-select shadow-sm" onchange="calcularLucro()">
                                                    <option value="total">Total</option>
                                                    <option value="dia">Dia</option>
                                                    <option value="semana">Semana</option>
                                                    <option value="duasSemanas">Duas semanas</option>
                                                    <option value="mes">Mês</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Exibindo Lucro Bruto e Lucro Líquido -->
                                        <div class="row mt-auto mb-3">
                                            <div class="col-md-6 mb-3">
                                                <div class="card bg-light shadow-sm h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="card-title fw-bold text-primary">Lucro Bruto</h6>
                                                            <i class="fas fa-dollar-sign text-success"></i>
                                                        </div>
                                                        <h4 id="lucro-bruto" class="mt-2 fw-bold">R$ 0,00</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Caixa de Lucro Líquido -->
                                            <div class="col-md-6 mb-3">
                                                <div class="card bg-light shadow-sm h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="card-title fw-bold text-primary">Lucro Líquido</h6>
                                                            <i class="fas fa-dollar-sign text-success"></i>
                                                        </div>
                                                        <h4 id="lucro-liquido" class="mt-2 fw-bold">R$ 0,00</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-auto">
                                            <div class="col">
                                                <div class="card bg-light shadow-sm h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class="card-title fw-bold text-primary">Valor Total do Estoque</h6>
                                                            <i class="fas fa-boxes text-info"></i>
                                                        </div>
                                                        <h4 id="valor-estoque" class="mt-2 fw-bold">R$ 0,00</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="card-title text-primary fw-bold mb-0">
                                            <i class="fas fa-chart-pie me-2"></i>Distribuição por Categorias
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-container">
                                            <canvas id="chart-categorias"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="card-title text-primary fw-bold mb-0">
                                            <i class="fas fa-star me-2"></i>Produtos Mais Vendidos
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="produtos-mais-vendidos-container">
                                            <ul class="list-group list-group-flush" id="produtos-mais-vendidos">
                                                <!-- Os itens serão inseridos dinamicamente pelo JavaScript -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Produtos com Estoque Baixo -->
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card shadow-sm border-danger">
                                    <div class="card-header bg-white py-3 border-danger">
                                        <h5 class="card-title text-danger fw-bold mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Produtos com Estoque Baixo
                                        </h5>
                                    </div>
                                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                        <ul class="list-group" id="lista-estoque-baixo">
                                            <!-- Itens inseridos dinamicamente -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= url('assets/app/js/home.js') ?>"></script>
</body>