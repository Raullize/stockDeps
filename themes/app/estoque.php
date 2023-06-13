
<?php
     $this->layout("_theme");
     echo '<script>';
     echo 'var categorias = ' . json_encode($categorias) . ';';
     echo '</script>';
     //PEGA OS DADOS DOS PRODUTOS DO BANCO DE DADOS
     echo '<script>';
     echo 'var produtos = ' . json_encode($produtos) . ';';
     echo '</script>';

     echo '<script>';
     echo 'var entradas = ' . json_encode($entradas) . ';';
     echo '</script>';

     echo '<script>';
     echo 'var saidas = ' . json_encode($saidas) . ';';
     echo '</script>';

     echo '<script>';
     echo 'var clientes = ' . json_encode($clientes) . ';';
     echo '</script>';

     
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
   <link rel="stylesheet" href="<?= url('assets/app/css/styleSassEstoque.css') ?>">

   <body>
       
       
       
       <div id="container">

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id='containerBotoesModalExcluir'>
                <h3>Deseja excluir o item: <span class='itemExcluir'></span></h3>
                <button id="confirmarExcluir" class='btnModalExcluir'>Sim</button>
                <button class='btnModalExcluir cancelarExcluir'>Não</button>
                </div>
            </div>
        </div>

        <!--Container da Barra Lateral-->
        <div class="containerBarraLateral">
            <!--Barra Lateral cadastro de produtos-->
            <div class="barraLateralCadastro">
                <!--Título barra lateral CADASTRO-->
                <p class="titulosBarraLateral">CADASTRO</p>

                <input type="radio" class="botao-selecionavel" name="checks" id="checkProduto" checked>
                <label for="checkProduto">
                    <p class="botao-produtos">
                        PRODUTOS
                    </p>
                </label>
            </div>
            <!--Barra Lateral estoque, entrada e saída-->
            <div class="barraLateralCadastro">

                <!--Título barra lateral ESTOQUE-->
                <p class="titulosBarraLateral">ESTOQUE</p>

                <input type="radio" class="botao-selecionavel" name="checks" id="checkSaldo">
                <label for="checkSaldo">
                    <p class="botao-produtos">
                        SALDO
                    </p>
                </label>

                <input type="radio" class="botao-selecionavel" name="checks" id="checkEntradas">
                <label for="checkEntradas">
                    <p class="botao-produtos" id="barralateral-entradas">
                        ENTRADAS
                    </p>
                </label>

                <input type="radio" class="botao-selecionavel" name="checks" id="checkSaidas">
                <label for="checkSaidas">
                    <p class="botao-produtos" id="barralateral-saidas">
                        SAÍDAS
                    </p>
                </label>
            </div>
        </div>

        <!--Telas com as funções do estoque-->
        <div class="containerFuncoes">
            <!--Telas de cadastro dos produtos-->
           
            <div class="cadastroProdutos">
                 <div class="center mb-5"> 
                    <p class="display-3"> 
                        Produtos 
                    </p>
                </div>
                <!--  -->
                <div class="inputCadastro">
  <form id="form-cadastro" name="cadastro" method="POST" action="" class="" role="search">
    <select name="categoria" class="form-select form-select-lg mb-3 inputForm" aria-label=".form-select-lg example" id="dropdown-categorias-produtos">
      <option selected value=''>Selecione uma categoria para o novo item</option>
    </select>
    <div class="flex">
      <div>
        <input name="nome" class="form-control form-control-lg me-2 inputForm" type="text" placeholder="Nome do produto"
          aria-label="Search" id="input-nome-produto">
        <div id="message-nome"></div>
      </div>
      <div>
        <input name="preco" class="form-control form-control-lg me-2 inputForm" type="number" step="any" placeholder="Preço do produto"
          aria-label="Search" id="input-preco-produto">
        <div id="message-preco"></div>
      </div>
    </div>
    <div class="flex">
      <textarea name="descricao" class="form-control mt-4 inputForm" id="descricao-produto" rows="3" placeholder="Descrição do produto"></textarea>
      <div>
        <button class="botao-cadastrar-produto mt-4" type="submit" id="botao-produtos">CADASTRAR</button>
        <div id="message"></div>
      </div>
    </div>
  </form>
