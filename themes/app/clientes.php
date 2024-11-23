<?php
$this->layout("_theme");

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/clientes.css') ?>">

<body>

    <h1 class="mt-2 text-center">
        Clientes
    </h1>

    <div class="container-fluid mt-2">
        <div class="row justify-content-center">
            <div class="tabelaClientes">
                <div class="headerTabelaClientes p-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarCliente" id="adicionarClienteBtn">
                        Adicionar Cliente
                    </button>
                    <div>
                        <label for="buscarCliente" class="text-light px-2">Procurar cliente:</label>
                        <input type="text" name="buscarCliente" id="buscarCliente" placeholder="Procurar cliente" class="form-control">
                    </div>
                </div>
                <table id="tabelaClientes" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Celular</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Linhas serão inseridas dinamicamente aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAIS -->

    <!-- Modal Adicionar Cliente -->
    <div class="modal fade" id="modalAdicionarCliente" tabindex="-1" aria-labelledby="modalAdicionarClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Aumentando a largura do modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarClienteLabel">Adicionar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cadastro-clientes" name="cadastro-clientes" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome</label>
                            <input name="nome" type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome do cliente">
                        </div>
                        <div class="mb-3">
                            <label for="cpfCliente" class="form-label">CPF</label>
                            <input name="cpf" type="text" class="form-control" id="cpfCliente" placeholder="Digite o CPF do cliente" maxlength="14" oninput="formatarCPF(event)">
                        </div>
                        <div class="mb-3">
                            <label for="telefoneCliente" class="form-label">Celular</label>
                            <input name="celular" type="text" class="form-control" id="telefoneCliente" placeholder="Digite o celular do cliente">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarCliente">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editarNomeCliente" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="editarNomeCliente">
                        </div>
                        <div class="mb-3">
                            <label for="editarCpfCliente" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="editarCpfCliente">
                        </div>
                        <div class="mb-3">
                            <label for="editarTelefoneCliente" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="editarTelefoneCliente">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHistoricoCliente" tabindex="-1" aria-labelledby="modalHistoricoClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistoricoClienteLabel">Histórico de Compras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="historicoCliente"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= url('assets/app/js/clientes.js') ?>" defer></script>
    <script src="<?= url('assets/app/js/formsBackEnd.js') ?>" async></script>
    <script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>"></script>

</body>

</html>