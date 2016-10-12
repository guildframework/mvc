<?php

namespace Guild\View\Helper;

class Url {

    protected $controller;
    protected $action;
    protected $id;

    public function __invoke($params = [], $options = [], $reuseMatchedParams = false) {
        $url = '';
        if (isset($params['controller'])) {
            $url .= '/' . $params['controller'];
        }
        if (isset($params['action'])) {
            $url .= '/' . $params['action'];
        }
        return $url;
    }

}
