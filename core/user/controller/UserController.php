<?php

namespace core\user\controller;

use core\user\model\User;

class UserController extends SiteController
{
    public function register(){

        $this->template="templates/register";

        if($this->isAjax()){

            $this->postClear();

            User::instance()->registerNewUser($_POST, $this->messages);

            echo json_encode(['refer' => PATH]);
            exit;

        }
    }

    public function login(){

        $this->template = 'templates/login';

        if($this->isAjax()){

            $this->postClear();

            User::instance()->checkLogin($_POST, $this->messages);

            echo json_encode(['refer' => $this->redirect()]);
            exit;
        }
    }

    public function logout(){

        $this->template = 'templates/index';

        if(isset($_SESSION['guest'])){

            unset($_SESSION['guest']);

            setcookie("remember", time() - 3600);
        }
    }
}

