<?php 
$this->layout("_theme");
?>

<style>
.reports-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}

.report-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
    height: 100%;
}

.report-card:hover {
    transform: translateY(-5px);
}

.report-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.report-card .card-title {
    color: #2c3e50;
    font-size: 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.report-card .card-text {
    color: #666;
    flex-grow: 1;
    margin-bottom: 1.5rem;
}

.report-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-report {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-pdf {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.btn-pdf:hover {
    background-color: #c82333;
    border-color: #bd2130;
    color: white;
}

.btn-excel {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-excel:hover {
    background-color: #218838;
    border-color: #1e7e34;
    color: white;
}

.report-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #3498db;
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="reports-container">
    <div class="report-card">
        <div class="card-body">
            <i class="fas fa-users report-icon"></i>
            <h5 class="card-title">
                <i class="fas fa-file-alt"></i>
                Relatório de Clientes
            </h5>
            <p class="card-text">Relatório com as informações de cada cliente do sistema, incluindo nome, CPF e celular.</p>
            <div class="report-actions">
                <a href="<?= url("app/pdf-r-c") ?>" class="btn btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </a>
                <a href="<?= url("app/excel-r-c") ?>" class="btn btn-report btn-excel">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </a>
            </div>
        </div>
    </div>

    <div class="report-card">
        <div class="card-body">
            <i class="fas fa-building report-icon"></i>
            <h5 class="card-title">
                <i class="fas fa-file-alt"></i>
                Relatório de Fornecedores
            </h5>
            <p class="card-text">Relatório com as informações de cada fornecedor do sistema, incluindo nome, CNPJ, endereço e outros dados.</p>
            <div class="report-actions">
                <a href="<?= url("app/pdf-r-f") ?>" class="btn btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </a>
                <a href="<?= url("app/excel-r-f") ?>" class="btn btn-report btn-excel">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </a>
            </div>
        </div>
    </div>

    <div class="report-card">
        <div class="card-body">
            <i class="fas fa-box report-icon"></i>
            <h5 class="card-title">
                <i class="fas fa-file-alt"></i>
                Relatório de Produtos
            </h5>
            <p class="card-text">Relatório com as informações de cada produto do sistema, incluindo nome, preço, descrição e outros detalhes.</p>
            <div class="report-actions">
                <a href="<?= url("app/pdf-r-p") ?>" class="btn btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </a>
                <a href="<?= url("app/excel-r-p") ?>" class="btn btn-report btn-excel">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </a>
            </div>
        </div>
    </div>
</div>