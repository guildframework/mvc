<?php

namespace Mvc\View\Helper;

class HeadStyle {

    public $items = array();

    public function appendStyle($value) {
        $this->items[] = (string) $value;
    }

    public function __toString() {
        $html = '<style type="text/css">'. implode("\n", $this->items).'</style>';
        return $html;
    }

}
