<?php
$this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url('assets/app/css/fornecedores.css') ?>">

<body>

    <h1 class="mt-2 text-center">
        Fornecedores
    </h1>

    <div class="container-fluid mt-2">
        <div class="row justify-content-center">
            <div class="tabelaFornecedores">
                <div class="headerTabelaFornecedores p-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarFornecedor" id="adicionarFornecedorBtn">
                        Adicionar Fornecedor
                    </button>
                    <div>
                        <label for="buscarFornecedor" class="text-light px-2">Procurar fornecedor:</label>
                        <input type="text" name="buscarFornecedor" id="buscarFornecedor" placeholder="Procurar fornecedor" class="form-control">
                    </div>
                </div>
                <table id="tabelaFornecedores" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Email</th>
                            <th>Telefone</th>
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

    <!-- Modal Adicionar Fornecedor -->
    <div class="modal fade" id="modalAdicionarFornecedor" tabindex="-1" aria-labelledby="modalAdicionarFornecedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarFornecedorLabel">Adicionar Fornecedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formAdicionarFornecedor">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeFornecedor" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeFornecedor" placeholder="Digite o nome do fornecedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="cnpjFornecedor" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" id="cnpjFornecedor" placeholder="Digite o CNPJ do fornecedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailFornecedor" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailFornecedor" placeholder="Digite o email do fornecedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefoneFornecedor" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefoneFornecedor" placeholder="Digite o telefone do fornecedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="cidadeFornecedor" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidadeFornecedor" placeholder="Digite a cidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço" required>
                        </div>
                        <div class="mb-3">
                            <label for="bairroFornecedor" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairroFornecedor" placeholder="Digite o bairro" required>
                        </div>
                        <div class="mb-3">
                            <label for="complementoFornecedor" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complementoFornecedor" placeholder="Digite o complemento" required>
                        </div>
                        <div class="mb-3">
                            <label for="municipioFornecedor" class="form-label">Municipio</label>
                            <input type="text" class="form-control" id="municipioFornecedor" placeholder="Digite o municipio" required>
                        </div>
                        <div class="mb-3">
                            <label for="cepFornecedor" class="form-label">CEP</label>
                            <input type="number" class="form-control" id="cepFornecedor" placeholder="Digite o CEP" required>
                        </div>
                        <div class="mb-3">
                            <label for="ufFornecedor" class="form-label">UF</label>
                            <input type="number" class="form-control" id="ufFornecedor" placeholder="Digite a UF" required>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Fornecedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Fornecedor -->
    <div id="modalEditarFornecedor" class="modal">
        <div class="modal-content">
            <h4>Editar Fornecedor</h4>
            <form id="formEditarFornecedor">
                <input type="hidden" id="editarFornecedorId">
                <div>
                    <label for="editarFornecedorNome">Nome</label>
                    <input type="text" id="editarFornecedorNome">
                </div>
                <div>
                    <label for="editarFornecedorCnpj">CNPJ</label>
                    <input type="text" id="editarFornecedorCnpj">
                </div>
                <div>
                    <label for="editarFornecedorEmail">Email</label>
                    <input type="email" id="editarFornecedorEmail">
                </div>
                <div>
                    <label for="editarFornecedorTelefone">Telefone</label>
                    <input type="text" id="editarFornecedorTelefone">
                </div>
                <div>
                    <label for="editarFornecedorCidade">Cidade</label>
                    <input type="text" id="editarFornecedorCidade">
                </div>
                <div>
                    <label for="editarFornecedorLogradouro">Logradouro</label>
                    <input type="text" id="editarFornecedorLogradouro">
                </div>
                <div>
                    <label for="editarFornecedorNumero">Número</label>
                    <input type="text" id="editarFornecedorNumero">
                </div>
                <button type="submit">Salvar</button>
            </form>
            <button onclick="fecharModal()">Fechar</button>
        </div>
    </div>


    <script src="<?= url('assets/app/js/fornecedores.js') ?>" defer></script>
</body>

</html>