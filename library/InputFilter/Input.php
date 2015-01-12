<?php

namespace Mvc\InputFilter;

class Input {

    protected $name;
    protected $required = true;
    protected $value;
    protected $validators = array();
    protected $filters = array();

    public function setName($name) {
        $this->name = (string) $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setRequired($required) {
        $this->required = (bool) $required;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValue() {
        $value = $this->value;
        foreach ($this->filters as $filter) {
            $value = filter_var($value, $filter['id']);
        }
        return $value;
    }

    public function isRequired() {
        return $this->required;
    }

    public function setValidators($validators) {
        $this->validators = $validators;
    }

    public function getValidators() {
        return $this->validators;
    }

    public function setFilters($filters) {
        $this->filters = $filters;
    }

}
