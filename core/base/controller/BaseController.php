<?php

namespace core\base\controller;

use core\base\settings\Settings;

abstract class BaseController
{
    use BaseMethods, ValidationMethods;

    protected $header;
    protected $content;
    protected $footer;

    protected $model;
    protected $messages;

    protected $page;

    protected $controller;
    protected $inputMethod;
    protected $outputMethod;
    protected $parameters;

    protected $template;
    protected $styles;
    protected $scripts;

    public function route(){
        $controller = str_replace('/', '\\', $this->controller);

        try{
            $object = new \ReflectionMethod($controller, 'request');

            $args = [
                'parameters' => $this->parameters,
                'inputMethod' => $this->inputMethod,
                'outputMethod' => $this->outputMethod
            ];

            $object->invoke(new $controller, $args);
        }
        catch (\ReflectionException $e){
            throw new RouteException($e->getMessage());
        }


    }

    public function request($args){
        $this->parameters = $args['parameters'];

        $inputData = $args['inputMethod'];
        $outputData = $args['outputMethod'];

        $data = $this->$inputData();

        if(method_exists($this, $outputData)){

            $page = $this->$outputData($data);

            if($page) $this->page = $page;

        }elseif($data){
            $this->page = $data;
        }

        $this->getPage();
    }

    protected function render($path = '', $parameters = []){

        extract($parameters);

        if(!$path){

            $class = new \ReflectionClass($this);

            $space = str_replace('\\','/', $class->getNamespaceName() . '\\');

            $routes = Settings::get('routes');

            if($space === $routes['user']['path']) $template = TEMPLATE;
                else $template = ADMIN_TEMPLATE;

            $path = $template. explode('controller', strtolower($class->getShortName()))[0];
        }

        ob_start();

        if(!@include_once $path . '.php') throw new \Exception('Отсутствует шаблон - ' . $path);

        return ob_get_clean();
    }

    protected function getPage(){

        if(is_array($this->page)){
            foreach ($this->page as $block) echo $block;
        }else{
            echo $this->page;
        }
        exit();
    }

    protected function init(){

        if(USER_CSS_JS['styles']){
            foreach (USER_CSS_JS['styles'] as $item)
                $this->styles[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . TEMPLATE : '') . trim($item, '/');
        }

        if(USER_CSS_JS['scripts']){
            foreach (USER_CSS_JS['scripts'] as $item)
                $this->scripts[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . TEMPLATE : '') . trim($item, '/');
        }

    }
}