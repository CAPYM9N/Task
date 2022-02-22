<?php

define('ACCESS', true);

header('Content-Type:text/html;charset=utf-8');
session_start();

require_once 'libraries/functions.php';
require_once 'core/base/settings/internal_settings.php';

use core\base\controller\BaseRoute;

try{
    BaseRoute::routeDirection();
}
catch (Exception $e) {
    exit($e->getMessage());
}
