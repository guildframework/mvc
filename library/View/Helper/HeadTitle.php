<?php

namespace Guild\View\Helper;

class HeadTitle {

    public $items = array();
    public $separator = ' | ';
    protected $autoEscape = false;

    public function __invoke($title = null) {
        if ($title != NULL) {
            $this->append($title);
        }
        return $this;
    }

    public function append($title) {
        $this->items[] = (string) $title;
    }

    public function __toString() {
        $output = implode($this->separator, $this->items);
        return "<title>$output</title>";
    }

    public function setSeparator($separator) {
        $this->separator = $separator;
        return $this;
    }

    public function setAutoEscape($autoEscape = true) {
        $this->autoEscape = (bool) $autoEscape;
        return $this;
    }

}
