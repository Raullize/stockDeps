<?php 
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/relatorio.css') ?>">

<style>
/* Solução específica para alinhar o título à esquerda */
.card-title {
  text-align: left !important;
  margin: 0 !important;
  padding: 0 !important;
  float: left !important;
  width: 100% !important;
}
.card-header {
  display: block !important;
  text-align: left !important;
}
.justify-content-center {
  justify-content: flex-start !important;
}

/* Estilo para o feedback de download */
.download-feedback {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    animation: slideIn 0.3s ease forwards;
    display: flex;
    align-items: center;
    font-weight: 500;
}

@keyframes slideIn {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.download-feedback.fade-out {
    animation: fadeOut 0.5s ease forwards;
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
        transform: translateY(20px);
    }
}
</style>

<body>
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title text-primary fw-bold mb-0" style="text-align: left !important; display: block !important; width: 100% !important;">
                            <i class="fas fa-chart-line me-2"></i>Gestão de Relatórios
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="p-3 bg-light rounded mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Versão Beta:</strong> Esta funcionalidade está em desenvolvimento. Por enquanto, apenas os relatórios de Clientes, Fornecedores e Produtos estão disponíveis para exportação em PDF.
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <div class="dropdown me-2">
                                    <button class="btn btn-primary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <span>Exportar Relatório</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= url("app/pdf-r-c") ?>"><i class="fas fa-users me-2"></i>Relatório de Clientes</a></li>
                                        <li><a class="dropdown-item" href="<?= url("app/pdf-r-f") ?>"><i class="fas fa-building me-2"></i>Relatório de Fornecedores</a></li>
                                        <li><a class="dropdown-item" href="<?= url("app/pdf-r-p") ?>"><i class="fas fa-box me-2"></i>Relatório de Produtos</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item disabled" href="#"><i class="fas fa-boxes-stacked me-2"></i>Relatório de Estoque (Em breve)</a></li>
                                        <li><a class="dropdown-item disabled" href="#"><i class="fas fa-chart-line me-2"></i>Análise Financeira (Em breve)</a></li>
                                    </ul>
                                </div>
                                <div class="input-group" style="max-width: 300px;">
                                    <select class="form-select" id="relatorioTipo">
                                        <option value="0">Selecione o tipo de relatório</option>
                                        <option value="1">Clientes</option>
                                        <option value="2">Fornecedores</option>
                                        <option value="3">Produtos</option>
                                        <option value="4" disabled>Estoque (Em breve)</option>
                                        <option value="5" disabled>Financeiro (Em breve)</option>
                                    </select>
                                    <button class="btn btn-light ms-1 border" id="buscarRelatorio">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela de relatórios -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Relatório</th>
                                        <th>Descrição</th>
                                        <th>Registros</th>
                                        <th>Última Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-users text-primary me-2"></i>Relatório de Clientes</td>
                                        <td>Dados cadastrais e histórico de todos os clientes</td>
                                        <td><span class="badge bg-primary">32</span></td>
                                        <td>Hoje às 10:25</td>
                                        <td>
                                            <a href="<?= url("app/pdf-r-c") ?>" class="btn btn-sm btn-danger me-1">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-building text-primary me-2"></i>Relatório de Fornecedores</td>
                                        <td>Cadastro completo de fornecedores e produtos</td>
                                        <td><span class="badge bg-primary">18</span></td>
                                        <td>Hoje às 10:25</td>
                                        <td>
                                            <a href="<?= url("app/pdf-r-f") ?>" class="btn btn-sm btn-danger me-1">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-box text-primary me-2"></i>Relatório de Produtos</td>
                                        <td>Lista detalhada de produtos e estoque</td>
                                        <td><span class="badge bg-primary">156</span></td>
                                        <td>Hoje às 10:25</td>
                                        <td>
                                            <a href="<?= url("app/pdf-r-p") ?>" class="btn btn-sm btn-danger me-1">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="table-light">
                                        <td><i class="fas fa-boxes-stacked text-muted me-2"></i>Relatório de Estoque</td>
                                        <td>Situação atual do estoque e produtos em baixa</td>
                                        <td><span class="badge bg-secondary">145</span></td>
                                        <td>Hoje às 10:25</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="table-light">
                                        <td><i class="fas fa-chart-line text-muted me-2"></i>Análise Financeira</td>
                                        <td>Resumo financeiro com receitas e despesas</td>
                                        <td><span class="badge bg-secondary">6 meses</span></td>
                                        <td>Hoje às 10:25</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary disabled">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer bg-white p-3 d-flex justify-content-end">
                            <div class="alert alert-warning mb-0 me-auto" style="max-width: 600px;">
                                <small>
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <strong>Nota:</strong> As opções de exportação para Excel e os relatórios de Estoque e Financeiro estarão disponíveis nas próximas atualizações.
                                </small>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2">
                                <i class="fas fa-question-circle me-1"></i> Ajuda
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        // Função para buscar relatórios
        $('#buscarRelatorio').click(function() {
            const tipo = $('#relatorioTipo').val();
            if (tipo == 0) {
                alert('Por favor, selecione um tipo de relatório');
                return;
            }
            
            // Apenas os primeiros 3 tipos estão disponíveis
            if (tipo > 3) {
                alert('Este relatório ainda não está disponível na versão beta.');
                return;
            }
            
            // Destacar a linha correspondente na tabela
            $('tbody tr').removeClass('table-primary');
            $('tbody tr').eq(tipo - 1).addClass('table-primary');
        });

        // Resolver o problema do loading infinito ao baixar PDFs
        // Seletor abrangendo tanto os botões da tabela quanto os itens do dropdown
        $('a[href*="pdf-r-"]').on('click', function(e) {
            // Identifica o tipo de relatório
            let tipoRelatorio = "";
            
            // Verificar se é um item do dropdown ou um botão da tabela
            if ($(this).hasClass('dropdown-item')) {
                tipoRelatorio = $(this).text().trim();
            } else {
                tipoRelatorio = $(this).closest('tr').find('td:first').text().trim();
            }
            
            // Mostra um feedback temporário
            const downloadMsg = $('<div class="download-feedback">').html(`<i class="fas fa-file-pdf me-2"></i>Download iniciado: ${tipoRelatorio}`);
            $('body').append(downloadMsg);
            
            // Esconde o overlay de loading após um curto período
            setTimeout(function() {
                $('.loading-overlay').css('display', 'none');
                
                // Remove a mensagem de feedback após alguns segundos
                setTimeout(function() {
                    downloadMsg.addClass('fade-out');
                    setTimeout(function() {
                        downloadMsg.remove();
                    }, 500);
                }, 3000);
            }, 800); // Um pequeno delay para que o usuário possa ver que o processo iniciou
        });
    });
</script>