<?php

namespace Mvc\View\Helper;

class HeadTitle {

    public $items = array();
    public $separator = ' | ';

    public function __invoke($title = null) {
        if ($title != NULL) {
            $this->append($title);
        }
        return $this->renderTitle();
    }

    public function append($title) {
        $this->items[] = (string) $title;
    }

    public function renderTitle() {
        return implode($this->separator, $this->items);
    }

    public function __toString() {
        return $this->renderTitle();
    }

}
