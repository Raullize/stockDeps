const form_pd = $("#produto-excluir");
form_pd.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_pd.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/estoque-pd",
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
                return;
            }

        }
    });
});
