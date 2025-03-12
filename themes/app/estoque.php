<?php
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/estoque.css') ?>">
<!-- FontAwesome (Ícones) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<body>
    <div class="container-fluid mt-4">
        <!-- Header com animação sutil e destaque -->
        <div class="dashboard-header mb-4 p-4 bg-white shadow-sm rounded-3">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="fw-bold display-5 mb-2 text-gradient"><i class="fas fa-boxes me-2"></i>Produtos</h1>
                    <p class="text-muted fs-5 fw-light">Gerencie o estoque do sistema</p>
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
                        <div class="headerTabelaProdutos p-2 mb-3">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto" id="adicionarProdutoBtn">
                                    <i class="fas fa-plus-circle"></i> Adicionar Produto
                                </button>
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTabelaCategorias" id="adicionarCategoriaBtn">
                                    <i class="fas fa-tags"></i> Gerenciar Categorias
                                </button>
                                <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarDANFE">
                                    <i class="fas fa-file-invoice"></i> Adicionar Notas
                                </button>
                                <button class="btn btn-info d-flex align-items-center gap-2" id="consultarEntradasBtn">
                                    <i class="fas fa-arrow-circle-down"></i> Consultar Entradas
                                </button>
                                <button class="btn btn-info d-flex align-items-center gap-2" id="consultarSaidasBtn">
                                    <i class="fas fa-arrow-circle-up"></i> Consultar Saídas
                                </button>
                            </div>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="buscarProduto" class="search-input" id="buscarProduto" placeholder="Procurar produto">
                                </div>
                                <div class="filter-box">
                                    <i class="fas fa-filter"></i>
                                    <select id="categoria" name="categoria" class="filter-select"></select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="sticky-top bg-white">
                                    <tr>
                                        <th id="ordenarCodigo">Código <span class="seta" id="setaCodigo">⬍</span></th>
                                        <th id="ordenarNome">Nome <span class="seta" id="setaNome">⬍</span></th>
                                        <th id="ordenarDescricao">Descrição</th>
                                        <th id="ordenarPreco">Preço <span class="seta" id="setaPreco">⬍</span></th>
                                        <th id="ordenarQuantidade">Quantidade <span class="seta" id="setaQuantidade">⬍</span></th>
                                        <th id="ordenarUnidade">Unidade</th>
                                        <th id="ordernarStatus">Status</th>
                                        <th id="acoesProdutos" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="corpoTabela">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <nav>
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- MODAIS -->

    <!-- Modal Adicionar Produto -->
    <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarProdutoLabel"><i class="fas fa-plus-circle me-2"></i>Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="produto-cadastro" name="produto-cadastro" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigoProdutoAdicionar" class="form-label">Código do Produto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input name="codigo_produto" type="text" class="form-control" id="codigoProdutoAdicionar" placeholder="Digite o código do produto">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="categoriaProdutoAdicionar" class="form-label">Categoria</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                    <select name="categoria" class="form-control" id="categoriaProdutoAdicionar" required>
                                        <option value="" selected disabled>Escolher Categoria</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nomeProdutoAdicionar" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input name="nome" type="text" class="form-control" id="nomeProdutoAdicionar" placeholder="Digite o nome do produto">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descricaoProdutoAdicionar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="descricao" class="form-control" id="descricaoProdutoAdicionar" rows="3" placeholder="Digite a descrição do produto"></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precoSaidaProdutoAdicionar" class="form-label">Preço para Saídas</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input
                                        name="preco"
                                        type="text"
                                        class="form-control preco"
                                        id="precoSaidaProdutoAdicionar"
                                        value="R$ 0,00"
                                        oninput="formatarPreco(this)">
                                </div>
                                <small id="precoHelp" class="form-text text-muted">Ex: R$ 1.000,00</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="unidadeProdutoAdicionar" class="form-label">Unidade de Medida</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <select name="unidade" class="form-control" id="unidadeProdutoAdicionar" required>
                                        <option value="" selected disabled>Selecionar Unidade</option>
                                        <option value="KG">Quilograma (kg)</option>
                                        <option value="UN">Unidade (un)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fotoProdutoAdicionar" class="form-label">Foto do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                <input name="image" type="file" id="fotoProdutoAdicionar" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="salvarProduto"><i class="fas fa-save me-1"></i>Salvar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Produto -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel"><i class="fas fa-edit me-2"></i>Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="produto-update" name="produto-update" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="idProdutoUpdate" id="idProdutoUpdate">
                        <div class="mb-3">
                            <label for="codigoProdutoEditar" class="form-label">Código do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                <input name="codigo_produto" type="text" class="form-control" id="codigoProdutoEditar" placeholder="Digite o código do produto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input name="nome" type="text" id="nomeProduto" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoProduto" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="descricao" id="descricaoProduto" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaProdutoEditar" class="form-label">Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                <select name="categoria" class="form-control" id="categoriaProdutoEditar" required>
                                    <option value="" disabled>Escolher Categoria</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precoProduto" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input name="preco" type="text" class="form-control preco" id="precoProduto" value="R$ 0,00" oninput="formatarPreco(this)">
                            </div>
                            <small id="precoHelp" class="form-text text-muted">Digite o valor do produto com separação de milhar (ex: R$ 1.000,00).</small>
                        </div>
                        <div class="mb-3">
                            <label for="unidadeProdutoEditar" class="form-label">Unidade de Medida</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                <select name="unidade" class="form-control" id="unidadeProdutoEditar" required>
                                    <option value="" disabled>Selecionar Unidade de Medida</option>
                                    <option value="KG">Quilograma (kg)</option>
                                    <option value="UN">Unidade (un)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fotoProduto" class="form-label">Foto do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                <input name="image" type="file" id="fotoProduto" class="form-control">
                            </div>
                            <img id="previewImagem" src="" alt="Imagem do Produto" style="max-width: 150px; display: none; margin:10px auto; display: block;">
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

    <!-- Modal com a tabela de categorias -->
    <div class="modal fade" id="modalTabelaCategorias" tabindex="-1" aria-labelledby="modalTabelaCategoriasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTabelaCategoriasLabel"><i class="fas fa-tags me-2"></i>Gerenciar Categorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Botão para adicionar uma nova categoria -->
                        <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarCategoria">
                            <i class="fas fa-plus-circle"></i> Adicionar Categoria
                        </button>
                    </div>
                    
                    <!-- Tabela de categorias -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tabelaCategorias">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Nome</th>
                                    <th style="width: 50%">Descrição</th>
                                    <th style="width: 20%" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaCategorias">
                                <!-- As categorias serão inseridas aqui dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Categoria -->
    <div class="modal fade" id="modalAdicionarCategoria" tabindex="-1" aria-labelledby="modalAdicionarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarCategoriaLabel"><i class="fas fa-plus-circle me-2"></i>Adicionar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoria-cadastro" name="categoria-cadastro" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCategoriaAdicionar" class="form-label">Nome da Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input name="nome" type="text" class="form-control" id="nomeCategoriaAdicionar" placeholder="Digite o nome da categoria" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCategoriaAdicionar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="descricao" class="form-control" id="descricaoCategoriaAdicionar" rows="3" placeholder="Digite a descrição da categoria"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-success" id="salvarCategoria"><i class="fas fa-save me-1"></i>Salvar Categoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoria -->
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarCategoriaLabel"><i class="fas fa-edit me-2"></i>Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoria-editar" name="categoria-editar" method="post">
                    <div class="modal-body">
                        <input name="idCategoriaEditar" id="idCategoriaEditar" type="hidden">
                        <div class="mb-3">
                            <label for="nomeCategoriaEditar" class="form-label">Nome da Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input name="nome" type="text" class="form-control" id="nomeCategoriaEditar" placeholder="Digite o nome da categoria" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCategoriaEditar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="descricao" class="form-control" id="descricaoCategoriaEditar" rows="3" placeholder="Digite a descrição da categoria"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="salvarEdicaoCategoria"><i class="fas fa-save me-1"></i>Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Categoria -->
    <div class="modal fade" id="modalExcluirCategoria" tabindex="-1" aria-labelledby="modalExcluirCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExcluirCategoriaLabel"><i class="fas fa-trash-alt me-2"></i>Excluir Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="categoria-excluir" name="categoria-excluir" method="post">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-exclamation-triangle fa-4x"></i>
                            </div>
                            <h5>Tem certeza de que deseja excluir esta categoria?</h5>
                            <p class="text-muted">Esta ação pode afetar produtos associados a esta categoria.</p>
                            <p class="text-muted"><strong>Esta operação não pode ser desfeita!</strong></p>
                        </div>
                        <input type="hidden" id="idCategoriaExcluir" name="idCategoriaExcluir">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-danger" id="confirmarExcluirCategoria"><i class="fas fa-trash-alt me-1"></i>Confirmar Exclusão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Produto -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExcluirLabel"><i class="fas fa-trash-alt me-2"></i>Excluir Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="produto-excluir" name="produto-excluir" method="post">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="mb-3 text-danger">
                                <i class="fas fa-exclamation-triangle fa-4x"></i>
                            </div>
                            <h5>Tem certeza de que deseja excluir este produto?</h5>
                            <p class="text-muted">Ao confirmar, todas as entradas e saídas relacionadas a ele também serão removidas.</p>
                            <p class="text-muted"><strong>Esta operação não pode ser desfeita!</strong></p>
                        </div>
                        <input type="hidden" id="idProdutoExcluir" name="idProdutoExcluir">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-danger" id="confirmarExcluir"><i class="fas fa-trash-alt me-1"></i>Confirmar Exclusão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            
    <!-- Modal Adicionar Nota -->
    <div class="modal fade" id="modalAdicionarDANFE" tabindex="-1" aria-labelledby="modalAdicionarDANFELabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarDANFELabel"><i class="fas fa-file-invoice me-2"></i>Adicionar Nota DANFE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="processarXmlNota" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="upload-icon mb-3">
                                <i class="fas fa-file-upload fa-4x text-primary"></i>
                            </div>
                            <p class="lead">Faça upload do arquivo XML da nota fiscal</p>
                            <p class="text-muted">O sistema importará automaticamente os produtos e suas informações</p>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                <input type="file" id="arquivoNota" name="arquivoNota" class="form-control" accept=".xml" required>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Apenas arquivos no formato XML são aceitos
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i>Processar Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Entrada -->
    <div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="modalEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEntradaLabel"><i class="fas fa-arrow-circle-down me-2"></i>Adicionar Entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="entrada-cadastro" name="entrada-cadastro" method="post">
                    <div class="modal-body">
                        <input name="produtoId" type="hidden" id="produtoId" value=""> <!-- Campo oculto para armazenar o id -->
                        
                        <div class="mb-3 position-relative">
                            <label for="fornecedor" class="form-label">Fornecedor</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-truck"></i></span>
                                <input name="nome" type="text" class="form-control" id="fornecedor" placeholder="Digite o nome do fornecedor" required>
                            </div>
                            <div class="list-group mt-1 position-absolute w-100" id="fornecedor-lista" style="display: none; z-index: 1050;"></div>
                            <small class="form-text text-muted">Comece a digitar para ver sugestões de fornecedores cadastrados</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input name="quantidade" type="text" class="form-control" id="quantidade" placeholder="Digite a quantidade" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="precoEntrada" class="form-label">Preço</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input
                                        name="preco"
                                        type="text"
                                        class="form-control preco"
                                        id="precoEntrada"
                                        value="R$ 0,00"
                                        oninput="formatarPreco(this)"
                                        required>
                                </div>
                                <small class="form-text text-muted">Ex: R$ 1.000,00</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-success" id="salvarEntrada"><i class="fas fa-save me-1"></i>Salvar Entrada</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Saída -->
    <div class="modal fade" id="modalSaida" tabindex="-1" aria-labelledby="modalSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSaidaLabel"><i class="fas fa-arrow-circle-up me-2"></i>Adicionar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saida-cadastro" name="saida-cadastro" method="post">
                    <div class="modal-body">
                        <input name="produtoId2" type="hidden" id="produtoId2" value=""> <!-- Campo oculto para armazenar o id -->
                        <input name="cliente_nao_cadastrado" type="hidden" id="cliente_nao_cadastrado_valor" value="0"> <!-- Campo oculto para status do checkbox -->
                        
                        <!-- Campo Cliente -->
                        <div class="mb-3 position-relative">
                            <label for="cliente" class="form-label">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input name="nome" type="text" class="form-control" id="cliente" placeholder="Digite o nome do cliente">
                            </div>
                            <div class="list-group mt-1 position-absolute w-100" id="clientes-lista" style="display: none; z-index: 1050;"></div>
                            
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="clienteNaoCadastrado">
                                <label class="form-check-label" for="clienteNaoCadastrado">Cliente não cadastrado</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Campo Quantidade -->
                            <div class="col-md-6 mb-3">
                                <label for="quantidadeSaida" class="form-label">Quantidade</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input name="quantidade" type="text" class="form-control" id="quantidadeSaida" placeholder="Digite a quantidade" required>
                                </div>
                            </div>
                            
                            <!-- Campo Preço -->
                            <div class="col-md-6 mb-3">
                                <label for="precoSaida" class="form-label">Preço</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input
                                        min="0"
                                        name="preco"
                                        type="text"
                                        class="form-control preco"
                                        id="precoSaida"
                                        value="R$ 0,00"
                                        oninput="formatarPreco(this)"
                                        required>
                                </div>
                                <small class="form-text text-muted">Ex: R$ 1.000,00</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botões -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-warning" id="salvarSaida"><i class="fas fa-save me-1"></i>Salvar Saída</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Entradas -->
    <div class="modal fade" id="entradasModal" tabindex="-1" aria-labelledby="entradasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entradasModalLabel"><i class="fas fa-arrow-circle-down me-2"></i>Consulta de Entradas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body bg-light">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label for="filtroDataEntrada" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Filtrar por data:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" id="filtroDataEntrada" class="form-control" onchange="filtrarEntradasPorData()" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="buscarEntrada" class="form-label"><i class="fas fa-search me-1"></i>Buscar entrada:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" name="buscarEntrada" class="form-control" id="buscarEntrada" placeholder="Fornecedor ou produto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaEntradas">
                            <thead class="table-light">
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                    <!-- Navegação de Paginação para Entradas -->
                    <nav aria-label="Paginação de entradas">
                        <ul class="pagination justify-content-center mt-3" id="paginacaoEntradas">
                            <!-- Botões de Paginação serão gerados aqui -->
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Entradas -->
    <div class="modal fade" id="modalEditarEntrada" tabindex="-1" aria-labelledby="modalEditarEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarEntradaLabel"><i class="fas fa-edit me-2"></i>Editar Entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="entrada-editar" method="post">
                    <div class="modal-body">
                        <input name="idEntradaEditar" id="idEntradaEditar" type="hidden">
                        
                        <!-- Nome do Produto -->
                        <div class="mb-3">
                            <label for="entradaProduto" class="form-label">Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                <input name="nome" type="text" class="form-control" id="entradaProduto" readonly>
                            </div>
                            <small class="form-text text-muted">O produto não pode ser alterado</small>
                        </div>

                        <div class="row">
                            <!-- Quantidade -->
                            <div class="col-md-6 mb-3">
                                <label for="entradaQuantidade" class="form-label">Quantidade</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input name="quantidade" type="text" class="form-control" id="entradaQuantidade" required>
                                </div>
                            </div>

                            <!-- Preço -->
                            <div class="col-md-6 mb-3">
                                <label for="entradaPreco" class="form-label">Preço</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input name="preco" type="text" class="form-control preco" id="entradaPreco" oninput="formatarPreco(this)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Entrada -->
    <div class="modal fade" id="modalExcluirEntrada" tabindex="-1" aria-labelledby="modalExcluirEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExcluirEntradaLabel"><i class="fas fa-trash-alt me-2"></i>Excluir Entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="entrada-excluir" method="post">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-exclamation-triangle fa-4x"></i>
                            </div>
                            <h5>Tem certeza de que deseja excluir esta entrada?</h5>
                            <p class="text-muted">Esta ação não poderá ser desfeita e afetará o estoque do produto.</p>
                        </div>
                        <input type="hidden" id="idEntradaExcluir" name="idEntradaExcluir">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i>Confirmar Exclusão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Saídas -->
    <div class="modal fade" id="saidasModal" tabindex="-1" aria-labelledby="saidasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saidasModalLabel"><i class="fas fa-arrow-circle-up me-2"></i>Consulta de Saídas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body bg-light">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label for="filtroDataSaida" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Filtrar por data:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" id="filtroDataSaida" class="form-control" onchange="filtrarSaidasPorData()" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="buscarSaida" class="form-label"><i class="fas fa-search me-1"></i>Buscar saída:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" name="buscarSaida" class="form-control" id="buscarSaida" placeholder="Cliente ou produto...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaSaidas">
                            <thead class="table-light">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                    <!-- Navegação de Paginação para Saídas -->
                    <nav aria-label="Paginação de saídas">
                        <ul class="pagination justify-content-center mt-3" id="paginacaoSaidas">
                            <!-- Botões de Paginação serão gerados aqui -->
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Saidas -->
    <div class="modal fade" id="modalEditarSaida" tabindex="-1" aria-labelledby="modalEditarSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarSaidaLabel"><i class="fas fa-edit me-2"></i>Editar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saida-editar" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="idEditarSaida" id="idEditarSaida">
                        
                        <!-- Nome do Produto (Somente leitura) -->
                        <div class="mb-3">
                            <label for="saidaProduto" class="form-label">Produto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                <input type="text" class="form-control" id="saidaProduto" readonly>
                            </div>
                            <small class="form-text text-muted">O produto não pode ser alterado</small>
                        </div>

                        <div class="row">
                            <!-- Quantidade -->
                            <div class="col-md-6 mb-3">
                                <label for="saidaQuantidade" class="form-label">Quantidade</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input name="quantidade" type="text" class="form-control" id="saidaQuantidade" required>
                                </div>
                            </div>

                            <!-- Preço -->
                            <div class="col-md-6 mb-3">
                                <label for="saidaPreco" class="form-label">Preço</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input name="preco" type="text" class="form-control preco" id="saidaPreco" oninput="formatarPreco(this)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Saída -->
    <div class="modal fade" id="modalExcluirSaida" tabindex="-1" aria-labelledby="modalExcluirSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExcluirSaidaLabel"><i class="fas fa-trash-alt me-2"></i>Excluir Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="saida-excluir" method="post">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="mb-3 text-warning">
                                <i class="fas fa-exclamation-triangle fa-4x"></i>
                            </div>
                            <h5>Tem certeza de que deseja excluir esta saída?</h5>
                            <p class="text-muted">Esta ação não poderá ser desfeita e afetará o estoque do produto.</p>
                        </div>
                        <input type="hidden" id="idSaidaExcluir" name="idSaidaExcluir">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-1"></i>Confirmar Exclusão</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="<?= url('assets/app/js/app.js') ?>"></script>
