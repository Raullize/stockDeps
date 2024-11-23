const form_pc = $("#produto-cadastro");

form_pc.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_pc.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/estoque-pc",
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
                exibirMensagemTemporariaSucesso(response.message);
                return;
            }

        }
    });
});


const form_cc = $("#categoria-cadastro");

form_cc.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_cc.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/estoque-cc",
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
                exibirMensagemTemporariaSucesso(response.message);
                return;
            }

        }
    });
});

const form_cadastro_clientes = $("#cadastro-clientes");

form_cadastro_clientes.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_cadastro_clientes.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/cadastro-clientes",
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
                exibirMensagemTemporariaSucesso(response.message);
                return;
            }

        }
    });
});


const form_cadastro_fornecedores = $("#formAdicionarFornecedor");

form_cadastro_fornecedores.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_cadastro_fornecedores.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/cadastro-fornecedores",
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
                exibirMensagemTemporariaSucesso(response.message);
                return;
            }

        }
    });
});