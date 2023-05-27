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



   <link rel="stylesheet" href="<?= url('assets/app/css/styleSassEstoque.css') ?>">

   <body>
    
   
<div id="container">

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
                    <p class="botao-produtos">
                        ENTRADAS
                    </p>
                </label>

                <input type="radio" class="botao-selecionavel" name="checks" id="checkSaidas">
                <label for="checkSaidas">
                    <p class="botao-produtos">
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
                <div class="inputCadastro">
                    <form id="form-cadastro" name="cadastro" method="POST" action="" class="" role="search">
                        <select name="categoria" class="form-select form-select-lg mb-3 inputForm" aria-label=".form-select-lg example" id="dropdown-categorias-produtos">
                            <option selected>Selecione uma categoria para o novo item</option>
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
                        
                        </div>
                        
                        <div class="flex">
                        
                        <textarea name="descricao" class="form-control mt-4 inputForm" id="descricao-produto" rows="3" placeholder="Descrição do produto"></textarea>
                        
                            <div>
                                
                             <button class="botao-cadastrar-produto mt-4" type="submit" id="botao-produtos">CADASTRAR</button>

                            <div id="message"></div>

                            </div>

                        </div>
                    </form>
                

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
                            <option selected>Selecione uma categoria de itens</option>
                           

                        </select>
                        <button class="botao-cadastrar-produto" type="submit" id="botao-filtrar">FILTRAR</button>
                    </form>
                </div>
                
                <div class="tabelaDeProdutos" >
                    <table class="table" >
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">QTD.</th>
                            <th scope="col">Ações</th>
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
                            <option selected>Selecione uma categoria de itens</option>
                        </select>
                        <div class="flex">
                            <select name="produto" class="form-select form-select-lg my-3 inputForm" aria-label=".form-select-lg example"  id="dropdown-itens-entradas">
                                <option>Selecione um item</option>
                            </select>
                            <input name="quantidade" class="form-control form-control-lg mx-2 mt-3 inputForm" type="search"
                                placeholder="Quantidade">

                            <button class="botao-cadastrar-quantidade mt-3" type="submit">SALVAR</button>

                            <div id="message-entrada"></div>

                        </div>


                    </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">QTD.</th>
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
                                <option selected>Selecione uma categoria de itens</option>
                            </select>
                            <div class="flex">
                                <select name="produto" class="form-select form-select-lg my-3 inputForm" aria-label=".form-select-lg example" id="dropdown-itens-saidas">
                                    <option>Selecione um item</option>
                                </select>
                                <input name="quantidade" class="form-control form-control-lg mx-2 mt-3 inputForm" type="search"
                                placeholder="Quantidade">
                        
                            
                            </div>
                            <div class="flex">
                
                            <input name="cliente" id="procurar-cliente-saidas" class="form-control form-control-lg inputForm " 
                            type="search" placeholder="Escolha o cliente" aria-label="Search">
                            <div id="client-list-saidas">
                            </div>
                            <button class="botao-cadastrar-quantidade mx-2" type="submit">SALVAR</button>

                            <div id="message-saidas"></div>

                        </div>
                    </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">QTD.</th>
                                <th scope="col">Cliente</th>
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
                        <button type="submit" id="save-button" class="mt-4">Salvar</button>
                    </div>
                
                </div>
                <div class="modal-content-descricao">
                <label for="descricao-produto-modal" id="label-modal-descricao">Descrição do produto:</label>
                <textarea class="form-control " id="descricao-produto-modal" rows="9" placeholder="Descrição do produto"></textarea>
                </div>    
            </form>
        </div>
            
    </div>

<script type="text/javascript" async>      
    const form = document.querySelector("#form-cadastro");
    const message = document.querySelector("#message");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();        
        const dataProduto = new FormData(form);
        const data = await fetch("<?= url("estoque-cadastro"); ?>",{
            method: "POST",
            body: dataProduto,
        });
        
        const produto = await data.json();
        console.log(produto);
            message.innerHTML = produto.message;
            message.classList.add("message");
            message.classList.remove("success", "warning", "error");
            message.classList.add(`${produto.type}`);
    });
</script>

<script type="text/javascript" async>  

    const form_entrada = document.querySelector("#form-entrada");
    const message_entrada = document.querySelector("#message-entrada");
    form_entrada.addEventListener("submit", async (e) => {
        e.preventDefault();        
        const dataEntrada = new FormData(form_entrada);
        const data = await fetch("<?= url("estoque-entrada"); ?>",{
            method: "POST",
            body: dataEntrada,
        });
            
        const entrada = await data.json();
        console.log(entrada);
            message_entrada.innerHTML = entrada.message;
            message_entrada.classList.add("message_entrada");
            message_entrada.classList.remove("success", "warning", "error");
            message_entrada.classList.add(`${entrada.type}`);
    });

</script>

<script type="text/javascript" async>  

    const form_saidas = document.querySelector("#form-saidas");
    const message_saidas = document.querySelector("#message-saidas");
    form_saidas.addEventListener("submit", async (e) => {
        e.preventDefault();        
        const dataSaidas = new FormData(form_saidas);
        const data = await fetch("<?= url("estoque-saidas"); ?>",{
            method: "POST",
            body: dataSaidas,
        });
            
        const saidas = await data.json();
        console.log(saidas);
            message_saidas.innerHTML = saidas.message;
            message_saidas.classList.add("message_saidas");
            message_saidas.classList.remove("success", "warning", "error");
            message_saidas.classList.add(`${saidas.type}`);
    });

</script>

    <script src="<?= url('assets/app/js/estoqueForm.js') ?>"></script>
    <script src="<?= url('assets/app/js/procurarClientes.js') ?>"></script>
    <script src="<?= url('assets/app/js/dropdowns.js') ?>"></script>
    <script src="<?= url('assets/app/js/displayEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/produtosEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/saldoEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/entradasEstoque.js') ?>"></script>
    <script src="<?= url('assets/app/js/modalEstoque.js') ?>"></script>
     
   </body>