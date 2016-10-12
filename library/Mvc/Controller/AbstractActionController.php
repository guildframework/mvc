<?php

namespace Guild\Mvc\Controller;

use Guild\Http\Request;

abstract class AbstractActionController {

    protected $request;
    protected $config;

    public function getRequest() {
        if (!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function getConfig() {
        return $this->config;
    }

}
