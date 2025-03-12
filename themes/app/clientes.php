<?php
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/clientes.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>
    <div class="container-fluid mt-4">
        <!-- Header com animação sutil e destaque -->
        <div class="dashboard-header mb-4 p-4 bg-white shadow-sm rounded-3">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fw-bold display-6 mb-2 text-gradient"><i class="fas fa-users me-2"></i>Clientes</h1>
                    <p class="text-muted fs-5 fw-light">Gerencie os clientes do sistema</p>
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

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="headerTabelaClientes p-2 mb-3">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarCliente" id="adicionarClienteBtn">
                                    <i class="fas fa-user-plus"></i> Adicionar Cliente
                                </button>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div class="search-box">
                                    <input type="text" name="buscarCliente" class="search-input" id="buscarCliente" placeholder="Procurar cliente">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="tabelaClientes" class="table table-bordered table-striped">
                                <thead class="sticky-top bg-white">
                                    <tr>
                                        <th id="ordenarNomeCliente">Nome <span class="seta" id="setaNomeCliente">⬍</span></th>
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
                <nav>
                    <ul class="pagination justify-content-center" id="paginacaoClientes"></ul>
                </nav>
            </div>
        </div>
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
                    <div class="modal-body p-4">
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
                    <div class="modal-body p-4">
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

    <!-- Modal Histórico Cliente -->
    <div class="modal fade" id="modalHistoricoCliente" tabindex="-1" aria-labelledby="modalHistoricoClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalHistoricoClienteLabel">
                        <i class="fas fa-history me-2"></i>Histórico de Compras
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="historicoCliente" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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