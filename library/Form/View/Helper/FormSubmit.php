<?php

namespace Guild\Form\View\Helper;

class FormSubmit extends FormButton {

    protected function getType(ElementInterface $element)
    {
        return 'submit';
    }

}
