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
            const areInputsFilled = verifyInputs(form_pc);

            if (!areInputsFilled) {
                console.log(response);
                exibirMensagemTemporariaErro('Preencha todos os elementos do formulário!');
                return;
            }

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro('Erro ao cadastrar, tente novamente!');
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso('Produto já está cadastrado!');
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                exibirMensagemTemporariaSucesso('Produto cadastrado com sucesso!');
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
            const areInputsFilled = verifyInputs(form_cc);

            if (!areInputsFilled) {
                console.log(response);
                exibirMensagemTemporariaErro('Preencha todos os elementos do formulário!');
                return;
            }

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro('Erro ao cadastrar, tente novamente!');
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso('Categoria já cadastrada!');
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                exibirMensagemTemporariaSucesso('Categoria cadastrada com sucesso!');
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
            const areInputsFilled = verifyInputs(form_cadastro_clientes);

            if (!areInputsFilled) {
                console.log(response);
                exibirMensagemTemporariaErro('Preencha todos os elementos do formulário!');
                return;
            }

            if (response.type == 'error') {
                console.log(response);
                exibirMensagemTemporariaErro('Erro ao cadastrar, tente novamente!');
                return;
            }

            if (response.type == 'warning') {
                console.log(response);
                exibirMensagemTemporariaAviso('Cliente já cadastrada!');
                return;
            }

            if (response.type == 'success') {
                console.log(response);
                exibirMensagemTemporariaSucesso('Cliente cadastrado com sucesso!');
                return;
            }

        }
    });
});