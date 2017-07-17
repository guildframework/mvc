<?php

namespace Guild\InputFilter;

use Guild\InputFilter\Input;

class InputFilter {

    protected $inputs = array();
    protected $data;
    protected $invalidInputs = array();
    protected $validInputs = array();
    protected $errorMessages = array();

    public function add($input) {
        $name = $input['name'];
        $this->inputs[$name] = $this->createInput($input);
    }

    public function createInput($inputSpecification) {
        $input = new Input;
        foreach ($inputSpecification as $key => $value) {
            switch ($key) {
                case 'name':
                    $input->setName($value);
                    break;
                case 'required':
                    $input->setRequired($value);
                    break;

                case 'filters':
                    $input->setFilters($value);
                    break;
                case 'validators':
                    $input->setValidators($value);
                    break;
                default:
                    // ignore unknown keys
                    break;
            }
        }
        return $input;
    }

    public function setData($data) {
        $this->data = $data;
        foreach (array_keys($this->inputs) as $name) {
            $input = $this->inputs[$name];
            $value = $data[$name];
            $input->setValue($value);
        }
    }

    public function isValid() {

        $inputs = array_keys($this->inputs);
        return $this->validateInputs($inputs);
    }

    protected function validateInputs(array $inputs) {
        $valid = true;
        foreach ($inputs as $name) {
            $input = $this->inputs[$name];
            if (empty($this->data[$name]) && $input->isRequired()) {
                $this->invalidInputs[$name] = $input;
                $this->errorMessages[$name][] = 'This field is Required!';
                $valid = false;
                continue;
            }
            $validators = $input->getValidators();
            foreach ($validators as $validator) {
                $result = filter_var($this->data[$name], $validator['id']);
                if (!$result) {
                    $this->invalidInputs[$name] = $input;
                    $this->errorMessages[$name][] = $validator['message'];
                    $valid = false;
                    continue;
                }
                $this->validInputs[$name] = $input;
                continue;
            }
        }
        return $valid;
    }

    public function getMessages() {
        return $this->errorMessages;
    }

    public function getValues() {
        $values = array();
        foreach ($this->inputs as $input) {
            $values[$input->getName()] = $input->getValue();
        }
        return $values;
    }

}
