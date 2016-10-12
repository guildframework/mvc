<?php

namespace Guild\Http;

class Request {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $method = self::METHOD_GET;

    public function __construct() {
        $this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    }

    public function isPost() {
        return ($this->method === self::METHOD_POST);
    }

}
