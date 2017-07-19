<?php

namespace Guild\Mvc;

use Guild\Http\Headers;
use Guild\Http\Response;
use Guild\View\View;

class Application
{
    public static $config = array();

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
            $model = $controller->$actionName();
            if ($model instanceof Response) {
                $this->completeRequest($model);

            } else {
                $view = new View(self::$config);
                $view->setViewFile($router)->setLayoutFile();
                $response = $view->render($model);
                $response->setStatusCode(200);
                $headers = new Headers();
                $headers->addHeaders(array('Content-Type' => 'text/html;charset=UTF-8',));
                $response->setHeaders($headers);
                $this->completeRequest($response);
            }
        } catch (\Exception $exception) {
            print_r($exception->getMessage());
        }

    }

    protected function completeRequest($response)
    {
        $response->sendHeaders();
        $response->sendContent();
//        echo $response->getContent();
    }

}
