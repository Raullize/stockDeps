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
                        exibirMensagemTemporariaErro('Preencha todos os elementos do formulário.');
                        return;
                    }

                    exibirMensagemTemporariaSucesso('Produto cadastrado com sucesso!');
                    message_pc.classList.add("message_pc");
                    message_pc.classList.remove("success", "warning", "error");
                    message_pc.classList.add(`${entrada.type}`);

                    if (!response['error'] && response.type != 'error') {
                        location.reload(true);
                    }
                },
                error: function(response) {
                    console.log(response)
                }
            });
        })