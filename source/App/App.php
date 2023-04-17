<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Clientes;

class App
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_APP,'php');
    }

    public function home () : void 
    {
        echo $this->view->render("home");

    }

    public function estoque () : void 
    {
        echo $this->view->render("estoque");

    }

    public function cadastro () : void 
    {
        echo $this->view->render("cadastro");

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