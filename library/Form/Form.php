<?php

namespace Mvc\Form;

use Mvc\Form\Element;

class Form {
    
    protected $attributes = array('action' => '', 'method' => 'post');
    protected $elements = array();
    protected $filter;
    protected $data;

    public function setAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function add($element) {
        $this->elements[$element['name']] = new Element($element);
    }

    public function get($elementName) {
        return $this->elements[$elementName];
    }

    public function setInputFilter($inputFilter) {
        $this->filter = $inputFilter;
    }

    public function setData($data) {
        $this->data = $data;
        foreach ($data as $name => $value) {
            $element = $this->get($name);
            $element->setValue($value);
        }
    }

    public function isValid() {
        $filter = $this->filter;
        $filter->setData($this->data);
        $this->isValid = $result = $filter->isValid();
        if (!$result) {
            $this->setMessages($filter->getMessages());
        }
        return $this->isValid;
    }

    public function setMessages($messages) {
        foreach ($messages as $key => $messageSet) {
            $element = $this->get($key);
            $element->setMessages($messageSet);
        }

        return $this;
    }

    public function getData() {
        return $this->filter->getValues();
    }

}
