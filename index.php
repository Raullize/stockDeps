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

$route->get("/", "App:inicio");
$route->get("/getProdutos", "App:getProdutos");
$route->get("/getCategorias", "App:getCategorias");
$route->get("/getClientes", "App:getClientes");
$route->get("/getEntradas", "App:getEntradas");
$route->get("/getSaidas", "App:getSaidas");


$route->get("/uploadPdf", "App:uploadPdf");

$route->post("/processarPdf", "App:processarPdf");


$route->get("/estoque", "App:estoque");
$route->post("/estoque-cadastro", "App:estoqueCadastro");
$route->post("/estoque-entrada", "App:estoqueEntrada");
$route->post("/estoque-saidas", "App:estoqueSaidas");
$route->post("/estoque-deletar", "App:estoqueDeletar");
$route->post("/estoque-atualizar", "App:estoqueAtualizar");

$route->get("/relatorio", "App:relatorio");

$route->get("/pdf-r-g", "App:relatorioClientes");
$route->get("/pdf-r-p", "App:relatorioProdutos");
$route->get("/pdf-r-c", "App:relatorioClientes");
$route->get("/pdf-r-v", "App:relatorioClientes");

$route->get("/clientes", "App:clientes");
$route->get("/getProdutos", "App:getProdutos");
$route->get("/getCategorias", "App:getCategorias");
$route->get("/getClientes", "App:getClientes");
$route->get("/getEntradas", "App:getEntradas");
$route->get("/getSaidas", "App:getSaidas");
$route->post("/cadastro", "App:cadastro");

$route->get("/fornecedores", "App:fornecedores");

//CRUD CATEGORIAS
$route->get("/categorias", "App:categorias");
$route->post("/categorias-inserir", "App:categoriasInserir");
$route->post("/categorias-deletar", "App:categoriasDeletar");

$route->get("/clientes", "App:clientes");
$route->post("/historico-cliente", "App:getHistoricoCliente");


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
