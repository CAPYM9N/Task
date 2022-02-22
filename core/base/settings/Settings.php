<?php

namespace core\base\settings;

use core\base\controller\Singleton;

class Settings
{
    use Singleton;

    private $routes = [
        'user' => [
            'path' => 'core/user/controller/',
            'routes' => [
                'register' => 'user/register',
                'login' => 'user/login',
                'logout' => 'user/logout'
            ]
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
        ]
    ];

    private $messages = 'core/base/messages/';

    private $validation = [
        'login' =>['str' => true, 'empty' => true, 'unique' => true, 'countMin' => 6],
        'name' => ['trim' => true, 'onlyLetter' => true, 'empty' => true, 'countMin' => 2],
        'email' => ['empty' => true, 'unique' => true, 'str' => true, 'validEmail' => true],
        'password' => ['clearSpace' => true, 'crypt' => true, 'empty' => true, 'countMin' => 6, 'numberLetter' => true],
        'password2' => ['clearSpace' => true, 'crypt' => true],
        'aut_login' => ['empty' => true, 'str' => true],
        'aut_password' => ['clearSpace' => true, 'crypt' => true]
    ];

    static public function get($property){
        return self::instance()->$property;
    }
}