function handleEditFormSubmission(formSelector, url, callback) {
    const form = document.querySelector(formSelector);
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obter os valores do formulário
        const formData = new FormData(this);
        
        // Adicionar spinner ao botão de submit
        const submitButton = this.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...';
        submitButton.disabled = true;
        
        // Fazer requisição AJAX
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                // Ocultar spinner e restaurar texto do botão
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                
                if (response.type === 'success') {
                    // Criar e mostrar mensagem de sucesso
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success mt-3';
                    alertDiv.textContent = response.message;
                    form.appendChild(alertDiv);
                    
                    // Fazer callback (por exemplo, atualizar a tabela)
                    if (callback && typeof callback === 'function') {
                        callback(response);
                    }
                    
                    // Fechar o modal
                    const modalElement = form.closest('.modal');
                    if (modalElement) {
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }
                    }
                    
                    // Atualizar dados globais se uma função de atualização for fornecida
                    if (typeof atualizarDadosGlobais === 'function') {
                        atualizarDadosGlobais(response);
                    }
                } else {
                    // Mostrar mensagem de erro
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger mt-3';
                    alertDiv.textContent = response.message;
                    form.appendChild(alertDiv);
                    
                    // Remover mensagem após um tempo
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 5000);
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição:", error);
                
                // Restaurar botão
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                
                // Mostrar mensagem de erro genérica
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger mt-3';
                alertDiv.textContent = 'Ocorreu um erro ao processar sua solicitação. Tente novamente.';
                form.appendChild(alertDiv);
                
                // Remover mensagem após um tempo
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
        });
    });
}

// Atualiza produtos, entradas, e saídas dinamicamente
function atualizarDadosGlobais(response) {
    // Atualiza produtos se houver dados de produtos na resposta
    if (response.produtos) {
        produtos = response.produtos;
        produtosFiltrados = [...produtos];
        produtosOrdenados = [...produtos];
        mostrarPagina(1);  // Atualiza a página de produtos
    }

    // Atualiza entradas se houver dados de entradas na resposta
    if (response.entradas) {
        entradas = response.entradas;
        entradasFiltradas = [...entradas];
        mostrarPaginaEntradas(1);  // Atualiza a página de entradas
        fetchProdutos();  // Atualiza a página de produtos novamente (caso precise)
    }

    // Atualiza saídas se houver dados de saídas na resposta
    if (response.saidas) {
        saidas = response.saidas;
        saidasFiltradas = [...saidas];
        mostrarPaginaSaidas(1);  // Atualiza a página de saídas
        fetchProdutos();  // Atualiza a página de produtos novamente (caso precise)
    }
}

// Registra formulários para edição
handleEditFormSubmission("#produto-update", `${BASE_URL}/estoque-pu`, atualizarDadosGlobais);
handleEditFormSubmission("#entrada-editar", `${BASE_URL}/estoque-eu`, atualizarDadosGlobais);
handleEditFormSubmission("#saida-editar", `${BASE_URL}/estoque-su`, atualizarDadosGlobais);
handleEditFormSubmission("#categoria-editar", `${BASE_URL}/estoque-cu`, fetchCategorias);
handleEditFormSubmission("#cliente-update", `${BASE_URL}/update-clientes`, fetchClientes);

// Verificar se fetchFornecedores está definido antes de passar como callback
if (typeof fetchFornecedores === 'function') {
    handleEditFormSubmission("#formEditarFornecedor", `${BASE_URL}/update-fornecedores`, fetchFornecedores);
} else {
    // Função alternativa quando fetchFornecedores não estiver disponível
    handleEditFormSubmission("#formEditarFornecedor", `${BASE_URL}/update-fornecedores`, function() {
        // Recarregar a página como fallback se a função não estiver disponível
        window.location.reload();
    });
}

// Inicialização dos formulários de edição
document.addEventListener('DOMContentLoaded', function() {
    // Formulário de edição de cliente
    handleEditFormSubmission('#formEditarCliente', `${BASE_URL}/editarCliente`, function() {
        fetchClientes();
    });
    
    // Formulário de edição de produto
    handleEditFormSubmission('#formEditarProduto', `${BASE_URL}/editarProduto`, function() {
        fetchProdutos();
    });
    
    // Formulário de edição de fornecedor
    handleEditFormSubmission('#formEditarFornecedor', `${BASE_URL}/editarFornecedor`, function() {
        // Verificar se fetchFornecedores existe antes de chamá-lo
        if (typeof fetchFornecedores === 'function') {
            fetchFornecedores();
        } else {
            // Se a função não existir, apenas recarregue a página
            location.reload();
        }
    });
    
    // Formulário de edição de categoria
    handleEditFormSubmission('#formEditarCategoria', `${BASE_URL}/editarCategoria`, function() {
        fetchCategorias();
    });
});
