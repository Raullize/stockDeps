const form_pd = $("#produto-excluir");
form_pd.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_pd.serialize();
    
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/estoque-pd`,
        data: serializedData,
        dataType: "json",
        success: function(response) {

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro(response.message);
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso(response.message);
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                
                const modalExcluir = bootstrap.Modal.getInstance(document.getElementById('modalExcluir'));
                modalExcluir.hide();

                exibirMensagemTemporariaSucesso(response.message);

                preencherTabelaEntradas(response.entradas, response.produtos);
                preencherTabelaSaidas(response.saidas, response.produtos);
                preencherTabelaProdutos(response.produtos);
                produtos = response.produtos;
                mostrarPagina(paginaAtual);
                return;
            }

        }
    });
});

const form_cgd = $("#categoria-excluir");
form_cgd.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_cgd.serialize();
    
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/estoque-cd`,
        data: serializedData,
        dataType: "json",
        success: function(response) {

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro(response.message);
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso(response.message);
                return;
            }

            if (response.type == 'success') {
                exibirMensagemTemporariaSucesso(response.message);

                preencherTabelaEntradas(response.entradas, response.produtos);
                preencherTabelaSaidas(response.saidas, response.produtos);
                preencherTabelaProdutos(response.produtos);
                produtos = response.produtos;
                mostrarPagina(paginaAtual);
                return;
            }

        }
    });
});

const form_ed = $("#entrada-excluir");
form_ed.on("submit", async function (e) {
    e.preventDefault();

    const serializedData = form_ed.serialize();

    try {
        const response = await $.ajax({
            type: "POST",
            url: `${BASE_URL}/estoque-ed`,
            data: serializedData,
            dataType: "json",
        });
    
        if (response.type === "error") {
            console.log(response);
            exibirMensagemTemporariaErro(response.message);
            return;
        }
    
        if (response.type === "warning") {
            console.log(response);
            exibirMensagemTemporariaAviso(response.message);
            return;
        }
    
        if (response.type === "success") {
            exibirMensagemTemporariaSucesso(response.message);
    
            // Atualiza os dados globais de entradas
            entradas = response.entradas || []; // Garante que 'entradas' seja sempre um array
            entradasFiltradas = [...entradas];
    
            if (entradasFiltradas.length === 0) {
                // Caso não haja mais entradas, limpa a tabela e remove paginação
                document.querySelector("#tabelaEntradas tbody").innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma entrada encontrada.</td>
                    </tr>`;
                document.querySelector("#paginacaoEntradas").innerHTML = '';
            } else {
                // Atualiza a página atual e exibe as entradas restantes
                const maxPage = Math.ceil(entradasFiltradas.length / itensPorPagina);
                mostrarPaginaEntradas(Math.min(paginaAtualEntradas, maxPage));
            }
    
            // Fecha o modal de exclusão
            const modalExcluirEntrada = bootstrap.Modal.getInstance(document.getElementById('modalExcluirEntrada'));
            if (modalExcluirEntrada) modalExcluirEntrada.hide();
    
            // Remove backdrops pendentes
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        }
    } catch (error) {
        console.error("Erro ao processar o AJAX:", error);
        exibirMensagemTemporariaErro("Erro ao processar a solicitação. Tente novamente.");
    }
    
});

const form_sd = $("#saida-excluir");
form_sd.on("submit", async function (e) {
    e.preventDefault();

    const serializedData = form_sd.serialize();

    try {
        const response = await $.ajax({
            type: "POST",
            url: `${BASE_URL}/estoque-sd`,
            data: serializedData,
            dataType: "json",
        });

        // Verifica o tipo de resposta
        if (response.type === "error") {
            console.log(response);
            exibirMensagemTemporariaErro(response.message);
            return;
        }

        if (response.type === "warning") {
            console.log(response);
            exibirMensagemTemporariaAviso(response.message);
            return;
        }

        if (response.type === "success") {
            exibirMensagemTemporariaSucesso(response.message);

            // Verifica se as saídas estão presentes e são um array
            if (response.saidas && Array.isArray(response.saidas)) {
                // Atualiza os dados globais e a interface
                saidas = response.saidas;
                saidasFiltradas = [...saidas];

                // Se o array de saídas estiver vazio, exibe uma mensagem apropriada
                if (saidas.length === 0) {
                    exibirMensagemTemporariaAviso("Não há mais produtos no estoque.");
                } else {
                    // Atualiza a página atual
                    mostrarPaginaSaidas(paginaAtualSaidas);
                }
            } 
        }

    } catch (error) {
        console.error("Erro ao processar o AJAX:", error);
        exibirMensagemTemporariaErro("Erro ao processar a solicitação. Tente novamente.");
    }
});

const form_cd = $("#cliente-excluir");
form_cd.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_cd.serialize();
    
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/deletar-clientes`,
        data: serializedData,
        dataType: "json",
        success: function(response) {

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro(response.message);
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso(response.message);
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                
                const modalExcluir = bootstrap.Modal.getInstance(document.getElementById('modalExcluir'));
                modalExcluir.hide();

                exibirMensagemTemporariaSucesso(response.message);

                preencherTabelaEntradas(response.entradas, response.produtos);
                preencherTabelaSaidas(response.saidas, response.produtos);
                preencherTabelaProdutos(response.produtos);
                produtos = response.produtos;
                mostrarPagina(paginaAtual);
                return;
            }

        }
    });
});

const form_fd = $("#fornecedor-excluir");
form_fd.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_fd.serialize();
    
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/deletar-fornecedores`,
        data: serializedData,
        dataType: "json",
        success: function(response) {

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro(response.message);
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso(response.message);
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                
                const modalExcluir = bootstrap.Modal.getInstance(document.getElementById('modalExcluir'));
                modalExcluir.hide();

                exibirMensagemTemporariaSucesso(response.message);

                preencherTabelaEntradas(response.entradas, response.produtos);
                preencherTabelaSaidas(response.saidas, response.produtos);
                preencherTabelaProdutos(response.produtos);
                produtos = response.produtos;
                mostrarPagina(paginaAtual);
                return;
            }

        }
    });
});