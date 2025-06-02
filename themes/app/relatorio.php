<?php 
$this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("assets/app/css/relatorio.css") ?>">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<body>
    <div class="container-fluid mt-4">
        <!-- Header com animação sutil e destaque -->
        <div class="dashboard-header mb-4 p-4 bg-white shadow-sm rounded-3">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fw-bold display-6 mb-2 text-gradient"><i class="fas fa-file-alt me-2"></i>Relatórios</h1>
                    <p class="text-muted fs-5 fw-light">Visualize e gere relatórios detalhados do sistema</p>
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

        <div class="reports-container">
            <div class="report-card">
                <div class="card-body">
                    <i class="fas fa-users report-icon"></i>
                    <h5 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Relatório de Clientes
                    </h5>
                    <p class="card-text">Relatório completo com as informações de todos os clientes cadastrados no sistema.</p>
                    
                    <ul class="details-list">
                        <li><i class="fas fa-circle"></i> Nome completo do cliente</li>
                        <li><i class="fas fa-circle"></i> CPF</li>
                        <li><i class="fas fa-circle"></i> Número de celular</li>
                    </ul>
                    
                    <div class="report-actions">
                        <a href="<?= url("app/pdf-r-c") ?>" class="btn btn-report btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                            PDF
                        </a>
                        <a href="<?= url("app/excel-r-c") ?>" class="btn btn-report btn-excel" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Excel
                        </a>
                    </div>
                    <div class="download-info">O download iniciará em uma nova aba</div>
                </div>
            </div>

            <div class="report-card">
                <div class="card-body">
                    <i class="fas fa-building report-icon"></i>
                    <h5 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Relatório de Fornecedores
                    </h5>
                    <p class="card-text">Relatório completo com todos os dados de fornecedores registrados no sistema.</p>
                    
                    <ul class="details-list">
                        <li><i class="fas fa-circle"></i> Nome/Razão social</li>
                        <li><i class="fas fa-circle"></i> CNPJ</li>
                        <li><i class="fas fa-circle"></i> Email e telefone</li>
                        <li><i class="fas fa-circle"></i> Endereço completo</li>
                    </ul>
                    
                    <div class="report-actions">
                        <a href="<?= url("app/pdf-r-f") ?>" class="btn btn-report btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                            PDF
                        </a>
                        <a href="<?= url("app/excel-r-f") ?>" class="btn btn-report btn-excel" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Excel
                        </a>
                    </div>
                    <div class="download-info">O download iniciará em uma nova aba</div>
                </div>
            </div>

            <div class="report-card">
                <div class="card-body">
                    <i class="fas fa-box report-icon"></i>
                    <h5 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Relatório de Produtos
                    </h5>
                    <p class="card-text">Relatório detalhado com as informações de todos os produtos em estoque.</p>
                    
                    <ul class="details-list">
                        <li><i class="fas fa-circle"></i> Código do produto</li>
                        <li><i class="fas fa-circle"></i> Nome e descrição</li>
                        <li><i class="fas fa-circle"></i> Preço unitário</li>
                        <li><i class="fas fa-circle"></i> Quantidade em estoque</li>
                        <li><i class="fas fa-circle"></i> Unidade de medida</li>
                    </ul>
                    
                    <div class="report-actions">
                        <a href="<?= url("app/pdf-r-p") ?>" class="btn btn-report btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                            PDF
                        </a>
                        <a href="<?= url("app/excel-r-p") ?>" class="btn btn-report btn-excel" target="_blank">
                            <i class="fas fa-file-excel"></i>
                            Excel
                        </a>
                    </div>
                    <div class="download-info">O download iniciará em uma nova aba</div>
                </div>
            </div>
        </div>
    </div>
</body>