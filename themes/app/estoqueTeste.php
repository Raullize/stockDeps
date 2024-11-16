<?php
$this->layout("_theme");

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?= url('assets/app/css/estoqueTeste.css') ?>">

<body>


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="tabelaProdutos">
                <div class="headerTabelaProdutos">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto" id="adicionarProdutoBtn">
                        Adicionar Produto
                    </button>
                    <button>Adicionar Categoria</button>
                    <button>Adicionar Notas</button>
                    <div>
                        <label for="categoria" class="text-light px-2">Procurar produto: </label>
                        <input type="text" name="buscarProduto" id="buscarProduto" placeholder="Procurar produto">
                    </div>
                    <div>
                        <label for="categoria" class="text-light px-2">Filtrar por categoria: </label>
                        <select id="categoria" name="categoria"></select>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th class="text-center" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="corpoTabela">
                        <!-- As linhas serão adicionadas dinamicamente via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Adicionar Produto -->
    <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAdicionarProdutoLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomeProduto" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeProduto" placeholder="Digite o nome do produto">
                    </div>
                    <div class="mb-3">
                        <label for="descricaoProduto" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricaoProduto" placeholder="Digite a descrição do produto"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categoriaProduto" class="form-label">Categoria</label>
                        <select class="form-control" id="categoriaProduto">
                            <!-- As categorias serão preenchidas dinamicamente -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="precoSaidaProduto" class="form-label">Preço para Saídas</label>
                        <input type="number" step="0.01" class="form-control" id="precoSaidaProduto" placeholder="Digite o preço para saídas">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarProduto">Salvar Produto</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarProduto">
                        <!-- Campos do Formulário de Edição -->
                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeProduto" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoProduto" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricaoProduto" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precoProduto" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="precoProduto" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExcluirLabel">Excluir Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir este produto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarExcluir">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Entrada -->
    <div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="modalEntradaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEntradaLabel">Adicionar Entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fornecedor" class="form-label">Fornecedor</label>
                        <input type="text" class="form-control" id="fornecedor" placeholder="Digite o nome do fornecedor">
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" placeholder="Digite a quantidade">
                    </div>
                    <div class="mb-3">
                        <label for="precoEntrada" class="form-label">Preço</label>
                        <input type="number" step="0.01" class="form-control" id="precoEntrada" placeholder="Digite o preço">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarEntrada">Salvar Entrada</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Saída -->
    <div class="modal fade" id="modalSaida" tabindex="-1" aria-labelledby="modalSaidaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSaidaLabel">Adicionar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="cliente" placeholder="Digite o nome do cliente">
                    </div>
                    <div class="mb-3">
                        <label for="quantidadeSaida" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidadeSaida" placeholder="Digite a quantidade">
                    </div>
                    <div class="mb-3">
                        <label for="precoSaida" class="form-label">Preço</label>
                        <input type="number" step="0.01" class="form-control" id="precoSaida" placeholder="Digite o preço">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarSaida">Salvar Saída</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" async>
        const form = $("#form-cadastro");
        const message = document.querySelector("#message");

        form.on("submit", function(e) {
            e.preventDefault();

            const serializedData = form.serialize();

            const areInputsFilled = verifyInputs(form);


            if (!areInputsFilled) {
                exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "<?= url("estoque-cadastro"); ?>",
                data: serializedData,
                dataType: "json",
                success: function(response) {
                    message.innerHTML = response.message;
                    message.classList.add("message");
                    message.classList.remove("success", "warning", "error");
                    message.classList.add(`${response.type}`);

                    if (!response['error'] && response.type != 'error') {
                        location.reload(true);
                    }
                }
            });
        })
    </script>

    <script type="text/javascript" async>
        const form_entrada = $("#form-entrada");
        const message_entrada = document.querySelector("#message-entrada");

        form_entrada.on("submit", function(e) {
            e.preventDefault();

            const serializedData = form_entrada.serialize();
            $.ajax({
                type: "POST",
                url: "<?= url("estoque-entrada"); ?>",
                data: serializedData,
                dataType: "json",
                success: function(response) {
                    const areInputsFilled = verifyInputs(form_entrada);


                    if (!areInputsFilled) {
                        exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
                        return;
                    }

                    message_entrada.innerHTML = entrada.message;
                    message_entrada.classList.add("message_entrada");
                    message_entrada.classList.remove("success", "warning", "error");
                    message_entrada.classList.add(`${entrada.type}`);

                    if (!response['error'] && response.type != 'error') {
                        location.reload(true);
                    }
                },
                error: function(response) {
                    console.log(response)
                }
            });
        })

        //     e.preventDefault();        
        //     const dataEntrada = new FormData(form_entrada);
        //     const data = await fetch("",{
        //         method: "POST",
        //         body: dataEntrada,
        //     });

        //     const entrada = await data.json();
        //     console.log(entrada);
        //         message_entrada.innerHTML = entrada.message;
        //         message_entrada.classList.add("message_entrada");
        //         message_entrada.classList.remove("success", "warning", "error");
        //         message_entrada.classList.add(`${entrada.type}`);
        // });
    </script>

    <script type="text/javascript" async>
        const form_saidas = $("#form-saidas");
        const message_saidas = document.querySelector("#message-saidas");

        form_saidas.on("submit", async (e) => {
            e.preventDefault();
            const serializedData = form_saidas.serialize();

            const areInputsFilled = verifyInputs(form_saidas);


            if (!areInputsFilled) {
                exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "<?= url("estoque-saidas"); ?>",
                data: serializedData,
                dataType: "json",
                success: function(response) {
                    message_saidas.innerHTML = response.message;
                    message_saidas.classList.add("message_saidas");
                    message_saidas.classList.remove("success", "warning", "error");
                    message_saidas.classList.add(`${saidas.type}`);

                    if (!response['error'] && response.type != 'error') {
                        location.reload(true);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
            // console.log(form_saidas);

            // $("#")
            // const dataSaidas = new FormData(form_saidas);
            // const data = await fetch("",{
            //     method: "POST",
            //     body: dataSaidas,
            // });

            // const saidas = await data.json();

            // console.log(saidas);

            //     message_saidas.innerHTML = saidas.message;
            //     message_saidas.classList.add("message_saidas");
            //     message_saidas.classList.remove("success", "warning", "error");
            //     message_saidas.classList.add(`${saidas.type}`);

        });

        // $(".save-button").on("click", function(){
        //     console.log($this);
        // })

        function verifyInputs(form) {
            let areInputsFilled = true;

            // Percorre todos os elementos de input, select e textarea do formulário
            $(form).find('input, select, textarea').each(function() {
                const value = $(this).val() ? $(this).val().trim() : '';
                const isDisabled = $(this).is(':disabled');

                // Verifica se o elemento está vazio ou desabilitado
                console.log($(this));
                console.log(value);
                if ((value === '' || value === null) && !isDisabled) {
                    areInputsFilled = false;
                    return false; // Interrompe o loop
                }
            });

            return areInputsFilled;
        }
    </script>

    <script>
        function exibirMensagemTemporaria(mensagem) {
            // Cria o elemento da mensagem
            const elementoMensagem = $('<div>')
                .css({
                    position: 'absolute',
                    top: '25%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)',
                    background: '#FF4C4C',
                    color: 'white',
                    padding: '10px',
                    borderRadius: '5px',
                    boxShadow: '0 2px 8px rgba(0, 0, 0, 0.25)',
                    zIndex: '9999', // Adiciona o z-index desejado
                    display: 'none' // Inicia oculto
                })
                .text(mensagem);

            // Adiciona o elemento à página
            $('body').append(elementoMensagem);

            // Animação de aparecimento suave
            elementoMensagem.fadeIn(400);

            // Define um temporizador para remover o elemento após 15 segundos
            setTimeout(() => {
                elementoMensagem.fadeOut(400, () => {
                    elementoMensagem.remove();
                });
            }, 2500);
        }
    </script>


    <script src="<?= url('assets/app/js/app.js') ?>"></script>
    <script src="<?= url('assets/app/js/teste.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>