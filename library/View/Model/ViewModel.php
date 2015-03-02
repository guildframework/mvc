<?php

namespace Guild\View\Model;

class ViewModel {

    public $variables;
    /*   public $userHelper = NULL;
      public $formHelper = NULL;
      public $issueHelper = NULL; */
    public $terminate = FALSE;

    public function __construct($variables = null) {
        if (!empty($variables)) {
            foreach ($variables as $key => $value) {
                $this->variables[(string) $key] = $value;
            }
        }
    }

    public function __get($name) {
        return $this->variables[$name];
    }

    public function setTerminal($terminate) {
        $this->terminate = (bool) $terminate;
        return $this;
    }

}
