<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Categorias;
use Source\Models\Clientes;
use Source\Models\Produtos;

class App
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_APP,'php');
    }

    public function home () : void 
    {
        $cliente = new Clientes();
        $clientes = $cliente->selectAll();
        $produto = new Produtos();
        $produtos = $produto->selectAll();
        $categoria = new Categorias();
        $categorias = $categoria->selectAll();

        echo $this->view->render("home",[
            "produtos" => $produtos,
            "categorias" => $categorias,
            "clientes" => $clientes
        ]);

    }

    public function estoque () : void 
    {
        $produto = new Produtos();
        $produtos = $produto->selectAll();
        $categoria = new Categorias();
        $categorias = $categoria->selectAll();
        echo $this->view->render("estoque",[
            "produtos" => $produtos,
            "categorias" => $categorias
        ]);

    }

    public function cadastro () : void 
    {
        $categoria = new Categorias();
        $categorias = $categoria->selectAll();
        echo $this->view->render("cadastro", [
            "categorias" => $categorias
        ]);

    }

    public function clientes () : void 
    {

        $cliente = new Clientes();
        $clientes = $cliente->selectAll();

        echo $this->view->render("clientes", [
            "clientes" => $clientes
        ]);

    }

}