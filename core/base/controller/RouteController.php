<?php


namespace core\base\controller;

use core\base\settings\Settings;

class RouteController extends BaseController
{
    use Singleton;

    protected $routes;

    private function __construct()
    {
        $adress_str = $_SERVER['REQUEST_URI'];

        if($_SERVER['QUERY_STRING']){
            $adress_str = substr($adress_str,0, strpos($adress_str, $_SERVER['QUERY_STRING']) - 1);
        }

        $path = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));

        if($path === PATH){

            if(strrpos($adress_str, '/') === strlen($adress_str) - 1 && strrpos($adress_str, '/') !== strlen(PATH) - 1){
                $this->redirect(rtrim($adress_str, '/'), 301);
            }

            $this->routes = Settings::get('routes');

            if(!$this->routes) throw \Exception('Отсутствуют маршруты в базовых настройках', 1);

            $url = explode('/', substr($adress_str, strlen(PATH)));

            if($url[0] && $url[0] === $this->routes['admin']['alias'] ){

                /*админка*/
                array_shift($url);

                $this->controller = $this->routes['admin']['path'];

                $route = 'admin';

            }else{

                $this->controller = $this->routes['user']['path'];

                $route = 'user';
            }

            $this->createRoute($route, $url);

            if($url[1]){
                $count = count($url);
                $key = '';

                for($i = 1; $i < $count; $i++){
                    if(!$key){
                        $key = $url[$i];
                        $this->parameters[$key] = '';
                    }else{
                        $this->parameters[$key] = $url[$i];
                        $key = '';
                    }
                }
            }

        }else{
            throw new \Exception('Не корректная директория сайта', 1);
        }
    }

    private function createRoute($var, $arr){

        $route = [];

        if(!empty($arr[0])){
            $a = $this->routes[$var]['routes'][$arr[0]];
            if($this->routes[$var]['routes'][$arr[0]]){
                $route = explode('/', $this->routes[$var]['routes'][$arr[0]]);

                $this->controller .= ucfirst($route[0] . 'Controller');
            }else{
                $this->controller .= ucfirst($arr[0] . 'Controller');
            }
        }else{
            $this->controller .= $this->routes['default']['controller'];
        }

        $this->inputMethod = $route[1] ? $route[1] : $this->routes['default']['inputMethod'];
        $this->outputMethod = $route[2] ? $route[2] : $this->routes['default']['outputMethod'];

        return;
    }
}