

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

                if (response.type === 'success') {
                    exibirMensagemTemporariaSucesso(response.message);

                    // Fechar o modal de exclusão, se estiver aberto
                    const modalExcluir = bootstrap.Modal.getInstance(document.querySelector('.modal.show'));
                    if (modalExcluir) {
                        modalExcluir.hide(); // Fecha o modal programaticamente
                    }

                    // Atualizar a tabela e lista local
                    if (callback) callback(response);

                    // Recarregar a tabela de produtos para garantir sincronia
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

function atualizarDadosGlobais(response) {
    if (response.produtos) {
        produtos = response.produtos;
        if (!produtos || produtos.length === 0) {
            limparTabelaProdutos();
        } else {
            preencherTabelaProdutos(produtos);
            mostrarPagina(1, produtos);
        }
    }

    if (response.entradas) {
        entradas = response.entradas;
        entradasFiltradas = [...entradas];
        if (!entradas || entradas.length === 0) {
            limparTabelaEntradas();
        } else {
            mostrarPaginaEntradas(1);
        }
    }

    if (response.saidas) {
        saidas = response.saidas;
        saidasFiltradas = [...saidas];
        if (!saidas || saidas.length === 0) {
            limparTabelaSaidas();
        } else {
            mostrarPaginaSaidas(1);
        }
    }
}

async function atualizarProdutos() {
    try {
        const response = await fetch(`${BASE_URL}/getProdutos`);
        const produtosAtualizados = await response.json();

        // Atualiza a lista global e a tabela
        produtos = produtosAtualizados;
        preencherTabelaProdutos(produtos); // Atualiza a tabela com a lista
    } catch (error) {
        console.error("Erro ao atualizar a lista de produtos:", error);
        exibirMensagemTemporariaErro("Erro ao atualizar a lista de produtos.");
    }
}

async function atualizarEntradas() {
    try {
        const response = await fetch(`${BASE_URL}/getEntradas`);
        const entradasAtualizadas = await response.json();

        // Verifica se o retorno é válido
        entradas = Array.isArray(entradasAtualizadas) ? entradasAtualizadas : [];
        entradasFiltradas = [...entradas];

        if (entradas.length === 0) {
            limparTabelaEntradas(); // Limpa a tabela e exibe mensagem de vazio
        } else {
            mostrarPaginaEntradas(1); // Exibe a primeira página
        }
    } catch (error) {
        console.error("Erro ao atualizar a lista de entradas:", error);
        exibirMensagemTemporariaErro("Erro ao atualizar a lista de entradas.");
    }
}

async function atualizarSaidas() {
    try {
        const response = await fetch(`${BASE_URL}/getSaidas`);
        const saidasAtualizadas = await response.json();

        // Verifica se o retorno é válido
        saidas = Array.isArray(saidasAtualizadas) ? saidasAtualizadas : [];
        saidasFiltradas = [...saidas];

        if (saidas.length === 0) {
            limparTabelaSaidas(); // Limpa a tabela e exibe mensagem de vazio
        } else {
            mostrarPaginaSaidas(1); // Exibe a primeira página
        }
    } catch (error) {
        console.error("Erro ao atualizar a lista de saídas:", error);
        exibirMensagemTemporariaErro("Erro ao atualizar a lista de saídas.");
    }
}

function limparTabelaProdutos() {
    const tabela = document.querySelector("#tabelaProdutos tbody");
    if (tabela) {
        tabela.innerHTML = ''; 
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

function removerProdutoLocalmente(idProduto) {
    produtos = produtos.filter(produto => produto.codigo_produto !== idProduto);
    preencherTabelaProdutos(produtos);
}

function removerEntradaLocalmente(idEntrada) {
    entradas = entradas.filter(entrada => entrada.id !== idEntrada);
    entradasFiltradas = [...entradas];
    if (entradas.length === 0) {
        limparTabelaEntradas();
    } else {
        mostrarPaginaEntradas(1);
    }
}

function removerSaidaLocalmente(idSaida) {
    saidas = saidas.filter(saida => saida.id !== idSaida);
    saidasFiltradas = [...saidas];
    if (saidas.length === 0) {
        limparTabelaSaidas();
    } else {
        mostrarPaginaSaidas(1);
    }
}

function limparTabelaEntradas() {
    const tabela = document.querySelector("#tabelaEntradas tbody");
    tabela.innerHTML = `<tr><td colspan="6" class="text-center">Nenhuma entrada encontrada.</td></tr>`;
}

function limparTabelaSaidas() {
    const tabela = document.querySelector("#tabelaSaidas tbody");
    tabela.innerHTML = `<tr><td colspan="6" class="text-center">Nenhuma saída encontrada.</td></tr>`;
}

handleDeleteFormSubmission("#produto-excluir", `${BASE_URL}/estoque-pd`, function (response) {
    if (response.produtoExcluidoId) {
        // Atualiza localmente removendo o produto
        removerProdutoLocalmente(response.produtoExcluidoId);
    }
});
handleDeleteFormSubmission("#categoria-excluir", `${BASE_URL}/estoque-cd`, atualizarDadosGlobais);
handleDeleteFormSubmission("#entrada-excluir", `${BASE_URL}/estoque-ed`, function () {
    atualizarEntradas(); // Recarrega as entradas do servidor
});

handleDeleteFormSubmission("#saida-excluir", `${BASE_URL}/estoque-sd`, function () {
    atualizarSaidas(); // Recarrega as saídas do servidor
});
handleDeleteFormSubmission("#cliente-excluir", `${BASE_URL}/deletar-clientes`, atualizarTabelaClientes);
handleDeleteFormSubmission("#fornecedor-excluir", `${BASE_URL}/deletar-fornecedores`, atualizarTabelaFornecedores);
