<?php

namespace Guild\View\Helper;

class Url {

    protected $controller;
    protected $action;
    protected $id;

    public function __invoke($params = [], $options = [], $reuseMatchedParams = false) {
//        echo '555';
//        print_r($params);
//        die();
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
