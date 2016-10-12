<?php

namespace Guild\View\Helper;

/**
 * 
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
        return $this->basePath;
    }

    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

}
