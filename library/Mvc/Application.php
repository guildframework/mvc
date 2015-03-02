<?php

namespace Guild\Mvc;

class Application {
    #  public static $config = array();

    public static $module = NULL;
    public static $controller = NULL;
    public static $action = NULL;

    public function __construct() {
        #  self::$config = require './config/config.php';
        $this->autoload();
        $this->getRoute();
    }

    private function getRoute() {
        $url = filter_input(INPUT_GET, 'url');
        $host = explode('.', filter_input(INPUT_SERVER, 'HTTP_HOST'));
        if (isset($url)) {
            $params = explode('/', $url);
        }
        if (isset($host[0]) && $host[0] == 'admin') {
            self::$module = 'Admin';
        } else {
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
        # $controller = self::$controller
        $controllerName = self::$module . '\Controller\\' . self::$controller . 'Controller';
        #S require './module/' . self::$module . '/src/' . self::$module . '/Controller/' . self::$controller . 'Controller.php';
        $controller = new $controllerName();
        $actionName = self::$action . 'Action';
        $viewModel = $controller->$actionName();
        $view = new \Guild\View\View();
        $view->setViewFile($this->getViewFile());
        $view->setLayoutFile($this->getLayoutFile());
        $view->setModel($viewModel);
        $view->render();
    }

    protected function getViewFile() {
        return './module/' . self::$module . '/view/' . strtolower(self::$controller) . '/' . self::$action . '.phtml';
    }
    protected function getLayoutFile() {
        return './module/' . self::$module . '/view/layout/layout.phtml';
    }

}
