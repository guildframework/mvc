<?php
/**
 *
 */

namespace Guild\Mvc;

use Guild\Filter\Word\CamelCase;

class Router
{
    protected $uriParts;

    protected function getUriParts()
    {
        if (!$this->uriParts) {
            $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
            $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
            if (strstr($uri, '?')) {
                $uri = substr($uri, 0, strpos($uri, '?'));
            }
//            $uriTri = '/' . trim($uri, '/');
            $this->uriParts = explode('/', trim($uri, '/'));
        }
        return $this->uriParts;
    }

    public function getController()
    {
        $uriParts = $this->getUriParts();
        $controller = 'index';
        if (isset($uriParts[0]) && !empty($uriParts[0])) {
            $controller = $uriParts[0];
        }
        $filter = new CamelCase();
        return $filter->dashToCamelCase($controller);
    }

    public function getAction()
    {
        $uriParts = $this->getUriParts();
        $action = 'index';
        if (isset($uriParts[1]) && !empty($uriParts[1])) {
            $action = $uriParts[1];
        }
        $filter = new CamelCase();
        return $filter->dashToCamelCase($action, false);
//        return $filter->dashToCamelCase($uriParts[1], false);
    }

}