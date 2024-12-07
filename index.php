<?php

ob_start();
session_start();

// Permitir requisições de qualquer origem (ajuste conforme necessário)
header("Access-Control-Allow-Origin: *");
// Permitir métodos específicos, como POST, GET
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// Permitir cabeçalhos específicos que possam ser utilizados na requisição
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require __DIR__ . "/vendor/autoload.php";
use CoffeeCode\Router\Router;

$route = new Router(CONF_URL_BASE, ":");
/**
 * Web Routes
 */
$route->namespace("Source\App");
/**
 * App Routs
 */
$route->group("/"); // agrupa em /app



/* ---------------------------------------------------------------------------------------------------- */



/* ROTAS PRINCIPAIS DO SISTEMA MODO:GET */

$route->get("/", "App:inicio");
$route->get("/estoque", "App:estoque");
$route->get("/clientes", "App:clientes");
$route->get("/fornecedores", "App:fornecedores");
$route->get("/relatorio", "App:relatorio");

/* ROTAS MODO:GET TRATAMENTO DE VARIAVEIS (MIGUEL) */

$route->get("/getProdutos", "App:getProdutos");
$route->get("/getCategorias", "App:getCategorias");
$route->get("/getClientes", "App:getClientes");
$route->get("/getFornecedores", "App:getFornecedores");
$route->get("/getEntradas", "App:getEntradas");
$route->get("/getSaidas", "App:getSaidas");


/* ROTAS GET:POST DE TRATAMENTO DE DADOS DA NOTA FISCAL .PDF */


$route->post("/processarXmlNota", "App:processarXmlNota");

/* ROTAS DE FUNÇÕES RELACIONADAS AO CRUD DE ESTOQUE MODO:POST */

$route->post("/estoque-pc", "App:estoquePc");
$route->post("/estoque-cc", "App:estoqueCc");
$route->post("/estoque-ec", "App:estoqueEc");
$route->post("/estoque-sc", "App:estoqueSc");

$route->post("/estoque-pd", "App:estoquePd");

$route->post("/estoque-pu", "App:estoquePu");
/*
$route->post("/estoque-cc", "App:estoqueCc");
$route->post("/estoque-ec", "App:estoqueEc");
$route->post("/estoque-sc", "App:estoqueSc");
*/

/* ATUALIZAR TODAS ABAIXO */
$route->post("/categorias-deletar", "App:categoriasDeletar");
$route->post("/estoque-entrada", "App:estoqueEntrada");
$route->post("/estoque-saidas", "App:estoqueSaidas");
$route->post("/estoque-deletar", "App:estoqueDeletar");
$route->post("/estoque-atualizar", "App:estoqueAtualizar");

/* ROTAS DE FUNÇÕES RELACIONADAS AO CRUD DE CLIENTES MODO:POST */
$route->post("/cadastro-clientes", "App:cadastroClientes");

/* ROTAS DE FUNÇÕES RELACIONADAS AO CRUD DE FORNECEDORES MODO:POST */
$route->post("/cadastro-fornecedores", "App:cadastroFornecedores");

/* ROTAS DE FUNÇÕES RELACIONADAS AOS RELATORIOS MODO:GET*/

$route->get("/pdf-r-c", "App:relatorioClientes");
$route->get("/pdf-r-p", "App:relatorioProdutos");

/* HISTORICO DO CLIENTE */
$route->post("/historico-cliente", "App:getHistoricoCliente");



/* ---------------------------------------------------------------------------------------------------- */



$route->group(null); // desagrupo do /app

/*
 * Erros Routes
 */

$route->group("error")->namespace("Source\App");
$route->get("/{errcode}", "Web:error");

$route->dispatch();

/*
 * Error Redirect
 */

if ($route->error()) {
    $route->redirect("/error/{$route->error()}");
}

ob_end_flush();
