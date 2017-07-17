<?php

namespace Guild\Form\View\Helper;

class FormInput extends AbstractHelper
{

    public function __invoke($element = null)
    {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element)
    {
        $attributes = $element->getAttributes();
        $attributes['name'] = $element->getName();
        $attributes['value'] = $element->getValue();
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' form-control';
        } else {
            $attributes['class'] = 'form-control';
        }
        return sprintf('<input %s>', $this->createAttributesString($attributes));
    }

}
