<?php
$this->layout("_theme");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/estoque.css') ?>">

<body>
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title text-primary fw-bold mb-0">
                            <i class="fas fa-boxes-stacked me-2"></i>Gestão de Produtos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="headerTabelaProdutos p-3 bg-light rounded mb-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto" id="adicionarProdutoBtn">
                                    <i class="fas fa-plus me-2"></i>
                                    <span>Produto</span>
                                </button>
                                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalTabelaCategorias" id="adicionarCategoriaBtn">
                                    <i class="fas fa-tags me-2"></i>
                                    <span>Categorias</span>
                                </button>
                                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdicionarDANFE">
                                    <i class="fas fa-file-invoice me-2"></i>
                                    <span>Notas</span>
                                </button>
                                <button class="btn btn-info d-flex align-items-center" id="consultarEntradasBtn">
                                    <i class="fas fa-arrow-down me-2"></i>
                                    <span>Entradas</span>
                                </button>
                                <button class="btn btn-info d-flex align-items-center" id="consultarSaidasBtn">
                                    <i class="fas fa-arrow-up me-2"></i>
                                    <span>Saídas</span>
                                </button>
                            </div>
                            <div class="d-flex flex-wrap gap-2 align-items-center mt-3 mt-md-0">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="buscarProduto" class="form-control border-start-0" id="buscarProduto" placeholder="Procurar produto">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-filter text-muted"></i>
                                    </span>
                                    <select id="categoria" name="categoria" class="form-select border-start-0"></select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th id="ordenarCodigo">Código <i class="fas fa-sort ms-1" id="setaCodigo"></i></th>
                                        <th id="ordenarNome">Nome <i class="fas fa-sort ms-1" id="setaNome"></i></th>
                                        <th id="ordenarDescricao">Descrição</th>
                                        <th id="ordenarPreco">Preço <i class="fas fa-sort ms-1" id="setaPreco"></i></th>
                                        <th id="ordenarQuantidade">Quantidade <i class="fas fa-sort ms-1" id="setaQuantidade"></i></th>
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
            </div>
        </div>
        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

    <!-- MODAIS -->

    <!-- Modal Adicionar Produto -->
    <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAdicionarProdutoLabel">
                        <i class="fas fa-plus-circle me-2"></i>Adicionar Produto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="produto-cadastro" name="produto-cadastro" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="codigoProdutoAdicionar" class="form-label">Código do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-barcode"></i>
                                </span>
                                <input name="codigo" type="text" class="form-control" id="codigoProdutoAdicionar" placeholder="Digite o código do produto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nomeProdutoAdicionar" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="nomeProdutoAdicionar" placeholder="Digite o nome do produto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoProdutoAdicionar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="descricao" class="form-control" id="descricaoProdutoAdicionar" placeholder="Digite a descrição do produto"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaProdutoAdicionar" class="form-label">Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-folder"></i>
                                </span>
                                <select name="categoria" class="form-control" id="categoriaProdutoAdicionar">
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precoSaidaProdutoAdicionar" class="form-label">Preço para Saídas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input
                                    name="preco"
                                    type="text"
                                    class="form-control preco"
                                    id="precoSaidaProdutoAdicionar"
                                    value="R$ 0,00"
                                    oninput="formatarPreco(this)">
                            </div>
                            <small id="precoHelp" class="form-text text-muted">Digite o valor do produto com separação de milhar (ex: R$ 1.000,00).</small>
                        </div>
                        <div class="mb-3">
                            <label for="unidadeProdutoAdicionar" class="form-label">Unidade de Medida</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-weight"></i>
                                </span>
                                <select name="unidade" class="form-control" id="unidadeProdutoAdicionar" required>
                                    <option value="" disabled selected>Escolha a Unidade de Medida</option>
                                    <option value="KG">Kilograma (kg)</option>
                                    <option value="UN">Unidade (un)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fotoProdutoAdicionar" class="form-label">Foto do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-image"></i>
                                </span>
                                <input name="image" type="file" id="fotoProdutoAdicionar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Fechar
                        </button>
                        <button type="submit" class="btn btn-primary" id="salvarProduto">
                            <i class="fas fa-save me-2"></i>Salvar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Produto -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Editar Produto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="produto-update" name="produto-update" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="idProdutoUpdate" id="idProdutoUpdate">
                        <div class="mb-3">
                            <label for="codigoProdutoEditar" class="form-label">Código do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-barcode"></i>
                                </span>
                                <input name="codigo" type="text" class="form-control" id="codigoProdutoEditar" placeholder="Digite o código do produto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input name="nome" type="text" id="nomeProduto" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoProduto" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="descricao" id="descricaoProduto" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaProdutoEditar" class="form-label">Categoria</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-folder"></i>
                                </span>
                                <select name="categoria" class="form-control" id="categoriaProdutoEditar">
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precoProduto" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input name="preco" type="text" class="form-control preco" id="precoProduto" value="R$ 0,00" oninput="formatarPreco(this)">
                            </div>
                            <small id="precoHelp" class="form-text text-muted">Digite o valor do produto com separação de milhar (ex: R$ 1.000,00).</small>
                        </div>
                        <div class="mb-3">
                            <label for="unidadeProdutoEditar" class="form-label">Unidade de Medida</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-weight"></i>
                                </span>
                                <select name="unidade" class="form-control" id="unidadeProdutoEditar" required>
                                    <option value="" disabled>Escolha a Unidade de Medida</option>
                                    <option value="KG">Kilograma (kg)</option>
                                    <option value="UN">Unidade (un)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fotoProduto" class="form-label">Foto do Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-image"></i>
                                </span>
                                <input name="image" type="file" id="fotoProduto" class="form-control">
                            </div>
                            <div class="text-center mt-3">
                                <img id="previewImagem" src="" alt="Imagem do Produto" style="max-width: 150px; display: none; margin:10px auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
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

    <!-- Modal com a tabela de categorias -->
    <div class="modal fade" id="modalTabelaCategorias" tabindex="-1" aria-labelledby="modalTabelaCategoriasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTabelaCategoriasLabel">
                        <i class="fas fa-tags me-2"></i>Gerenciar Categorias
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Botão para adicionar uma nova categoria -->
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdicionarCategoria">
                            <i class="fas fa-plus me-2"></i>
                            <span>Adicionar Categoria</span>
                        </button>
                    </div>
                    <!-- Tabela de categorias -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tabelaCategorias">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaCategorias">
                                <!-- As categorias serão inseridas aqui dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Categoria -->
    <div class="modal fade" id="modalAdicionarCategoria" tabindex="-1" aria-labelledby="modalAdicionarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAdicionarCategoriaLabel">
                        <i class="fas fa-plus-circle me-2"></i>Adicionar Categoria
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoria-cadastro" name="categoria-cadastro" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCategoriaAdicionar" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="nomeCategoriaAdicionar" placeholder="Digite o nome da categoria">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCategoriaAdicionar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="descricao" class="form-control" id="descricaoCategoriaAdicionar" rows="3" placeholder="Digite a descrição da categoria"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="salvarCategoria">
                            <i class="fas fa-save me-2"></i>Salvar Categoria
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoria -->
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarCategoriaLabel">
                        <i class="fas fa-edit me-2"></i>Editar Categoria
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoria-editar" name="categoria-editar" method="post">
                    <div class="modal-body">
                        <input name="idCategoriaEditar" id="idCategoriaEditar" type="hidden">
                        <div class="mb-3">
                            <label for="nomeCategoriaEditar" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="nomeCategoriaEditar" placeholder="Digite o nome da categoria">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoCategoriaEditar" class="form-label">Descrição</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="descricao" class="form-control" id="descricaoCategoriaEditar" rows="3" placeholder="Digite a descrição da categoria"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="salvarEdicaoCategoria">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Categoria -->
    <div class="modal fade" id="modalExcluirCategoria" tabindex="-1" aria-labelledby="modalExcluirCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalExcluirCategoriaLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Categoria
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="categoria-excluir" name="categoria-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir esta categoria?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Esta ação não pode ser desfeita. Se houver produtos associados a esta categoria, eles ficarão sem categoria.
                        </div>
                        <input type="hidden" id="idCategoriaExcluir" name="idCategoriaExcluir">
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger px-4" id="confirmarExcluirCategoria">
                            <i class="fas fa-trash-alt me-2"></i>Excluir
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
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Produto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="produto-excluir" name="produto-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir este produto?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Ao confirmar, todas as entradas e saídas relacionadas a ele também serão removidas.
                        </div>
                        <input type="hidden" id="idProdutoExcluir" name="idProdutoExcluir">
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
            
    <!-- Modal Adicionar Nota -->
    <div class="modal fade" id="modalAdicionarDANFE" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-file-invoice me-2"></i>Adicionar Nota DANFE
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="processarXmlNota" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="arquivoNota" class="form-label">Upload de Nota (XML)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-file-code"></i>
                                </span>
                                <input type="file" id="arquivoNota" name="arquivoNota" class="form-control" accept=".xml">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Enviar Nota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Entrada -->
    <div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="modalEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEntradaLabel">
                        <i class="fas fa-arrow-down me-2"></i>Adicionar Entrada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="entrada-cadastro" name="entrada-cadastro" method="post">
                    <div class="modal-body">
                        <input name="produtoId" type="hidden" id="produtoId" value=""> <!-- Campo oculto para armazenar o id -->
                        <div class="mb-3">
                            <label for="fornecedor" class="form-label">Fornecedor</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-truck-fast"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="fornecedor" placeholder="Digite o nome do fornecedor">
                            </div>
                            <div class="list-group mt-0 position-absolute w-100" id="fornecedor-lista" style="display: none; z-index: 1000;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-cubes"></i>
                                </span>
                                <input name="quantidade" type="number" min="0" step="0.001" class="form-control" id="quantidade" placeholder="Digite a quantidade">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precoEntrada" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input name="preco" type="text" class="form-control preco" id="precoEntrada" placeholder="R$ 0,00" value="R$ 0,00">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Entrada
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Saída -->
    <div class="modal fade" id="modalSaida" tabindex="-1" aria-labelledby="modalSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalSaidaLabel">
                        <i class="fas fa-arrow-up me-2"></i>Adicionar Saída
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saida-cadastro" name="saida-cadastro" method="post">
                    <div class="modal-body">
                        <input name="produtoId2" type="hidden" id="produtoId2" value=""> <!-- Campo oculto para armazenar o id -->
                        <!-- Campo Cliente -->
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="cliente" placeholder="Digite o nome do cliente">
                            </div>
                            <div class="list-group mt-0 position-absolute w-100" id="clientes-lista" style="display: none; z-index: 1000;"></div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="clienteNaoCadastrado">
                                <label class="form-check-label" for="clienteNaoCadastrado">Cliente não cadastrado</label>
                            </div>
                        </div>
                        <!-- Campo Quantidade -->
                        <div class="mb-3">
                            <label for="quantidadeSaida" class="form-label">Quantidade</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-cubes"></i>
                                </span>
                                <input name="quantidade" type="number" min="0" step="0.001" class="form-control" id="quantidadeSaida" placeholder="Digite a quantidade">
                            </div>
                        </div>
                        <!-- Campo Preço -->
                        <div class="mb-3">
                            <label for="precoSaida" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input name="preco" type="text" class="form-control preco" id="precoSaida" placeholder="R$ 0,00" value="R$ 0,00">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Saída
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Entradas -->
    <div class="modal fade" id="entradasModal" tabindex="-1" aria-labelledby="entradasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="entradasModalLabel">
                        <i class="fas fa-arrow-down me-2"></i>Histórico de Entradas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control" id="filtroDataEntrada">
                            <button class="btn btn-outline-secondary" type="button" id="filtrarEntradasBtn">
                                <i class="fas fa-filter"></i>
                            </button>
                            <button class="btn btn-outline-secondary" type="button" id="limparFiltroEntradasBtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="buscarEntradaProduto" placeholder="Buscar por produto...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tabelaEntradas">
                            <thead class="table-light">
                                <tr>
                                    <th>Produto</th>
                                    <th>Fornecedor</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaEntradas">
                                <!-- Entradas serão inseridas aqui -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3" id="mensagemNenhumaEntrada" style="display: none;">
                        <p class="text-muted">Nenhuma entrada encontrada.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <nav>
                        <ul class="pagination justify-content-center pagination-sm mb-0" id="paginacaoEntradas"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Entradas -->
    <div class="modal fade" id="modalEditarEntrada" tabindex="-1" aria-labelledby="modalEditarEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarEntradaLabel">
                        <i class="fas fa-edit me-2"></i>Editar Entrada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="entrada-editar" method="post">
                    <div class="modal-body">
                        <input name="idEntradaEditar" id="idEntradaEditar" type="hidden">
                        <!-- Nome do Produto -->
                        <div class="mb-3">
                            <label for="entradaProduto" class="form-label">Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-box"></i>
                                </span>
                                <input name="nome" type="text" class="form-control" id="entradaProduto" readonly>
                            </div>
                        </div>

                        <!-- Quantidade -->
                        <div class="mb-3">
                            <label for="entradaQuantidade" class="form-label">Quantidade</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-cubes"></i>
                                </span>
                                <input name="quantidade" type="number" min="0" step="0.001" class="form-control" id="entradaQuantidade" min="0">
                            </div>
                        </div>

                        <!-- Preço -->
                        <div class="mb-3">
                            <label for="entradaPreco" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input name="preco" type="text" class="form-control preco" id="entradaPreco" placeholder="R$ 0,00" value="R$ 0,00" oninput="formatarPreco(this)">
                            </div>
                            <small class="form-text text-muted">Digite o valor com separação de milhar (ex: R$ 1.000,00).</small>
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

    <!-- Modal de Saídas -->
    <div class="modal fade" id="saidasModal" tabindex="-1" aria-labelledby="saidasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="saidasModalLabel">
                        <i class="fas fa-arrow-up me-2"></i>Histórico de Saídas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control" id="filtroDataSaida">
                            <button class="btn btn-outline-secondary" type="button" id="filtrarSaidasBtn">
                                <i class="fas fa-filter"></i>
                            </button>
                            <button class="btn btn-outline-secondary" type="button" id="limparFiltroSaidasBtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="buscarSaidaProduto" placeholder="Buscar por produto/cliente...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tabelaSaidas">
                            <thead class="table-light">
                                <tr>
                                    <th>Produto</th>
                                    <th>Cliente</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Data</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaSaidas">
                                <!-- Saídas serão inseridas aqui -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3" id="mensagemNenhumaSaida" style="display: none;">
                        <p class="text-muted">Nenhuma saída encontrada.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <nav>
                        <ul class="pagination justify-content-center pagination-sm mb-0" id="paginacaoSaidas"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Saidas -->
    <div class="modal fade" id="modalEditarSaida" tabindex="-1" aria-labelledby="modalEditarSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarSaidaLabel">
                        <i class="fas fa-edit me-2"></i>Editar Saída
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saida-editar" method="post">
                    <div class="modal-body">
                        <!-- Nome do Produto (Somente leitura) -->
                        <input type="hidden" name="idEditarSaida" id="idEditarSaida">
                        <div class="mb-3">
                            <label for="saidaProduto" class="form-label">Produto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-box"></i>
                                </span>
                                <input type="text" class="form-control" id="saidaProduto" readonly>
                            </div>
                        </div>

                        <!-- Quantidade -->
                        <div class="mb-3">
                            <label for="saidaQuantidade" class="form-label">Quantidade</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-cubes"></i>
                                </span>
                                <input name="quantidade" type="number" min="0" step="0.001" class="form-control" id="saidaQuantidade" min="0">
                            </div>
                        </div>

                        <!-- Preço -->
                        <div class="mb-3">
                            <label for="saidaPreco" class="form-label">Preço</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input name="preco" type="text" class="form-control preco" id="saidaPreco" placeholder="R$ 0,00" value="R$ 0,00" oninput="formatarPreco(this)">
                            </div>
                            <small class="form-text text-muted">Digite o valor com separação de milhar (ex: R$ 1.000,00).</small>
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

    <!-- Modal Excluir Entrada -->
    <div class="modal fade" id="modalExcluirEntrada" tabindex="-1" aria-labelledby="modalExcluirEntradaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalExcluirEntradaLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Entrada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="entrada-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir esta entrada?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Esta ação não pode ser desfeita e afetará o estoque do produto.
                        </div>
                        <input type="hidden" id="idEntradaExcluir" name="idEntradaExcluir">
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt me-2"></i>Excluir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Saída -->
    <div class="modal fade" id="modalExcluirSaida" tabindex="-1" aria-labelledby="modalExcluirSaidaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalExcluirSaidaLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Excluir Saída
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="saida-excluir" method="post">
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center fs-5 mb-4">Tem certeza de que deseja excluir esta saída?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Esta ação não pode ser desfeita e afetará o estoque do produto.
                        </div>
                        <input type="hidden" id="idSaidaExcluir" name="idSaidaExcluir">
                    </div>
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt me-2"></i>Excluir
                        </button>
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

    // Processar os formulários de edição para formatar corretamente os valores antes do envio
    document.addEventListener('DOMContentLoaded', function () {
        // Formulário de edição de entrada
        const formEntradaEditar = document.getElementById('entrada-editar');
        if (formEntradaEditar) {
            formEntradaEditar.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Converter o valor formatado para número
                const precoInput = document.getElementById('entradaPreco');
                if (precoInput) {
                    const precoFormatado = precoInput.value;
                    const precoNumerico = converterPrecoParaNumero(precoFormatado);
                    
                    // Criar um campo oculto com o valor numérico para envio
                    const precoHidden = document.createElement('input');
                    precoHidden.type = 'hidden';
                    precoHidden.name = 'preco_numerico';
                    precoHidden.value = precoNumerico;
                    formEntradaEditar.appendChild(precoHidden);
                }
                
                // Enviar o formulário
                formEntradaEditar.submit();
            });
        }
        
        // Formulário de edição de saída
        const formSaidaEditar = document.getElementById('saida-editar');
        if (formSaidaEditar) {
            formSaidaEditar.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Converter o valor formatado para número
                const precoInput = document.getElementById('saidaPreco');
                if (precoInput) {
                    const precoFormatado = precoInput.value;
                    const precoNumerico = converterPrecoParaNumero(precoFormatado);
                    
                    // Criar um campo oculto com o valor numérico para envio
                    const precoHidden = document.createElement('input');
                    precoHidden.type = 'hidden';
                    precoHidden.name = 'preco_numerico';
                    precoHidden.value = precoNumerico;
                    formSaidaEditar.appendChild(precoHidden);
                }
                
                // Enviar o formulário
                formSaidaEditar.submit();
            });
        }
        
        // Função para converter preço formatado para número
        function converterPrecoParaNumero(precoFormatado) {
            if (!precoFormatado) return 0;
            
            // Remove todos os caracteres não numéricos, exceto ponto e vírgula
            const precoLimpo = precoFormatado.replace(/[^\d,.]/g, '');
            
            // Substitui vírgula por ponto e converte para número
            const precoNumerico = parseFloat(precoLimpo.replace(',', '.'));
            
            return isNaN(precoNumerico) ? 0 : precoNumerico;
        }
    });
</script>
</body>