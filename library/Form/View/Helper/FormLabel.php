<?php

namespace Mvc\Form\View\Helper;

class FormLabel extends AbstractHelper {

    public function __invoke($element = null) {
        $openTag = $this->openTag($element);
        $content = $element->getOption('label');
        $closeTag = $this->closeTag($element);
        return $openTag . $content . $closeTag;
    }

    public function openTag($element = null) {
        $labelAttributes = $element->getOption('label_attributes');
        if (null === $labelAttributes) {
            return '<label>';
        }
        if (is_array($labelAttributes)) {
            return sprintf('<label %s>', $this->createAttributesString($labelAttributes));
        }
    }

    public function closeTag() {
        return '</label>';
    }

}
