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

    public function cadastro (?array $data) : void 
    {
        if(!empty($data)){

            if(in_array("", $data)){
                $json = [
                    "message" => "Informe todos os campos para cadastrar!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            if(!is_email($data["email"])){
                $json = [
                    "message" => "<br> Informe um e-mail válido!",
                    "type" => "warning"
                ];
                echo json_encode($json);
                return;
            }

            $client = new Clientes(
                NULL,
                $data["name"],
                $data["cpf"],
                $data["email"],
                $data["celular"],
                $data["cidade"],
                $data["bairro"],
                $data["uf"]
            );

            /*Alterar a funçãpo findbyemail -> findbyCPF*/

            if($client->findByEmail($data["email"])){
                $json = [
                    "message" => "<br> Email já cadastrado!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }

            /*terminar a função INSERT*/

            if(!$user->insert()){
                $json = [
                    "message" => $user->getMessage(),
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "name" => $data["name"],
                    "email" => $data["email"],
                    "message" => $user->getMessage(),
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            }
        }
        
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