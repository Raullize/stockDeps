<?php
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/clientes.css') ?>">

<body>
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title text-primary fw-bold mb-0">
                            <i class="fas fa-users me-2"></i>Gestão de Clientes
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="headerTabelaClientes p-3 bg-light rounded mb-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdicionarCliente" id="adicionarClienteBtn">
                                    <i class="fas fa-user-plus me-2"></i>
                                    <span>Adicionar Cliente</span>
                                </button>
                                <div class="d-flex" style="max-width: 300px;">
                                    <input type="text" name="buscarCliente" id="buscarCliente" placeholder="Procurar cliente" class="form-control">
                                    <button class="btn btn-light ms-1 border">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabelaClientes" class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th id="ordenarNomeCliente">Nome <i class="fas fa-sort ms-1" id="setaNomeCliente"></i></th>
                                        <th id="ordenarCpfCliente">CPF</th>
                                        <th id="ordenarCelularCliente">Celular</th>
                                        <th id="acoesClientes" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Linhas serão inseridas dinamicamente aqui -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-center" id="paginationClientes"></ul>
        </nav>
    </div>
    
    <!-- Modal Adicionar Cliente -->
    <div class="modal fade" id="modalAdicionarCliente" tabindex="-1" aria-labelledby="modalAdicionarClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Aumentando a largura do modal -->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAdicionarClienteLabel">
                        <i class="fas fa-user-plus me-2"></i>Adicionar Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cadastro-clientes" name="cadastro-clientes" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome do cliente">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cpfCliente" class="form-label">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input name="cpf" type="text" class="form-control" id="cpfCliente" placeholder="Digite o CPF do cliente" maxlength="14" oninput="formatarCPF(event)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="telefoneCliente" class="form-label">Celular</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <input name="celular" type="text" class="form-control" id="telefoneCliente" placeholder="Digite o celular do cliente">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarClienteLabel">
                        <i class="fas fa-user-edit me-2"></i>Editar Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cliente-update" method="post">
                    <div class="modal-body">
                            <input type="hidden" id="idClienteUpdate" name="idClienteUpdate"> <!-- Campo oculto para armazenar o id -->
                        <div class="mb-3">
                            <label for="editarNomeCliente" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="editarNomeCliente">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editarCpfCliente" class="form-label">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input name="cpf" type="text" class="form-control" id="editarCpfCliente">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editarTelefoneCliente" class="form-label">Celular</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <input name="celular" type="text" class="form-control" id="editarTelefoneCliente">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalExcluirLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cliente-excluir" name="cliente-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir este cliente?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Ao confirmar, todas as vendas, transações e outros registros relacionados a ele também serão removidos.
                        </div>
                        <input type="hidden" id="idClienteExcluir" name="idClienteExcluir"> <!-- Campo oculto para armazenar o id -->
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger px-4" id="confirmarExcluir">
                            <i class="fas fa-trash-alt me-2"></i>Excluir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHistoricoCliente" tabindex="-1" aria-labelledby="modalHistoricoClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalHistoricoClienteLabel">
                        <i class="fas fa-history me-2"></i>Histórico de Compras
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="clienteIdHistorico" value="">
                    
                    <!-- Filtros e Busca -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control" id="filtroDataHistoricoCliente">
                            <button class="btn btn-outline-secondary" type="button" id="filtrarHistoricoClienteBtn">
                                <i class="fas fa-filter"></i>
                            </button>
                            <button class="btn btn-outline-secondary" type="button" id="limparFiltroHistoricoClienteBtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="buscarHistoricoCliente" placeholder="Buscar por produto...">
                        </div>
                    </div>
                    
                    <!-- Tabela de Histórico -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tabelaHistoricoCliente">
                            <thead class="table-light">
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Total</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaHistoricoCliente">
                                <!-- Dados do histórico serão inseridos aqui -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mensagem para quando não houver dados -->
                    <div class="text-center mt-3" id="mensagemNenhumHistoricoCliente" style="display: none;">
                        <p class="text-muted">Nenhum registro de compra encontrado para este cliente.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <nav>
                        <ul class="pagination justify-content-center pagination-sm mb-0" id="paginacaoHistoricoCliente"></ul>
                    </nav>
                    <button type="button" class="btn btn-outline-secondary ms-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= url('assets/app/js/clientes.js') ?>"></script>
    <script src="<?= url('assets/app/js/formsCreate.js') ?>" async></script>
    <script src="<?= url('assets/app/js/formsDelete.js') ?>" async></script>
    <script src="<?= url('assets/app/js/formsUpdate.js') ?>" async></script>
    <script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>"></script>
</body>

</html>