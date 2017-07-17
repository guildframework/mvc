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
    }

    public function run()
    {
        try {
            $router = new Router();
            spl_autoload_register(function ($class) {
                $filePath = getcwd() . '/app/' . $class . '.php';
                $filePath = str_replace('\\', '/', $filePath);
                include $filePath;
            });
            $controllerName = '\\Application\\Controller\\' . $router->getController() . 'Controller';
            $controller = new $controllerName();
            $controller->setConfig(self::$config);
            $actionName = $router->getAction() . 'Action';
            if (!method_exists($controller, $actionName)) {
                throw new \Exception('Requested action does not exists');
            }
            $viewModel = $controller->$actionName();
            $viewFile = './app/view/' . strtolower($router->getController()) . '/' . $router->getAction() . '.phtml';
            if(!file_exists($viewFile)){
                throw new \Exception('Template file not found');
            }
            $layoutFile = './app/view/layout/layout.phtml';
            $view = new \Guild\View\View(self::$config);
            $view->setViewFile($viewFile);
            $view->setLayoutFile($layoutFile);
            $view->setModel($viewModel);
            $view->render();
        } catch (\Exception $exception) {
            print_r($exception->getMessage());
        }

    }

    /*
      protected function getViewFile() {
      return './app/view/' . strtolower(self::$controller) . '/' . self::$action . '.phtml';
      }
     */
}
