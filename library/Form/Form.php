<?php

namespace Guild\Form;

use Guild\Form\Element;

class Form
{

    protected $attributes = array('action' => '', 'method' => 'post');
    protected $elements = array();
    protected $filter;
    protected $data;


    /**
     * Set Form attribute
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get form attributes
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add element to form
     * @param $element
     */
    public function add($element)
    {
        $this->elements[$element['name']] = new Element($element);
        if ($element['type'] == 'file') {
            $this->setAttribute('enctype', 'multipart/form-data');
        }
    }

    /**
     * Get Form Element
     * @param $elementName
     * @return mixed
     * @throws \Exception
     */
    public function get($elementName)
    {
        if (!isset($this->elements[$elementName])) {
            throw new \Exception("Element &quot;$elementName&quot; doesn't exists in form");
        }
        return $this->elements[$elementName];
    }

    /**
     * Get all form Elements
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function setInputFilter($inputFilter)
    {
        $this->filter = $inputFilter;
    }

    public function setData($data)
    {
        $this->data = $data;
        foreach ($data as $name => $value) {
            $element = $this->get($name);
            $element->setValue($value);
        }
    }

    public function isValid()
    {
        $filter = $this->filter;
        $filter->setData($this->data);
        $this->isValid = $result = $filter->isValid();
        if (!$result) {
            $this->setMessages($filter->getMessages());
        }
        return $this->isValid;
    }

    public function setMessages($messages)
    {
        foreach ($messages as $key => $messageSet) {
            $element = $this->get($key);
            $element->setMessages($messageSet);
        }

        return $this;
    }

    public function getData()
    {
        return $this->filter->getValues();
    }

}
