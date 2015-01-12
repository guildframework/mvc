<?php

namespace Mvc\Form\View\Helper;

class FormButton extends AbstractHelper {

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $markup = '<div class="form-group">';
        $markup .= '<div class="' . $element->getOption('column-size') . '">';
        $markup .= sprintf('<button %s>%s</button>', $this->createAttributesString($element->getAttributes()), $element->getOption('label'));
        $markup .= '</div></div>' . PHP_EOL;
        return $markup;
    }

}