</div>
                <!--  -->
                <div class="tabelaDeProdutos">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabela-produtos">
                           
                        </tbody>
                    </table>
                </div>
        </div>
            <!--Tela de controle e filtro do saldo dos produtos-->
            <div class="saldoProdutos">
            <div class="center mb-5"> 
                    <p class="display-3"> 
                        Saldo 
                    </p>
                </div>
                <div class="inputCadastro">
                    <form class="d-flex" role="search" id="form-saldo">
                        <select class="form-select form-select-lg inputForm" aria-label=".form-select-lg example" id="dropdown-categorias-saldo">
                            <option selected value=''>Selecione uma categoria de itens</option>
                           

                        </select>
                        <button class="botao-cadastrar-produto" type="submit" id="botao-filtrar">FILTRAR</button>
                    </form>
                </div>
                
                <div class="tabelaDeProdutos" >
                    <table class="table" >
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Nome</th>
                            <th scope="col" class="text-center">Preço</th>
                            <th scope="col" class="text-center">QTD.</th>
                        </tr>
                        </thead>
                        <tbody id="tabela-saldo"></tbody>
                    </table>
                </div>


            </div>
            <!--Tela de controle de entrada dos produtos-->
            <div class="entradaProdutos">
            <div class="center mb-5"> 
                    <p class="display-3"> 
                        Entradas 
                    </p>
                </div>
                <div class="inputEntrada">
                    <for role="search">
                    <form id="form-entrada" name="entrada" action="" method="post">    
                        <select name="categoria" class="form-select form-select-lg inputForm" aria-label=".form-select-lg example" id="dropdown-categorias-entradas">
                            <option selected value=''>Selecione uma categoria de itens</option>
                        </select>
                        <div class="flex">
                            <select name="produto" class="form-select form-select-lg mt-3 inputForm select-entradas"  aria-label=".form-select-lg example"  id="dropdown-itens-entradas">
                                <option value=''>Selecione um item</option>
                            </select>
                            <input name="quantidade" class="form-control form-control-lg mx-2 mt-3 inputForm" type="number"
                                placeholder="Quantidade">

                            <div>
                                <button class="botao-cadastrar-quantidade mt-3" type="submit">SALVAR</button>

                                <div id="message-entrada"></div>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="tabelaDeProdutos ">
                    <table class="table table-responsive" >
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Nome</th>
                                <th scope="col" class="text-center">QTD.</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-entradas">
                           
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="saidaProdutos">
                <div class="center mb-5"> 
                    <p class="display-3"> 
                        Saídas 
                    </p>
                </div>
               
                <div class="inputEntrada">
                    <form id="form-saidas" name="saidas" action="" method="post">
                        <for role="search">
                            <select name="categoria" class="form-select form-select-lg inputForm" aria-label=".form-select-lg example" id="dropdown-categorias-saidas">
                                <option selected value=''>Selecione uma categoria de itens</option>
                            </select>
                            <div class="flex">
                                <select name="produto" class="form-select form-select-lg my-3 inputForm" aria-label=".form-select-lg example" id="dropdown-itens-saidas">
                                    <option value=''>Selecione um item</option>
                                </select>
                                <input name="quantidade" class="form-control form-control-lg mx-2 mt-3 inputForm" type="number"
                                placeholder="Quantidade">
                        
                            
                            </div>
                            <div class="flex">
                
                            <input name="cliente" id="procurar-cliente-saidas" class="form-control form-control-lg inputForm " 
                            type="search" placeholder="Escolha o cliente" aria-label="Search">
                            <div id="client-list-saidas">
                            </div>
                            <div>
                                <button class="botao-cadastrar-quantidade mx-2" type="submit">SALVAR</button>

                                <div id="message-saidas"></div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Nome</th>
                                <th scope="col" class="text-center">QTD.</th>
                                <th scope="col" class="text-center">Cliente</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-saidas">
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="modal">
           <form class="flex" >
               
                <div class="modal-content">
                 <h3>Editar produto</h3>
                <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="my-3">
                    
                    <label for="preco">Preço:</label>
                    <input type="number" id="preco" name="preco" min="0" step="0.01" class="my-3">
                    
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0" class="my-3">

                    <div class="modal-buttons">
                        <button type="button" id="cancel-button" class="mt-4">Cancelar</button>
                        <button type="submit" class="save-button" class="mt-4">Salvar</button>
                    </div>
                
                </div>
                <div class="modal-content-descricao">
                <label for="descricao-produto-modal" id="label-modal-descricao">Descrição do produto:</label>
                <textarea class="form-control " id="descricao-produto-modal" rows="9" placeholder="Descrição do produto"></textarea>
                </div>    
            </form>
        </div>

        <div id="modal-entradas" style="display:none">
           <form class="flex" id="formEditarEntradas">
               
                <div class="modal-content">
                 <h3 class="mb-4">Editar entradas</h3>
                <label for="nome-entradas">Nome:</label>
                    <input type="text" id="nome-entradas" name="nome" class="my-3">
                    
                    <label for="quantidade-entradas">Quantidade:</label>
                    <input type="number" id="quantidade-entradas" name="quantidade" min="0" class="my-3">

                    <div class="modal-buttons">
                        <button type="button" id="cancel-button-entradas" class="mt-4">Cancelar</button>
                        <button type="submit" class="save-button btnUpdateEntradas" class="mt-4">Salvar</button>
                    </div>
                
                </div>   
            </form>
        </div>

        <div id="modal-saidas" style="display:none">
           <form class="flex" id="formEditarSaidas">
 
               <div class="modal-content">
                 <h3 class="mb-4">Editar saidas</h3>
                <label for="nome-saidas">Nome:</label>
                    <input type="text" id="nome-saidas" name="nome" class="my-3">
                    
                    <label for="quantidade-saidas">Quantidade:</label>
                    <input type="number" id="quantidade-saidas" name="quantidade" min="0" class="my-3">

                    <label for="cliente-saidas">Cliente:</label>
                    <input type="search" id="cliente-saidas" name="cliente" min="0" class="my-3">

                    <div class="modal-buttons">
                        <button type="button" id="cancel-button-saidas" class="mt-4">Cancelar</button>
                        <button type="submit" class="save-button btnUpdateSaidas" class="mt-4">Salvar</button>
                    </div>
                
                </div>   
            </form>
        </div>
            
    </div>

