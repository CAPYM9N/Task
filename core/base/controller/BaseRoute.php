<?php

namespace core\base\controller;

class BaseRoute
{
    use Singleton, BaseMethods;

    public static function routeDirection(){

        RouteController::instance()->route();

    }

}