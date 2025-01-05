<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Core\Session;

class Adm
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(CONF_VIEW_ADM, 'php');

        $session = new Session();
        if (!$session->has("admin")) { 
            header("Location: /stockDeps");
            exit(); 
        }
    }

    public function teste(): void
    {
        echo $this->view->render("teste",[]);
    }
}