<?php

namespace Guild\View\Helper;

class HeadScript {

    public $items = array();

    public function appendFile($src, $type = 'text/javascript', $attrs = array()) {
        $this->items[] = array('type' => $type, 'src' => $src, 'attrs' => $attrs);
        return $this;
    }
    
    public function prependFile($src, $type = 'text/javascript', $attrs = array()) {
        $items = $this->items;
        array_unshift($items, array('type' => $type, 'src' => $src, 'attrs' => $attrs));
        $this->items = $items;
        return $this;
    }

    public function __toString() {
        
        foreach ($this->items as $item) {
            $items[] = $this->itemToString($item);
        }
        return implode("\n", $items);
    }

    public function itemToString($item) {
        $html  = '<script type="' . $item['type'] . '" src="' . $item['src'] . '"></script>';
        return $html;
    }

}