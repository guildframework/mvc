<?php

namespace Guild\Form\View\Helper;

class FormElement {

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $elementHelpers = array(
            'textarea' => 'Guild\Form\View\Helper\FormTextarea',
            'select' => 'Guild\Form\View\Helper\FormSelect',
            'file' => 'Guild\Form\View\Helper\FormFile',
            'checkbox' => 'Guild\Form\View\Helper\FormCheckbox',
            'submit' => 'Guild\Form\View\Helper\FormSubmit',
        );
        $type = $element->getType();
        if(isset($type)){
            $helper = new $elementHelpers[$type];
        }  else {
            
        $helper = new \Guild\Form\View\Helper\FormInput();
        }
        return $helper($element);
    }

}
