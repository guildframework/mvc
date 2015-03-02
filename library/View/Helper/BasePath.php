<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Guild\View\Helper;

/**
 * Description of BasePath
 *
 * @author Srdjan
 */
class BasePath {

    protected $basePath;

    public function __invoke($file = NULL) {
        if (isset($file)) {
            return $this->getBasePath() . $file;
        } else {
            return $this->getBasePath();
        }
    }

    public function getBasePath() {
        if (!isset($this->basePath)) {
            $scriptFile = filter_input(INPUT_SERVER, 'PHP_SELF');
            $this->basePath = str_replace('/index.php', '', $scriptFile);
        }
        return $this->basePath;
    }

}
