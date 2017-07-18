<?php

namespace Guild\View\Model;

class ViewModel {

    public $variables;

    public function __construct($variables = array()) {
//        echo '555';
        if (!empty($variables)) {
            foreach ($variables as $key => $value) {
                $this->variables[(string) $key] = $value;
            }
        }
//        var_dump($this->variables);
    }

    public function get($name) {
        return $this->variables[$name];
    }


}
