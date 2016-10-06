<?php

namespace Guild\Mvc;

class Application {

    public static $config = array();
    public static $controller = NULL;
    public static $action = NULL;

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
       // var_dump($data);
        /* $url = filter_input(INPUT_GET, 'url');
          $host = explode('.', filter_input(INPUT_SERVER, 'HTTP_HOST'));
          if (isset($url)) {
          $params = explode('/', $url);
          }
          if (isset($host[0]) && $host[0] == 'admin') {
          self::$module = 'Admin';
          } else {
          self::$module = 'Shop';
          }
         */
        self::$controller = (isset($params[0]) ? ucfirst($params[0]) : 'Index');
        self::$action = (isset($params[1]) ? $params[1] : 'index');
    }

  /*  public function autoload() {
        spl_autoload_register(function ($class) {
            include './app/src/Controller/' . $class . '.php';
        });
    }
*/
    public function run() {
        # $controller = self::$controller
        #  $controllerName = '\\Application\Controller\\' . self::$controller . 'Controller';
        #S require './module/' . self::$module . '/src/' . self::$module . '/Controller/' . self::$controller . 'Controller.php';
        spl_autoload_register(function ($class) {
            include './app/' . $class . '.php';
        });
        $controllerName = '\\Application\\Controller\\' . self::$controller . 'Controller';
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
        return './app/view/' . strtolower(self::$controller) . '/' . self::$action . '.phtml';
    }

    protected function getLayoutFile() {
        return './app/layout/layout.phtml';
    }

}
