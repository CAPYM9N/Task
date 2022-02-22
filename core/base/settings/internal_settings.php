<?php
defined('ACCESS') or die('Access denied');

const TEMPLATE = 'templates/';
const PATH = '/';
const SALT = '2/$rf33e34t?ew';

const USER_CSS_JS = [
    'styles' =>['css/bootstrap.min.css', 'css/starter-template.css', 'css/main.css'],
    'scripts' =>['https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js','js/bootstrap.js', 'js/script.js']
];

function autoloadMainClasses($class_name){
    $class_name = str_replace('\\','/', $class_name);

    if(!@include_once $class_name . '.php'){
        throw new \Exception('Не верное имя файла для подключения - ' .$class_name);
    }

}

spl_autoload_register('autoloadMainClasses');