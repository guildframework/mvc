<?php

namespace Mvc\View\Helper;

class HeadLink {

    public $items = array();

    public function appendStyleSheet($href) {
        $this->items[] = array('type' => 'text/css', 'href' => $href, 'rel' => 'stylesheet');
        return $this;
    }

    public function __toString() {
        
        foreach ($this->items as $item) {
            $links[] = $this->itemToString($item);
        }
        return implode("\n", $links);
    }

    public function itemToString($item) {
        $link = '<link';
        foreach ($item as $key => $value) {
            $link .= sprintf(' %s="%s"', $key, $value);
        }
        $link .= '>';
        return $link;
    }

}
