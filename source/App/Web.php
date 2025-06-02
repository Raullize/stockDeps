<?php

namespace Source\App;

use Source\Core\Session;
use League\Plates\Engine;
use Source\Models\Users;

class Web
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_WEB, 'php');
    }

    public function login(): void
    {
        echo $this->view->render("login",[]);
    }

    public function validaLogin(?array $data): void
    {
        if (!empty($data)) {

        if (in_array("", $data)) {
            $json = [
                "message" => "Informe todos os campos para cadastrar!",
                "type" => "error"
            ];
            echo json_encode($json);
            return;
        }

        $session = new Session();
        $user = new Users();
        $userDados = $user->selectUserByName($data["username"]);

        if($userDados == false){
            $json = [
                "message" => "Usuário não cadastrado!",
                "type" => "error"
            ];
            echo json_encode($json);
            return;
        }

        if($userDados->user == "demoAdmin") {
            if (password_verify($data["password"], $userDados->password)) {
                $session->set("admin", [
                    "id" => $userDados->id,
                    "username" => $userDados->user,
                ]);
                $json = [
                    "user" => "Admin",
                    "message" => "Usuário Logado!",
                    "type" => "success"
                ];
                echo json_encode($json);
                return;
            } else {
                $json = [
                    "message" => "Usuário e/ou senha incorretos!",
                    "type" => "error"
                ];
                echo json_encode($json);
                return;
            }
        }

        if (password_verify($data["password"], $userDados->password)) {
            $session->set("user", [
                "id" => $userDados->id,
                "username" => $userDados->user,
            ]);
            $json = [
                "message" => "Usuário Logado!",
                "type" => "success"
            ];
            echo json_encode($json);
            return;
        } else {
            $json = [
                "message" => "Usuário e/ou senha incorretos!",
                "type" => "error"
            ];
            echo json_encode($json);
            return;
        }

        }
    }

    public function criaSenha(): void
    {
        echo $this->view->render("criasenha",[]);
    }

    /**
     * Método para exibir páginas de erro
     */
    public function error(array $data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        
        $session = new Session();
        
        if ($error == 404) {
            if ($session->has("user") || $session->has("admin")) {
                // Se estiver logado, redireciona para a página inicial
                header("Location: " . url("app"));
                exit;
            } else {
                // Se não estiver logado, redireciona para a página de login
                header("Location: " . url());
                exit;
            }
        } else {
            // Para outros erros, redireciona para a página inicial
            header("Location: " . url());
            exit;
        }
    }
}
