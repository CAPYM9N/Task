<?php

namespace core\user\controller;

use core\base\controller\BaseController;
use core\base\settings\Settings;
use core\user\model\Model;
use core\user\model\User;

abstract class SiteController extends BaseController
{

    public function __construct(){

        $this->init();

        if(!$this->model) $this->model = Model::instance();

        if(!$this->messages) $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH . Settings::get('messages') . 'informationMessages.php';

        if(isset($_COOKIE["remember"]) && !empty($_COOKIE["remember"])){

            $user = User::instance();
            $data = $user->getUser($_COOKIE["remember"]);

            if($data) $_SESSION['guest'] = $data;
        }
    }

    protected function outputData(){

        if(!$this->content){
            $args = func_get_arg(0);
            $vars = $args ?: [];

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(TEMPLATE . 'layout/header');
        $this->footer = $this->render(TEMPLATE . 'layout/footer');

        return $this->render(TEMPLATE . 'layout/master');

    }

}