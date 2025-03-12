<?php 
$this->layout("_theme");
?>

<style>
.reports-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 0;
}

.report-card {
    background: #ffffff; /* Cor de fundo igual ao cabeçalho */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    overflow: hidden;
}

.report-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.report-card .card-body {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.report-card .card-title {
    color: #343a40;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.report-card .card-text {
    color: #6c757d;
    flex-grow: 1;
    margin-bottom: 1.5rem;
    text-align: center;
}

.report-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-report {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-pdf {
    background-color: #e63946;
    border-color: #e63946;
    color: white;
}

.btn-pdf:hover {
    background-color: #d62839;
    border-color: #d62839;
    color: white;
}

.btn-excel {
    background-color: #2a9d8f;
    border-color: #2a9d8f;
    color: white;
}

.btn-excel:hover {
    background-color: #21867a;
    border-color: #21867a;
    color: white;
}

.report-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #4361ee;
}

.details-list {
    list-style-type: none;
    padding-left: 0;
    margin-bottom: 1.5rem;
}

.details-list li {
    padding: 0.3rem 0;
    display: flex;
    align-items: center;
}

.details-list li i {
    color: #3498db;
    margin-right: 0.5rem;
    font-size: 0.8rem;
}

.report-header {
    text-align: center;
    margin: 2rem 0;
    color: #2c3e50;
}

.report-header p {
    max-width: 800px;
    margin: 0 auto;
    color: #666;
}

.download-info {
    font-size: 0.8rem;
    text-align: center;
    color: #666;
    margin-top: 0.5rem;
}

.dashboard-header {
    border-left: 5px solid #4361ee; /* Borda lateral azul */
}

.dashboard-header h1 {
    color: #4361ee; /* Cor azul para o título */
    position: relative;
    padding-left: 0; /* Remover padding à esquerda */
}

.dashboard-header h1:before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    background-color: transparent;
    border-radius: 0;
}

.header-divider {
    width: 50px;
    height: 3px;
    background-color: #4361ee;
    margin-top: 10px;
}
</style>

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