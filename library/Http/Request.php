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

    public function getFiles($name = null)
    {
//        var_dump($_FILES);
        if ($_FILES[$name]['error'] != 0) {
            throw new \Exception($this->getFileUploadError($_FILES[$name]['error']));
        }
        return $_FILES[$name]['tmp_name'];
    }

    protected function getFileUploadError($code)
    {
        $errors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        return $errors[$code];
    }
}
