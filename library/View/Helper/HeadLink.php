<?php

namespace Guild\View\Helper;

class HeadLink {

    public $items = array();

    public function appendStyleSheet($href, $media = 'screen') {
        $this->items[] = array('type' => 'text/css', 'href' => $href, 'rel' => 'stylesheet', 'media' => $media);
        return $this;
    }

    public function prependStylesheet($href, $media = 'screen') {
        $items = $this->items;
        array_unshift($items, array('type' => 'text/css', 'href' => $href, 'rel' => 'stylesheet', 'media' => $media));
        $this->items = $items;
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
