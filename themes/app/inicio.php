<?php
$this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url('assets/app/css/home.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>
    <div class="container mt-4">
        <!-- Header com animação sutil e destaque -->
        <div class="dashboard-header mb-5 p-4 bg-white shadow-sm rounded-3">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fw-bold display-5 mb-2 text-gradient"><i class="fas fa-chart-pie me-2"></i>Dashboard</h1>
                    <p class="text-muted fs-5 fw-light">Visão geral do sistema de estoque</p>
                    <div class="header-divider mt-3"></div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <div class="date-display text-end">
                        <span class="current-date fw-bold"></span>
                        <script>
                            // Adicionar data atual
                            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                            document.querySelector('.current-date').textContent = new Date().toLocaleDateString('pt-BR', options);
                        </script>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cards de estatísticas com efeito hover -->
        <div class="row g-4 mb-5">
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-primary box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-box fa-2x mb-3"></i>
                        <h5 class="card-title">Total de Produtos</h5>
                        <h3 id="total-produtos" class="counter">0</h3>
                        <p><i class="fas fa-sync-alt"></i> Atualizado hoje</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-success box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-check-circle fa-2x mb-3"></i>
                        <h5 class="card-title">Produtos em Estoque</h5>
                        <h3 id="produtos-estoque" class="counter">0</h3>
                        <p><i class="fas fa-check-circle"></i> Suficiente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-warning box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <h5 class="card-title">Estoque Baixo</h5>
                        <h3 id="estoque-baixo" class="counter">0</h3>
                        <p><i class="fas fa-exclamation-triangle"></i> Repor itens</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-danger box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-times-circle fa-2x mb-3"></i>
                        <h5 class="card-title">Produtos Sem Estoque</h5>
                        <h3 id="produtos-sem-estoque" class="counter">0</h3>
                        <p><i class="fas fa-times-circle"></i> Reabasteça urgentemente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-light bg-dark box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <h5 class="card-title">Total de Clientes</h5>
                        <h3 id="total-clientes" class="counter">0</h3>
                        <p><i class="fas fa-users"></i> Base ativa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-secondary box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-truck fa-2x mb-3"></i>
                        <h5 class="card-title">Total de Fornecedores</h5>
                        <h3 id="total-fornecedores" class="counter">0</h3>
                        <p><i class="fas fa-truck"></i> Fornecedores ativos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-info box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-arrow-circle-up fa-2x mb-3"></i>
                        <h5 class="card-title">Total de Entradas</h5>
                        <h3 id="total-entradas" class="counter">0</h3>
                        <p><i class="fas fa-arrow-circle-up"></i> Entradas registradas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center text-white bg-indigo box-hover h-100">
                    <div class="card-body statistic-cards">
                        <i class="fas fa-arrow-circle-down fa-2x mb-3"></i>
                        <h5 class="card-title">Total de Saídas</h5>
                        <h3 id="total-saidas" class="counter">0</h3>
                        <p><i class="fas fa-arrow-circle-down"></i> Saídas registradas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos e Estatísticas -->
        <div class="row mb-5 g-4">
            <div class="col-lg-5">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-dark section-title"><i class="fas fa-chart-line me-2"></i>Lucro por Período</h4>
                        
                        <!-- Filtro de período com design melhorado -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="form-group">
                                <label for="periodo" class="form-label text-muted">Selecione o Período:</label>
                                <select id="periodo" class="form-select shadow-sm">
                                    <option value="total">Total</option>
                                    <option value="dia">Dia</option>
                                    <option value="semana">Semana</option>
                                    <option value="duasSemanas">Duas semanas</option>
                                    <option value="mes">Mês</option>
                                </select>
                            </div>
                        </div>
                    
                        <!-- Cards de Lucro -->
                        <div class="row mt-4 g-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><i class="fas fa-chart-bar me-2"></i>Lucro Bruto</h5>
                                        <h3 id="lucro-bruto" class="text-success fw-bold">R$ 0,00</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><i class="fas fa-chart-line me-2"></i>Lucro Líquido</h5>
                                        <h3 id="lucro-liquido" class="text-primary fw-bold">R$ 0,00</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Valor do Estoque -->
                        <div class="row mt-3">
                            <div class="col">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><i class="fas fa-cubes me-2"></i>Valor Total do Estoque</h5>
                                        <h3 id="valor-estoque" class="text-info fw-bold">R$ 0,00</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-dark section-title"><i class="fas fa-chart-pie me-2"></i>Distribuição por Categorias</h4>
                        <div class="chart-container">
                            <canvas id="chart-categorias"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm produtos-mais-vendidos-card">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-dark section-title"><i class="fas fa-award me-2"></i>Produtos Mais Vendidos</h4>
                        <div class="produtos-mais-vendidos-container mt-3">
                            <ul class="list-group list-group-flush" id="produtos-mais-vendidos">
                                <!-- Os itens serão inseridos dinamicamente pelo JavaScript -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Produtos com Estoque Baixo -->
        <div class="row mb-5">
            <div class="col">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Produtos com Estoque Baixo</h3>
                        <a href="<?= url('app/estoque') ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Ir para Estoque
                        </a>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <ul class="list-group" id="lista-estoque-baixo">
                            <!-- Itens inseridos dinamicamente -->
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