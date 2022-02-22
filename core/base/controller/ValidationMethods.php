<?php

namespace core\base\controller;

use core\base\settings\Settings;

trait ValidationMethods
{
    protected function postClear($settings = false, &$arr = []){

        if(!$arr) $arr = &$_POST;
        if(!$settings) $settings = Settings::instance();

        $validate = $settings::get('validation');

        foreach ($arr as $key => $item){

            if(is_array($item)){
                $this->postClear($settings, $item);
            }else{
                if(is_numeric($item)){
                    $arr[$key] = $this->clearNum($item);
                }

                if($validate){

                    if($validate[$key]){
                        $field = $key;

                        if($validate[$key]['trim']) $arr[$key] = trim($item);
                        if($validate[$key]['clearSpace']) $arr[$key] = $this->clearSpace($item);
                        if($validate[$key]['int']) $arr[$key] = $this->clearNum($item);
                        if($validate[$key]['str']) $arr[$key] = $this->clearStr($item);
                        if($validate[$key]['empty']) $this->emptyFields($arr[$field], $field, $arr);
                        if($validate[$key]['validEmail']) $this->validateEmail($arr[$field], $field, $arr);
                        if($validate[$key]['unique']) $this->unique($arr[$field], $field, $arr);
                        if($validate[$key]['countMax']) $this->countChar($arr[$field], $validate[$key]['countMax'], $field, 'max', $arr);
                        if($validate[$key]['countMin']) $this->countChar($arr[$field], $validate[$key]['countMin'], $field, 'min', $arr);
                        if($validate[$key]['numberLetter']) $this->isNumberLetter($arr[$field], $field);
                        if($validate[$key]['onlyLetter']) $this->onlyLetter($arr[$field], $field, $arr);
                        if($validate[$key]['crypt'])$arr[$key] = md5(SALT.$arr[$field]);
                    }
                }
            }
        }

        if(isset($arr['password2'])) $this->checkPassword($arr);
        return true;
    }

    protected function emptyFields($str, $field, $arr = []){

        if(empty(preg_replace('/\s+/','',$str))){

            $_SESSION['result']['warning'][$field] = $this->messages['empty'] . ' ' . $field;
            $this->addSessionData($arr);
        }
    }

    protected function clearSpace($str){
        return preg_replace('/\s+/','',$str);
    }

    protected function countChar($str, $counter, $field, $comparison, $arr = []){
        if($comparison === 'max') {

            if (mb_strlen($str) > $counter) {

                $str_res = mb_str_replace('$1', $field, $this->messages['countMax']);
                $str_res = mb_str_replace('$2', $counter, $str_res);

                $_SESSION['result']['warning'][$field] = $str_res;
                $this->addSessionData($arr);
            }

        }elseif($comparison === 'min'){

            if (mb_strlen($str) < $counter) {

                $str_res = mb_str_replace('$1', $field, $this->messages['countMin']);
                $str_res = mb_str_replace('$2', $counter - 1, $str_res);

                $_SESSION['result']['warning'][$field] = $str_res;
                $this->addSessionData($arr);
            }
        }
    }

    protected function unique($item, $field, $arr = []){

        if($this->model->checkFieldOnUnique($item, $field)){

            $str_res = mb_str_replace('$1', $field, $this->messages['unique']);

            $_SESSION['result']['warning'][$field] = $str_res;

            $this->addSessionData($arr);
        }
    }

    protected function checkPassword($arr){
        if($arr['password'] !== $arr['password2']){
            $_SESSION['result']['warning']['password2'] = $this->messages['password'];
            $this->addSessionData($arr);
        }
    }

    public function validateEmail($email, $field, $arr){

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['result']['warning'][$field] = $this->messages['email'];
            $this->addSessionData($arr);
        }

    }

    protected function isNumberLetter($str, $field){

            if(!$this->checkNumber($str) || !$this->checkLetter($str)){

                $str_res = mb_str_replace('$1', $field, $this->messages['pwdContent']);

                $_SESSION['result']['warning'][$field] = $str_res;
                $this->addSessionData();

            }
    }

    protected function onlyLetter($str, $field, $arr = []){
        if(!preg_match('/^[a-zа-я]+$/i', $str, $matches)){

            $str_res = mb_str_replace('$1', $field, $this->messages['onlyLetter']);

            $_SESSION['result']['warning'][$field] = $str_res;

            $this->addSessionData($arr);
        }
    }

    protected function    addSessionData($arr = []){

        if(!$arr) $arr = $_POST;

        foreach ($arr as $key => $item){

            $_SESSION['result'][$key] = $item;

        }

        echo json_encode(['status' => false, 'refer'=> $this->redirect()]);
        exit();
    }

    protected function checkNumber($str){

        return (bool)preg_match('/\d+/', $str);

    }

    protected function checkLetter($str){

        return (bool)preg_match('/[a-zа-я]+/i', $str);

    }
}