const form_pu = $("#produto-update");
form_pu.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_pu.serialize();
    
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/estoque-pu`,
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
