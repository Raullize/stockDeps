<?php
// Definição de todas as constantes do sistema
// Esse script consta no composer.json para ser incluido automaticamente

// Configurações de erro para evitar saída HTML indesejada
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_PARSE);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../error.log');

// DATABASE

define("CONF_DB_HOST", "127.0.0.1");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "stockDeps"); // aqui deve ser alterado para o nome do banco de dados


// PROJECT URLs

define("CONF_URL_BASE", "http://127.0.0.1/stockDeps"); // depois da / deve vir o nome da pasta do trabalho
define("CONF_URL_TEST", "http://127.0.0.1/stockDeps"); // depois da / deve vir o nome da pasta do trabalho

// VIEW

define("CONF_VIEW_WEB", __DIR__ . "/../../themes/web");
define("CONF_VIEW_APP", __DIR__ . "/../../themes/app");
define("CONF_VIEW_ADM", __DIR__ . "/../../themes/adm");


// SITE

define("CONF_SITE_NAME", "Stock Deps");

// FILES

define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
