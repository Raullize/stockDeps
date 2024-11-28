const form_pe = $("#produto-excluir");
form_pe.on("submit", function(e) {
    e.preventDefault();

    const serializedData = form_pe.serialize();
    
    $.ajax({
        type: "POST",
        url: "/stock-deps/estoque-pe",
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
                preencherTabelaProdutos(response.produtos);
                return;
            }

        }
    });
});
