<?php

namespace Guild\Form;

class Element
{

    protected $name;
    protected $type;
    protected $attributes = array();
    protected $options = array();
    protected $value;
    protected $messages = array();

    public function __construct($element)
    {
        $this->name = $element['name'];
        if (isset($element['type'])) {
            $this->type = $element['type'];
        }
        if (isset($element['options'])) {
            $this->setOptions($element['options']);
        }
        if (isset($element['attributes'])) {
            $this->setAttributes($element['attributes']);
        }
        if (isset($element['attributes']['id'])) {
            $this->setLabelOption('for', $element['attributes']['id']);
        }
    }

    /**
     * Set single element attribute
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Set multiple element attributes at once
     * @param $attributes array
     */
    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Set element single option
     * @param $key
     * @param $value
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Set element multiple options at once
     * @param $options array
     */
    public function setOptions($options)
    {
        $array = array();
        foreach ($options as $key => $value) {
            $array[$key] = $value;
        }
        $this->options = $array;
    }

    /**
     * Set element label single option
     * @param $key
     * @param $value
     */
    public function setLabelOption($key, $value)
    {
        $this->options['label_attributes'][$key] = $value;
    }


    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getOption($option)
    {
        if (!isset($this->options[$option])) {
            return null;
        }
        return $this->options[$option];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }

}
