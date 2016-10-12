<?php

namespace Guild\Mvc;

class Application {

    public static $config = array();
    public static $controller = NULL;
    public static $action = NULL;
    public static $viewFile = NULL;
    public static $layoutFile = NULL;

    public function __construct($configuration = array()) {
        self::$config = $configuration;
        # $this->autoload();
        $this->getRoute();
    }

    private function getRoute() {
        $requestUrl = filter_input(INPUT_SERVER, 'REQUEST_URI');
        #  var_dump($requestUrl);
        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }
        $data = explode('/', $requestUrl);
        $controller = 'index';
        if (isset($data[1]) && !empty($data[1])) {
            $controller = $data[1];
        }
        $action = 'index';
        if (isset($data[2]) && !empty($data[2])) {
            $action = $data[2];
        }
        self::$controller = preg_replace_callback('/(-.)/', array($this, 'camelCaseWord'), $controller);
        self::$action = preg_replace_callback('/(-.)/', array($this, 'camelCaseWord'), $action);
        #  var_dump($data);
        self::$viewFile = './app/view/' . strtolower($controller) . '/' . $action . '.phtml';
        self::$layoutFile = './app/layout/layout.phtml';
    }

    public function camelCaseWord($input) {
        $letter = str_replace('-', "", $input[0]);
        $big = ucfirst($letter);
        #  var_dump($big);
        return $big;
    }

    public function run() {
        spl_autoload_register(function ($class) {
            include './app/' . $class . '.php';
        });
        $controllerName = '\\Application\\Controller\\' . self::$controller . 'Controller';
        $controller = new $controllerName();
        $controller->setConfig(self::$config);
        $actionName = self::$action . 'Action';
        $viewModel = $controller->$actionName();
        $view = new \Guild\View\View(self::$config);
        $view->setViewFile(self::$viewFile);
        $view->setLayoutFile(self::$layoutFile);
        $view->setModel($viewModel);
        $view->render();
    }

    /*
      protected function getViewFile() {
      return './app/view/' . strtolower(self::$controller) . '/' . self::$action . '.phtml';
      }
     */
}