<script type="text/javascript" async>      
    const form = $("#form-cadastro");
    const message = document.querySelector("#message");

    form.on("submit", function(e) {
        e.preventDefault();

        const serializedData = form.serialize();
    
        const areInputsFilled = verifyInputs(form);

        
        if (!areInputsFilled) {
            exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?= url("estoque-cadastro"); ?>",
            data: serializedData,
            dataType: "json",
            success: function (response) {    
                message.innerHTML = response.message;
                message.classList.add("message");
                message.classList.remove("success", "warning", "error");
                message.classList.add(`${response.type}`);

                if(!response['error'] && response.type != 'error'){
                location.reload(true);
            } 
            }
        });
    })

</script>

<script type="text/javascript" async>  

    const form_entrada = $("#form-entrada");
    const message_entrada = document.querySelector("#message-entrada");
    
    form_entrada.on("submit",  function(e) {
        e.preventDefault();

    const serializedData = form_entrada.serialize();
    $.ajax({
        type: "POST",
        url: "<?= url("estoque-entrada"); ?>",
        data: serializedData,
        dataType: "json",
        success: function (response) {
        const areInputsFilled = verifyInputs(form_entrada);

        
        if (!areInputsFilled) {
            exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
             return;
        }

            message_entrada.innerHTML = entrada.message;
            message_entrada.classList.add("message_entrada");
            message_entrada.classList.remove("success", "warning", "error");
            message_entrada.classList.add(`${entrada.type}`);

            if(!response['error'] && response.type != 'error'){
                location.reload(true);
            } 
        }, error: function(response){
            console.log(response)
        }
    });
})
    
    //     e.preventDefault();        
    //     const dataEntrada = new FormData(form_entrada);
    //     const data = await fetch("",{
    //         method: "POST",
    //         body: dataEntrada,
    //     });
            
    //     const entrada = await data.json();
    //     console.log(entrada);
    //         message_entrada.innerHTML = entrada.message;
    //         message_entrada.classList.add("message_entrada");
    //         message_entrada.classList.remove("success", "warning", "error");
    //         message_entrada.classList.add(`${entrada.type}`);
    // });

