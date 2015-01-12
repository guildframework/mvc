<?php

namespace Mvc;

class Application {

    public static $config = array();
    public static $module = NULL;
    public static $controller = NULL;
    public static $action = NULL;

    public function __construct() {
        self::$config = require './config/config.php';
        $this->autoload();
        $this->getRoute();
    }

    private function getRoute() {
        $url = filter_input(INPUT_GET, 'url');
        $host = explode('.',filter_input(INPUT_SERVER, 'HTTP_HOST'));
        if (isset($url)) {
            $params = explode('/', $url);
        }
        if(isset($host[0]) && $host[0]=='admin'){
            self::$module = 'Admin';
        }  else {
            self::$module = 'Shop';
        }
        self::$controller = (isset($params[0]) ? ucfirst($params[0]) : 'Index');
        self::$action = (isset($params[1]) ? $params[1] : 'index');
    }

    public function autoload() {
        spl_autoload_register(function ($class) {
            include './module/' . self::$module . '/src/' . $class . '.php';
        });
    }

    public function run() {
        $controllerName = ucfirst(self::$action) . 'Controller';
        require './module/' . self::$module . '/src/' . self::$controller . '/Controller/' . self::$action . 'Controller.php';
        $controller = new $controllerName();
        /* $actionName = self::$action . 'Action'; */
        $controller->viewAction();
    }

}
