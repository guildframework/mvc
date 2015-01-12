<?php

namespace Mvc\Form\View\Helper;

class FormInput extends AbstractHelper{

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $attributes          = $element->getAttributes();
        $attributes['name']  = $element->getName();
        $attributes['value'] = $element->getValue();
        return sprintf('<input %s>', $this->createAttributesString($attributes));
    }

}
