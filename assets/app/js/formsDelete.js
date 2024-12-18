// Função genérica para submissão de formulários de exclusão
function handleDeleteFormSubmission(formSelector, url, callback) {
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
                    exibirMensagemTemporariaErro(response.message);
                    return;
                }

                if (response.type === 'warning') {
                    exibirMensagemTemporariaAviso(response.message);
                    return;
                }

                if (response.type === 'success') {
                    exibirMensagemTemporariaSucesso(response.message);
                    
                    // Fechar o modal de exclusão, se existir
                    const modalExcluir = bootstrap.Modal.getInstance(document.querySelector('.modal.show'));
                    if (modalExcluir) modalExcluir.hide();

                    // Executa callback para atualizar dados
                    if (callback) callback(response);

                    // Atualiza a tabela de produtos diretamente após exclusão
                    atualizarProdutos(); 
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro no AJAX:", error);
                exibirMensagemTemporariaErro("Erro ao processar a solicitação.");
            }
        });
    });
}

// Função para atualizar tabelas e dados globais
function atualizarDadosGlobais(response) {
    if (response.produtos) {
        produtos = response.produtos;
        preencherTabelaProdutos(produtos);
        mostrarPagina(1, produtos); // Sempre mostrar a primeira página atualizada dos produtos
    }
    if (response.entradas) {
        entradas = response.entradas;
        entradasFiltradas = [...entradas]; // Atualiza a lista filtrada de entradas
        mostrarPaginaEntradas(1); // Reinicia na primeira página
    }
    if (response.saidas) {
        saidas = response.saidas;
        saidasFiltradas = [...saidas]; // Atualiza a lista filtrada de saídas
        mostrarPaginaSaidas(1); // Reinicia na primeira página
    }
}

// Função para recarregar os produtos
async function atualizarProdutos() {
    try {
        const response = await fetch(`${BASE_URL}/getProdutos`); // Recarrega os produtos via AJAX
        produtos = await response.json();
        mostrarPagina(1, produtos); // Atualiza a tabela de produtos para a primeira página
    } catch (error) {
        console.error("Erro ao atualizar a lista de produtos:", error);
        exibirMensagemTemporariaErro("Erro ao atualizar a lista de produtos.");
    }
}


function atualizarTabelaClientes(response) {
    clientes = response.clientes || []; 
    mostrarPaginaClientes(1, clientes); 
}

// Atualiza a tabela de fornecedores após a exclusão
function atualizarTabelaFornecedores(response) {
    fornecedores = response.fornecedores || []; 
    mostrarPaginaFornecedores(1, fornecedores); 
}

handleDeleteFormSubmission("#produto-excluir", `${BASE_URL}/estoque-pd`, atualizarDadosGlobais);
handleDeleteFormSubmission("#categoria-excluir", `${BASE_URL}/estoque-cd`, atualizarDadosGlobais);
handleDeleteFormSubmission("#entrada-excluir", `${BASE_URL}/estoque-ed`, atualizarDadosGlobais);
handleDeleteFormSubmission("#saida-excluir", `${BASE_URL}/estoque-sd`, atualizarDadosGlobais);
handleDeleteFormSubmission("#cliente-excluir", `${BASE_URL}/deletar-clientes`, atualizarTabelaClientes);
handleDeleteFormSubmission("#fornecedor-excluir", `${BASE_URL}/deletar-fornecedores`, atualizarTabelaFornecedores);