<script src="<?= url('assets/app/js/formsCreate.js') ?>"></script>
<script src="<?= url('assets/app/js/formsDelete.js') ?>"></script>
<script src="<?= url('assets/app/js/formsUpdate.js') ?>"></script>
<script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>"></script>
<script>
    // Carregar dados quando a página for carregada
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        
        // Carrega todos os dados necessários
        loadAllData();
        
        // Função para limpar o backdrop e restaurar o scroll
        function limparBackdrop() {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            const backdrops = document.getElementsByClassName('modal-backdrop');
            while(backdrops.length > 0) {
                backdrops[0].remove();
            }
        }

        // Adiciona evento para limpar backdrop quando qualquer modal for fechado
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                limparBackdrop();
            });
        });
        
        // Inicializa eventos para botões de modais
        const botaoAdicionarCategoria = document.getElementById('adicionarCategoriaBtn');
        if (botaoAdicionarCategoria) {
            botaoAdicionarCategoria.addEventListener('click', function() {
                console.log('Botão Gerenciar Categorias clicado');
                limparBackdrop(); // Limpa qualquer backdrop existente
                const modalTabelaCategorias = new bootstrap.Modal(document.getElementById('modalTabelaCategorias'));
                modalTabelaCategorias.show();
            });
        }
        
        const consultarEntradasBtn = document.getElementById('consultarEntradasBtn');
        if (consultarEntradasBtn) {
            consultarEntradasBtn.addEventListener('click', function() {
                console.log('Botão Consultar Entradas clicado');
                limparBackdrop(); // Limpa qualquer backdrop existente
                const entradasModal = new bootstrap.Modal(document.getElementById('entradasModal'));
                entradasModal.show();
            });
        }
        
        const consultarSaidasBtn = document.getElementById('consultarSaidasBtn');
        if (consultarSaidasBtn) {
            consultarSaidasBtn.addEventListener('click', function() {
                console.log('Botão Consultar Saídas clicado');
                limparBackdrop(); // Limpa qualquer backdrop existente
                const saidasModal = new bootstrap.Modal(document.getElementById('saidasModal'));
                saidasModal.show();
            });
        }
        
        // Verificar se as categorias foram carregadas
        setTimeout(function() {
            const selectCategoria = document.getElementById('categoria');
            if (selectCategoria && selectCategoria.options.length <= 1) {
                console.log('Recarregando categorias...');
                fetchCategorias();
            }
        }, 1000);
    });
</script>
</body>