<?php

namespace Guild\Form\View\Helper;

class FormFile extends FormInput{

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $attributes          = $element->getAttributes();
        $attributes['name']  = $element->getName();
        $attributes['type']  = 'file';
        return sprintf('<input %s>', $this->createAttributesString($attributes));
    }

}
