<?php

namespace Mvc\Form\View\Helper;

class FormSelect extends AbstractHelper {

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $attributes = $element->getAttributes();
        $attributes['name'] = $element->getName();
        $options = $element->getOption('value_options');
        $value = $element->getValue();
        return sprintf('<select %s>%s</select>', $this->createAttributesString($attributes), $this->renderOptions($options, $value));
    }

    public function renderOptions(array $options, $value) {
        $optionStrings = array();
        foreach ($options as $key => $value) {
            $optionStrings[] = sprintf('<option value="%s">%s</option>', $key, $value);
        }
        return implode("\n", $optionStrings);
    }

}
