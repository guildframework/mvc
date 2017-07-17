<?php

namespace Guild\Form\View\Helper;

abstract class AbstractHelper {

    /**
     * Create a string of all attribute/value pairs
     *
     * @param  array $attributes
     * @return string
     */
    public function createAttributesString(array $attributes) {
        $strings = array();
        foreach ($attributes as $key => $value) {
            $strings[] = sprintf('%s="%s"', $key, $value);
        }
        return implode(' ', $strings);
    }

}
