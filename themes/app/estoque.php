<?php
    $this->layout("_theme");
?>
   <link rel="stylesheet" href="<?= url('assets/app/css/styleSassEstoque.css') ?>">
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
                    <form class="d-flex" role="search">
                        <input class="form-control form-control-lg me-2" type="search" placeholder="Nome do produto"
                            aria-label="Search">
                        <button class="botao-cadastrar-produto" type="submit">CADASTRAR</button>
                    </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vassoura</td>
                                <td><button class="botao-deletar"> DELETAR </button></td>
                            </tr>

                            <tr>
                                <td>Maquina de lavar</td>
                                <td><button class="botao-deletar"> DELETAR </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Tela de controle e filtro do saldo dos produtos-->
            <div class="saldoProdutos">
            <div class="center"> 
                    <p class="display-3"> 
                        Saldo 
                    </p>
                </div>
                <div class="inputCadastro">
                    <form class="d-flex" role="search">
                        <select class="form-select form-select-lg " aria-label=".form-select-lg example">
                            <option selected>Selecione uma categoria de itens</option>
                            <option value="1">Lava roupas</option>
                            <option value="2">Lava louças</option>
                            <option value="3">Lava carros</option>
                            <option value="4">Limpeza de ambiente</option>
                            <option value="5">Geral</option>

                        </select>
                        <button class="botao-cadastrar-produto" type="submit">FILTRAR</button>
                    </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Preço</th>
                                <th scope="col">QTD.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vassoura</td>
                                <td>42,90</td>
                                <td> 7 </td>
                            </tr>

                            <tr>
                                <td>Maquina de lavar</td>
                                <td>42,90</td>
                                <td> 8 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Tela de controle de entrada dos produtos-->
            <div class="entradaProdutos">
            <div class="center"> 
                    <p class="display-3"> 
                        Entradas 
                    </p>
                </div>
                <div class="inputEntrada">
                    <for role="search">
                        <select class="form-select form-select-lg" aria-label=".form-select-lg example">
                            <option selected>Selecione uma categoria de itens</option>
                            <option value="1">Lava roupas</option>
                            <option value="2">Lava louças</option>
                            <option value="3">Lava carros</option>
                            <option value="4">Limpeza de ambiente</option>
                            <option value="5">Geral</option>
                        </select>
                        <div class="flex">
                            <select class="form-select form-select-lg mt-3" aria-label=".form-select-lg example">
                                <option selected>Selecione um item</option>
                                <option value="1">Lava roupas</option>
                                <option value="2">Lava louças</option>
                                <option value="3">Lava carros</option>
                                <option value="4">Limpeza de ambiente</option>
                                <option value="5">Geral</option>
                            </select>
                            <input class="form-control form-control-lg mx-2 mt-3" type="search"
                                placeholder="Quantidade">

                            <button class="botao-cadastrar-quantidade mt-3" type="submit">SALVAR</button>
                        </div>


                        </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">QTD.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vassoura</td>
                                <td> 7 </td>
                                <td><button class="botao-editar"> EDITAR </button></td>
                            </tr>

                            <tr>
                                <td>Maquina de lavar</td>
                                <td> 8 </td>
                                <td><button class="botao-editar"> EDITAR </button></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="saidaProdutos">
                <div class="center"> 
                    <p class="display-3"> 
                        Saídas 
                    </p>
                </div>
               
                <div class="inputEntrada">
                    <for role="search">
                        <select class="form-select form-select-lg" aria-label=".form-select-lg example">
                            <option selected>Selecione uma categoria de itens</option>
                            <option value="1">Lava roupas</option>
                            <option value="2">Lava louças</option>
                            <option value="3">Lava carros</option>
                            <option value="4">Limpeza de ambiente</option>
                            <option value="5">Geral</option>
                        </select>
                        <div class="flex">
                            <select class="form-select form-select-lg mt-3" aria-label=".form-select-lg example">
                                <option selected>Selecione um item</option>
                                <option value="1">Lava roupas</option>
                                <option value="2">Lava louças</option>
                                <option value="3">Lava carros</option>
                                <option value="4">Limpeza de ambiente</option>
                                <option value="5">Geral</option>
                            </select>
                            <input class="form-control form-control-lg mx-2 mt-3" type="search"
                                placeholder="Quantidade">

                            <button class="botao-cadastrar-quantidade mt-3" type="submit">SALVAR</button>
                        </div>


                        </form>
                </div>

                <div class="tabelaDeProdutos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">QTD.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vassoura</td>
                                <td> 7 </td>
                                <td><button class="botao-editar"> EDITAR </button></td>
                            </tr>

                            <tr>
                                <td>Maquina de lavar</td>
                                <td> 8 </td>
                                <td><button class="botao-editar"> EDITAR </button></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="<?= url('assets/app/js/estoque.js') ?>"></script>