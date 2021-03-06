<?php

namespace Guild\View\Helper;

class HeadMeta {

    protected $container;

    public function appendName($typeValue, $content, $modifiers = array()) {
        $item = $this->createData('name', $typeValue, $content, $modifiers);
        $this->container[] = $item;
        return $this;
    }

    public function itemToString($item) {
        $type = $item->type;
        $modifiersString = '';
        $tpl = '<meta %s="%s" content="%s"%s />';
        $meta = sprintf($tpl, $type, htmlspecialchars($item->$type), htmlspecialchars($item->content), $modifiersString);
        return $meta;
    }

    public function createData($type, $typeValue, $content, array $modifiers) {
        $data = new \stdClass;
        $data->type = $type;
        $data->$type = $typeValue;
        $data->content = $content;
        $data->modifiers = $modifiers;
        return $data;
    }

    public function appendHttpEquiv($keyValue, $content, $modifiers = array()) {
        $item = $this->createData('http-equiv', $keyValue, $content, $modifiers);
        $this->container[] = $item;
        return $this;
    }

    public function __toString() {
        $items = array();
        foreach ($this->container as $item) {
            $items[] = $this->itemToString($item);
        }
        return implode("\n", $items);
    }

}
