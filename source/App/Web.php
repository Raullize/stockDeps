<?php

namespace Source\App;

use League\Plates\Engine;

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

}
