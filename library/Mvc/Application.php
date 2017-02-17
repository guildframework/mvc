<?php

namespace Guild\Mvc;

class Application
{

    public static $config = array();
    public static $baseName = null;
    public static $controller = null;
    public static $action = null;
    public static $viewFile = null;
    public static $layoutFile = null;

    public function __construct($configuration = array())
    {
        self::$config = $configuration;
        # $this->autoload();
        $this->getRoute();
    }

    private function getRoute()
    {
        $requestUrl = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $requestUrl = str_replace(self::$config['base_path'], "", $requestUrl);
        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }
        $data = explode('/', $requestUrl);
        $controller = 'index';
        if (isset($data[0]) && !empty($data[0])) {
            $controller = $data[0];
        }
        $action = 'index';
        if (isset($data[1]) && !empty($data[1])) {
            $action = $data[1];
        }
        $controller = preg_replace_callback('/(-.)/', array($this, 'camelCaseWord'), $controller);
        self::$controller = ucfirst($controller);
        self::$action = preg_replace_callback('/(-.)/', array($this, 'camelCaseWord'), $action);
        self::$viewFile = './app/view/' . strtolower($controller) . '/' . $action . '.phtml';
        self::$layoutFile = './app/view/layout/layout.phtml';
    }

    public function camelCaseWord($input)
    {
        $letter = str_replace('-', "", $input[0]);
        $big = ucfirst($letter);
        #  var_dump($big);
        return $big;
    }

    public function run()
    {
        spl_autoload_register(function ($class) {
            $filePath = getcwd().'/app/' . $class . '.php';
            $filePath = str_replace('\\', '/', $filePath);
            include $filePath;
        });
        $controllerName = '\\Application\\Controller\\' . self::$controller . 'Controller';
        $controller = new $controllerName();
        $controller->setConfig(self::$config);
        $actionName = self::$action . 'Action';
        $viewModel = $controller->$actionName();
        $view = new \Guild\View\View(self::$config);
//        var_dump(self::$config);
      //  $view->setBasePath(self::$baseName);
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
