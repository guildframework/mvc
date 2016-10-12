<?php

namespace Guild\View\Model;

class ViewModel {

    public $variables;

    public function __construct($variables = array()) {
        if (!empty($variables)) {
            foreach ($variables as $key => $value) {
                $this->variables[(string) $key] = $value;
            }
        }
    }

    public function get($name) {
        return $this->variables[$name];
    }


}
