<?php

namespace core\base\controller;

trait BaseMethods
{

    protected function clearStr(&$str){

        if(is_array($str)){

            foreach ($str as $key => $item) $str[$key] = $this->clearStr($item);

            return $str;
        }else{
            return htmlspecialchars(strip_tags(preg_replace('/\s+/','',$str)));
        }
    }

    protected function clearNum($num){
        return (!empty($num) && preg_match('/\d/', $num)) ? preg_replace('/[^\d.]/', '', $num) * 1 : 0;
    }

    protected function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    protected function redirect($http = false){

        if($http) $redirect = $http;
        else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :  PATH;

        return $redirect;
    }

    protected function getStyles(){

        if($this->styles){
            foreach ($this->styles as $style) echo '<link rel="stylesheet" href="' . $style . '">';
        }

    }

    protected function getScripts(){

        if($this->scripts){
            foreach ($this->scripts as $script) echo '<script src="' . $script . '"></script>';
        }

    }

}