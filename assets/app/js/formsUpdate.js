function handleEditFormSubmission(formSelector, url, callback) {
    const form = $(formSelector);
    form.on("submit", function (e) {
        e.preventDefault();

        const serializedData = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: serializedData,
            dataType: "json",
            success: function (response) {
                if (response.type === 'error') {
                    console.log(response);
                    exibirMensagemTemporariaErro(response.message);
                    return;
                }

                if (response.type === 'warning') {
                    console.log(response);
                    exibirMensagemTemporariaAviso(response.message);
                    return;
                }

                if (response.type === 'success') {
                    console.log(response);
                    exibirMensagemTemporariaSucesso(response.message);
                    if (callback) callback(response); // Executa a lógica adicional passada
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro no AJAX:", error);
                exibirMensagemTemporariaErro("Erro ao processar a solicitação.");
            }
        });
    });
}

// Atualiza tabelas e dados globais
function atualizarDadosGlobais(response) {
    if (response.produtos) {
        produtos = response.produtos;
        preencherTabelaProdutos(produtos);
        mostrarPagina(paginaAtual, produtos);
    }
    if (response.entradas) {
        entradas = response.entradas;
        entradasFiltradas = [...entradas]; // Atualiza a lista filtrada
        mostrarPaginaEntradas(1); // Reinicia na primeira página
    }
    if (response.saidas) {
        saidas = response.saidas;
        saidasFiltradas = [...saidas]; // Atualiza a lista filtrada
        mostrarPaginaSaidas(1); // Reinicia na primeira página
    }
}

// Recarrega entradas e saídas após edição
function recarregarEntradas() {
    fetchEntradas(); // Recarrega a lista de entradas
}
function recarregarSaidas() {
    fetchSaidas(); // Recarrega a lista de saídas
}

// Formulários com callbacks específicos
handleEditFormSubmission("#produto-update", `${BASE_URL}/estoque-pu`, atualizarDadosGlobais);
handleEditFormSubmission("#entrada-editar", `${BASE_URL}/estoque-eu`, recarregarEntradas);
handleEditFormSubmission("#saida-editar", `${BASE_URL}/estoque-su`, recarregarSaidas);
handleEditFormSubmission("#categoria-editar", `${BASE_URL}/estoque-cu`, function (response) {
    if (response.produtos) atualizarDadosGlobais(response);
    fetchCategorias(); // Recarrega categorias
});
handleEditFormSubmission("#cliente-update", `${BASE_URL}/update-clientes`, function (response) {
    if (response.clientes) {
        clientes = response.clientes;
        mostrarPaginaClientes(paginaAtualClientes, clientes);
    }
});
handleEditFormSubmission("#formEditarFornecedor", `${BASE_URL}/update-fornecedores`, function (response) {
    if (response.fornecedores) {
        fornecedores = response.fornecedores;
        mostrarPaginaFornecedores(paginaAtualFornecedores, fornecedores);
    }
});