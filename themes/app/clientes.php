<?php
$this->layout("_theme");

?>

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
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th>UF</th>
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
                <form id="formAdicionarCliente">
                    <div class="modal-body">
                        <!-- Primeira parte: Dados do Cliente -->
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome do cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="cpfCliente" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpfCliente" placeholder="Digite o CPF do cliente" required maxlength="14" oninput="formatarCPF(event)">
                        </div>
                        <div class="mb-3">
                            <label for="emailCliente" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailCliente" placeholder="Digite o email do cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefoneCliente" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefoneCliente" placeholder="Digite o telefone do cliente" required>
                        </div>

                        <hr> <!-- Separador entre os dois formulários -->

                        <!-- Segunda parte: Endereço do Cliente -->
                        <h5>Endereço do Cliente</h5>
                        <div class="mb-3">
                            <label for="logradouroCliente" class="form-label">Logradouro</label>
                            <input type="text" class="form-control" id="logradouroCliente" placeholder="Digite o logradouro" required>
                        </div>
                        <div class="mb-3">
                            <label for="numeroCliente" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numeroCliente" placeholder="Digite o número" required>
                        </div>
                        <div class="mb-3">
                            <label for="cidadeCliente" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidadeCliente" placeholder="Digite a cidade" required>
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
                            <input type="text" class="form-control" id="editarNomeCliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarEmailCliente" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editarEmailCliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarTelefoneCliente" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="editarTelefoneCliente">
                        </div>
                        <div class="mb-3">
                            <label for="editarEnderecoCliente" class="form-label">Endereço</label>
                            <textarea class="form-control" id="editarEnderecoCliente"></textarea>
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



</body>

</html>