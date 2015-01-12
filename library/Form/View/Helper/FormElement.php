<?php

namespace Mvc\Form\View\Helper;

class FormElement {

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $elementHelpers = array(
            'textarea' => 'Mvc\Form\View\Helper\FormTextarea',
            'select' => 'Mvc\Form\View\Helper\FormSelect',
        );
        $type = $element->getType();
        if(isset($type)){
            $helper = new $elementHelpers[$type];
        }  else {
            
        $helper = new \Mvc\Form\View\Helper\FormInput();
        }
        #print_r($element->type);
        return $helper($element);
    }

}
