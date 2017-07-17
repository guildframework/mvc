<?php

namespace Guild\Form\View\Helper;

class FormTextarea extends AbstractHelper {

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $attributes = $element->getAttributes();
        $attributes['name'] = $element->getName();
        $content = (string) $element->getValue();
        return sprintf('<textarea %s>%s</textarea>', $this->createAttributesString($attributes), $content);
    }

}
