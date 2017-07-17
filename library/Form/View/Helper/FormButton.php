<?php

namespace Guild\Form\View\Helper;

class FormButton extends AbstractHelper
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
        $elementHtml = sprintf('<button %s>%s</button>',
                $this->createAttributesString($element->getAttributes()),
                $element->getOption('label')) . PHP_EOL;
        if ($element->getOption('layout') == 'horizontal') {
            return '<div class="form-group"><div class="col-' . $element->getOption('column-size') . '">' . $elementHtml . '</div></div>' . PHP_EOL;
        }
        return $elementHtml;
    }

}