</script>

<script type="text/javascript" async>  

    const form_saidas = $("#form-saidas");
    const message_saidas = document.querySelector("#message-saidas");

    form_saidas.on("submit", async (e) => {
        e.preventDefault();
        const serializedData = form_saidas.serialize();

        const areInputsFilled = verifyInputs(form_saidas);

        
        if (!areInputsFilled) {
            exibirMensagemTemporaria('Preencha todos os elementos do formulário.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?= url("estoque-saidas"); ?>",
            data: serializedData,
            dataType: "json",
            success: function (response) {
             message_saidas.innerHTML = response.message;
            message_saidas.classList.add("message_saidas");
            message_saidas.classList.remove("success", "warning", "error");
            message_saidas.classList.add(`${saidas.type}`);

            if(!response['error'] && response.type != 'error'){
                location.reload(true);
            } 
            }, error: function (response) {
                console.log(response);
            }
        });
        // console.log(form_saidas);
        
        // $("#")
        // const dataSaidas = new FormData(form_saidas);
        // const data = await fetch("",{
        //     method: "POST",
        //     body: dataSaidas,
        // });
            
        // const saidas = await data.json();
        
        // console.log(saidas);

        //     message_saidas.innerHTML = saidas.message;
        //     message_saidas.classList.add("message_saidas");
        //     message_saidas.classList.remove("success", "warning", "error");
        //     message_saidas.classList.add(`${saidas.type}`);

    });

    // $(".save-button").on("click", function(){
    //     console.log($this);
    // })

function verifyInputs(form) {
  let areInputsFilled = true;

  // Percorre todos os elementos de input, select e textarea do formulário
  $(form).find('input, select, textarea').each(function() {
    const value = $(this).val() ? $(this).val().trim() : '';
    const isDisabled = $(this).is(':disabled');

    // Verifica se o elemento está vazio ou desabilitado
    console.log($(this));
    console.log(value);
    if ((value === '' || value === null) && !isDisabled) {
      areInputsFilled = false;
      return false; // Interrompe o loop
    }
  });

  return areInputsFilled;
}

</script>

<script>
      function exibirMensagemTemporaria(mensagem) {
    // Cria o elemento da mensagem
    const elementoMensagem = $('<div>')
      .css({
        position: 'absolute',
        top: '25%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        background: '#FF4C4C',
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
</script>



    <script src="<?= url('assets/app/js/estoqueForm.js') ?>"></script>
    <script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>
    <script src="<?= url('assets/app/js/dropdowns.js') ?>"></script>
    <script src="<?= url('assets/app/js/displayEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/produtosEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/saldoEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/estoqueDeletar.js') ?>"></script>
    <script src="<?= url('assets/app/js/estoqueEditar.js') ?>"></script>
    <script src="<?= url('assets/app/js/modalEstoque.js') ?>"></script>
     
   </body>