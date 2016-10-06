<?php

namespace Guild\View\Helper;

class Translate {

    public function __invoke($message, $textDomain = null, $locale = null) {
        return $message;
    }

}
