<?php

namespace Guild\Http;

class Request
{

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $method = self::METHOD_GET;

    public function __construct()
    {
        $this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    }

    public function isPost()
    {
        return ($this->method === self::METHOD_POST);
    }

    public function getPost($variable_name = null, $filter = FILTER_DEFAULT, $options = null)
    {
        if ($this->isPost()) {
            if (isset($variable_name)) {
                return filter_input(INPUT_POST, $variable_name, $filter, $options);
            }
            return filter_input_array(INPUT_POST);
        }
        return false;
    }

}
