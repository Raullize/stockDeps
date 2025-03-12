<?php
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/fornecedores.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>
    <div class="container-fluid mt-4">
        <!-- Header com animação sutil e destaque -->
        <div class="dashboard-header mb-4 p-4 bg-white shadow-sm rounded-3">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fw-bold display-6 mb-2 text-gradient"><i class="fas fa-truck-fast me-2"></i>Fornecedores</h1>
                    <p class="text-muted fs-5 fw-light">Gerencie os fornecedores do sistema</p>
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
                        <div class="headerTabelaFornecedores p-2 mb-3">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarFornecedor" id="adicionarFornecedorBtn">
                                    <i class="fas fa-plus-circle"></i> Adicionar Fornecedor
                                </button>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div class="search-box">
                                    <input type="text" name="buscarFornecedor" class="search-input" id="buscarFornecedor" placeholder="Procurar fornecedor">
                                </div>
                            </div>
                        </div>
                        <div id="semResultadosFornecedores" class="alert alert-info text-center d-none">
                            <i class="fas fa-info-circle me-2"></i>Nenhum fornecedor encontrado com o termo pesquisado.
                        </div>
                        <div class="table-responsive">
                            <table id="tabelaFornecedores" class="table table-bordered table-striped">
                                <thead class="sticky-top bg-white">
                                    <tr>
                                        <th id="ordenarNomeFornecedor">Nome <span class="seta" id="setaNomeFornecedor">⬍</span></th>
                                        <th id="ordenarCnpjFornecedor">CNPJ</th>
                                        <th id="ordenarEmailFornecedor">Email</th>
                                        <th id="ordenarTelefoneFornecedor">Telefone</th>
                                        <th id="ordenarEnderecoFornecedor">Endereço</th>
                                        <th id="ordenarMunicipioFornecedor">Município</th>
                                        <th id="ordenarCepFornecedor">CEP</th>
                                        <th id="ordenarUfFornecedor">UF</th>
                                        <th id="acoesFornecedores" class="text-center">Ações</th>
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
                    <ul class="pagination justify-content-center" id="paginacaoFornecedores"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Fornecedor -->
    <div class="modal fade" id="modalAdicionarFornecedor" tabindex="-1" aria-labelledby="modalAdicionarFornecedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAdicionarFornecedorLabel">
                        <i class="fas fa-truck-loading me-2"></i>Adicionar Fornecedor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAdicionarFornecedor">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomeFornecedor" class="form-label">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-building"></i>
                                        </span>
                                        <input name="nome" type="text" class="form-control" id="nomeFornecedor" placeholder="Digite o nome do fornecedor">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cnpjFornecedor" class="form-label">CNPJ</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input name="cnpj" type="text" class="form-control" id="cnpjFornecedor" maxlength="18" placeholder="Digite o CNPJ do fornecedor" oninput="formatarCNPJ(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailFornecedor" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input name="email" type="email" class="form-control" id="emailFornecedor" placeholder="Digite o email do fornecedor">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefoneFornecedor" class="form-label">Telefone</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input name="telefone" type="text" class="form-control" id="telefoneFornecedor" placeholder="Digite o telefone do fornecedor" oninput="formatarTelefone(event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input name="endereco" type="text" class="form-control" id="endereco" placeholder="Digite o endereço">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="municipioFornecedor" class="form-label">Município</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-city"></i>
                                        </span>
                                        <input name="municipio" type="text" class="form-control" id="municipioFornecedor" placeholder="Digite o município">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cepFornecedor" class="form-label">CEP</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-map-pin"></i>
                                        </span>
                                        <input name="cep" type="text" class="form-control" id="cepFornecedor" placeholder="Digite o CEP" oninput="formatarCEP(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ufFornecedor" class="form-label">UF</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-map"></i>
                                        </span>
                                        <select name="uf" class="form-control" id="ufFornecedor" placeholder="Digite a UF">
                                            <option value="" disabled selected>Selecione o estado</option>
                                            <option value="AC">Acre (AC)</option>
                                            <option value="AL">Alagoas (AL)</option>
                                            <option value="AP">Amapá (AP)</option>
                                            <option value="AM">Amazonas (AM)</option>
                                            <option value="BA">Bahia (BA)</option>
                                            <option value="CE">Ceará (CE)</option>
                                            <option value="DF">Distrito Federal (DF)</option>
                                            <option value="ES">Espírito Santo (ES)</option>
                                            <option value="GO">Goiás (GO)</option>
                                            <option value="MA">Maranhão (MA)</option>
                                            <option value="MT">Mato Grosso (MT)</option>
                                            <option value="MS">Mato Grosso do Sul (MS)</option>
                                            <option value="MG">Minas Gerais (MG)</option>
                                            <option value="PA">Pará (PA)</option>
                                            <option value="PB">Paraíba (PB)</option>
                                            <option value="PR">Paraná (PR)</option>
                                            <option value="PE">Pernambuco (PE)</option>
                                            <option value="PI">Piauí (PI)</option>
                                            <option value="RJ">Rio de Janeiro (RJ)</option>
                                            <option value="RN">Rio Grande do Norte (RN)</option>
                                            <option value="RS">Rio Grande do Sul (RS)</option>
                                            <option value="RO">Rondônia (RO)</option>
                                            <option value="RR">Roraima (RR)</option>
                                            <option value="SC">Santa Catarina (SC)</option>
                                            <option value="SP">São Paulo (SP)</option>
                                            <option value="SE">Sergipe (SE)</option>
                                            <option value="TO">Tocantins (TO)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Fornecedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditarFornecedor" tabindex="-1" aria-labelledby="modalEditarFornecedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarFornecedorLabel">
                        <i class="fas fa-edit me-2"></i>Editar Fornecedor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarFornecedor" name="formEditarFornecedor" method="post" class="p-3">
                    <div class="modal-body p-4">
                        <input name="idFornecedorEditar" type="hidden" id="editarFornecedorId">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="editarFornecedorNome" class="form-label">Nome</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input name="nome" type="text" id="editarFornecedorNome" class="form-control" placeholder="Nome do fornecedor">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="editarFornecedorCnpj" class="form-label">CNPJ</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input name="cnpj" type="text" id="editarFornecedorCnpj" class="form-control" placeholder="00.000.000/0000-00" oninput="formatarCNPJ(event)">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editarFornecedorEmail" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input name="email" type="email" id="editarFornecedorEmail" class="form-control" placeholder="email@exemplo.com">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editarFornecedorTelefone" class="form-label">Telefone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input name="telefone" type="text" id="editarFornecedorTelefone" class="form-control" placeholder="(00) 00000-0000" oninput="formatarTelefone(event)">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editarFornecedorEndereco" class="form-label">Endereço</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input name="endereco" type="text" id="editarFornecedorEndereco" class="form-control" placeholder="Rua, número, bairro">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editarFornecedorMunicipio" class="form-label">Município</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                    <input name="municipio" type="text" id="editarFornecedorMunicipio" class="form-control" placeholder="Nome da cidade">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="editarFornecedorCep" class="form-label">CEP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                    <input name="cep" type="text" id="editarFornecedorCep" class="form-control" placeholder="00000-000" oninput="formatarCEP(event)">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="editarUfFornecedor" class="form-label">UF</label>
                                <select name="uf" class="form-select" id="editarUfFornecedor">
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="AC">Acre (AC)</option>
                                    <option value="AL">Alagoas (AL)</option>
                                    <option value="AP">Amapá (AP)</option>
                                    <option value="AM">Amazonas (AM)</option>
                                    <option value="BA">Bahia (BA)</option>
                                    <option value="CE">Ceará (CE)</option>
                                    <option value="DF">Distrito Federal (DF)</option>
                                    <option value="ES">Espírito Santo (ES)</option>
                                    <option value="GO">Goiás (GO)</option>
                                    <option value="MA">Maranhão (MA)</option>
                                    <option value="MT">Mato Grosso (MT)</option>
                                    <option value="MS">Mato Grosso do Sul (MS)</option>
                                    <option value="MG">Minas Gerais (MG)</option>
                                    <option value="PA">Pará (PA)</option>
                                    <option value="PB">Paraíba (PB)</option>
                                    <option value="PR">Paraná (PR)</option>
                                    <option value="PE">Pernambuco (PE)</option>
                                    <option value="PI">Piauí (PI)</option>
                                    <option value="RJ">Rio de Janeiro (RJ)</option>
                                    <option value="RN">Rio Grande do Norte (RN)</option>
                                    <option value="RS">Rio Grande do Sul (RS)</option>
                                    <option value="RO">Rondônia (RO)</option>
                                    <option value="RR">Roraima (RR)</option>
                                    <option value="SC">Santa Catarina (SC)</option>
                                    <option value="SP">São Paulo (SP)</option>
                                    <option value="SE">Sergipe (SE)</option>
                                    <option value="TO">Tocantins (TO)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSalvarEdicao">
                            <i class="fas fa-check me-2"></i>Salvar Alterações
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
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Fornecedor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="fornecedor-excluir" name="fornecedor-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir este fornecedor?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Atenção:</strong> Ao confirmar, todas as entradas, compras e outros registros relacionados a ele também serão removidos.
                        </div>
                        <input type="hidden" id="idFornecedorExcluir" name="idFornecedorExcluir">
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger px-4" id="confirmarExcluir">
                            <i class="fas fa-trash-alt me-2"></i>Confirmar Exclusão
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Histórico -->
    <div class="modal fade" id="modalHistoricoFornecedor" tabindex="-1" aria-labelledby="modalHistoricoFornecedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalHistoricoFornecedorLabel">
                        <i class="fas fa-history me-2"></i>Histórico de Compras
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="historicoFornecedor" class="mt-2"></div>
                    <div id="semHistoricoFornecedor" class="alert alert-info text-center d-none">
                        <i class="fas fa-info-circle me-2"></i>Nenhuma compra registrada para este fornecedor.
                    </div>
                    <div class="table-responsive mt-3">
                        <table id="tabelaHistoricoFornecedor" class="table table-bordered table-striped d-none">
                            <thead class="sticky-top bg-white">
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Linhas serão inseridas dinamicamente aqui -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <nav>
                            <ul class="pagination justify-content-center" id="paginacaoHistoricoFornecedor"></ul>
                        </nav>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= url('assets/app/js/fornecedores.js') ?>"></script>
    <script src="<?= url('assets/app/js/formsCreate.js') ?>" async></script>
    <script src="<?= url('assets/app/js/formsDelete.js') ?>" async></script>
    <script src="<?= url('assets/app/js/formsUpdate.js') ?>" async></script>
    <script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>" ></script>
</body>

</html>