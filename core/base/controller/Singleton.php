<?php


namespace core\base\controller;


trait Singleton
{

    static private $_instance;


    private function __construct()
    {

    }

    static public function instance()
    {
        if (self::$_instance instanceof self)
            return self::$_instance;
        self::$_instance = new self;

        return self::$_instance;
    }
}