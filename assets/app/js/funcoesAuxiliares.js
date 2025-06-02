/* exibirMensagemTemporariaErro: EXIBE UMA MENSAGEM DE ERRO TEMPORARIA NA 
                                 TELA DO USUARIO */
function exibirMensagemTemporariaErro(mensagem) {
    // Cria o elemento da mensagem
    const elementoMensagem = $('<div>')
        .css({
            position: 'fixed',
            top: '25%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            background: 'rgb(220, 53, 69)',
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

/* exibirMensagemTemporariaErro: EXIBE UMA MENSAGEM DE AVISO TEMPORARIA NA 
                                 TELA DO USUARIO */

function exibirMensagemTemporariaAviso(mensagem) {
    // Cria o elemento da mensagem
    const elementoMensagem = $('<div>')
        .css({
            position: 'fixed',
            top: '25%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            background: 'rgb(255, 193, 7)',
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

/* exibirMensagemTemporariaSucesso: EXIBE UMA MENSAGEM DE SUCESSO TEMPORARIA NA 
                                    TELA DO USUARIO */

function exibirMensagemTemporariaSucesso(mensagem) {
    // Cria o elemento da mensagem
    const elementoMensagem = $('<div>')
        .css({
            position: 'fixed',
            top: '25%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            background: 'rgb(25, 135, 84)',
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

/* verifyInputs: PERCORRE O FORM DADO, E RETORNA FALSE SE EXISTIR ALGUM INPUT VAZIO, 
                 CASO CONTRARIO DEVOLVE TRUE */

function verifyInputs(form) {
    let areInputsFilled = true;

    // Percorre todos os elementos de input, select e textarea do formulário
    $(form).find('input, select, textarea').each(function () {
        const value = $(this).val() ? $(this).val().trim() : '';
        const isDisabled = $(this).is(':disabled');

        // Verifica se o elemento está vazio ou desabilitado
        if ((value === '' || value === null) && !isDisabled) {
            areInputsFilled = false;
            return false; // Interrompe o loop
        }
    });

    return areInputsFilled;
}

function formatarPreco(input) {

    let valor = input.value.replace(/\D/g, "");

    valor = valor.replace(/^0+/, "") || "0";

    valor = valor.substring(0, 11);

    const centavos = valor.slice(-2).padStart(2, "0");
    const inteiros = valor.slice(0, -2);

    const inteirosFormatados = inteiros
        .split("")
        .reverse()
        .reduce((acc, num, i) => {
            return num + (i && i % 3 === 0 ? "." : "") + acc;
        }, "");

    input.value = `R$ ${inteirosFormatados || "0"},${centavos}`;
}

/**
 * Formata um input de quantidade, garantindo que apenas números e pontos/vírgulas decimais sejam aceitos
 * Este formato é mais adequado para unidades de medida como KG, onde valores decimais são comuns
 * 
 * @param {HTMLElement} input - O elemento de input a ser formatado
 */
function formatarQuantidade(input) {
    // Remove caracteres inválidos, permitindo apenas números e separadores decimais
    let valor = input.value.replace(/[^\d.,]/g, "");
    
    // Substituir vírgulas por pontos (padrão internacional)
    valor = valor.replace(",", ".");
    
    // Remover pontos extras (manter apenas o primeiro ponto decimal)
    const partes = valor.split(".");
    if (partes.length > 2) {
        valor = partes[0] + "." + partes.slice(1).join("");
    }
    
    // Limitar a 3 casas decimais (adequado para pesos em KG, etc.)
    if (valor.includes(".")) {
        const decimais = valor.split(".")[1];
        if (decimais.length > 3) {
            valor = valor.substring(0, valor.indexOf(".") + 4);
        }
    }
    
    // Atualizar o valor do input
    input.value = valor;
}

// Função para inicializar todos os campos de quantidade na página
function inicializarCamposQuantidade() {
    // Selecionar todos os inputs de quantidade que devem usar a formatação
    document.querySelectorAll('input[name="quantidade"]').forEach(input => {
        // Adicionar o evento input para formatar enquanto o usuário digita
        input.addEventListener('input', function() {
            formatarQuantidade(this);
        });
        
        // Adicionar evento de focus para garantir que o campo receba foco corretamente
        input.addEventListener('focus', function() {
            // Selecionar todo o texto ao receber foco
            this.select();
        });
    });
}

// Inicializar campos quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    inicializarCamposQuantidade();
    
    // Reinicializar quando modais forem abertos (para novos campos dinâmicos)
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            inicializarCamposQuantidade();
        });
    });
});

/**
 * Formata um CNPJ no padrão XX.XXX.XXX/XXXX-XX
 * @param {Event} event - O evento de input
 */
function formatarCNPJ(event) {
    let cnpj = event.target.value;
    
    // Remove qualquer caractere que não seja número
    cnpj = cnpj.replace(/\D/g, '');
    
    // Limita a 14 dígitos
    cnpj = cnpj.substring(0, 14);
    
    // Formata o CNPJ no padrão XX.XXX.XXX/XXXX-XX
    if (cnpj.length > 0) {
        cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
        cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
    }
    
    // Atualiza o valor do campo
    event.target.value = cnpj;
}

/**
 * Formata um número de telefone no padrão (XX) XXXXX-XXXX
 * @param {Event} event - O evento de input
 */
function formatarTelefone(event) {
    let telefone = event.target.value;
    
    // Remove qualquer caractere que não seja número
    telefone = telefone.replace(/\D/g, '');
    
    // Limita a 11 dígitos (com DDD)
    telefone = telefone.substring(0, 11);
    
    // Formata o telefone no padrão (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
    if (telefone.length > 0) {
        // Adiciona parênteses no DDD
        telefone = telefone.replace(/^(\d{2})(\d)/, '($1) $2');
        
        // Adiciona hífen antes dos últimos 4 dígitos
        if (telefone.length > 10) {
            telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2');
        } else {
            telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
        }
    }
    
    // Atualiza o valor do campo
    event.target.value = telefone;
}

/**
 * Formata um CEP no padrão XXXXX-XXX
 * @param {Event} event - O evento de input
 */
function formatarCEP(event) {
    let cep = event.target.value;
    
    // Remove qualquer caractere que não seja número
    cep = cep.replace(/\D/g, '');
    
    // Limita a 8 dígitos
    cep = cep.substring(0, 8);
    
    // Formata o CEP no padrão XXXXX-XXX
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    
    // Atualiza o valor do campo
    event.target.value = cep;
}

// Inicializa os campos de formatação quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa campos de CNPJ
    document.querySelectorAll('#cnpjFornecedor, #editarFornecedorCnpj').forEach(input => {
        input.addEventListener('input', formatarCNPJ);
    });
    
    // Inicializa campos de telefone
    document.querySelectorAll('#telefoneFornecedor, #editarFornecedorTelefone, #telefoneCliente, #editarTelefoneCliente').forEach(input => {
        input.addEventListener('input', formatarTelefone);
    });
    
    // Inicializa campos de CEP
    document.querySelectorAll('#cepFornecedor, #editarFornecedorCep').forEach(input => {
        input.addEventListener('input', formatarCEP);
    });
});