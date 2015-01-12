<?php

namespace Mvc\Form\View\Helper;

use Mvc\Form\View\Helper\FormLabel;
use Mvc\Form\View\Helper\FormElement;

class FormRow extends AbstractHelper {

    protected $labelHelper;
    protected $elementHelper;

    public function __invoke($element = null) {
        if (!$element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render($element) {
        $labelHelper = $this->getLabelHelper();
        $elementHelper = $this->getElementHelper();

        $markup = '<div class="form-group">';
        $markup .= $labelHelper($element);
        $markup .= '<div class="' . $element->getOption('column-size') . '">';
        $markup .= $elementHelper($element);
        $markup .= $this->renderMessages($element->getMessages());
        $markup .= '</div></div>' . PHP_EOL;
        return $markup;
    }

    public function renderMessages($mesages) {
        $markup ='';
        foreach ($mesages as $mesage) {
            $markup .= '<span class="help-block">'.$mesage.'</span>';
        }
        return $markup;
    }

    protected function getLabelHelper() {
        if ($this->labelHelper) {
            return $this->labelHelper;
        }
        $this->labelHelper = new FormLabel();
        return $this->labelHelper;
    }

    protected function getElementHelper() {
        if ($this->elementHelper) {
            return $this->elementHelper;
        }
        $this->elementHelper = new FormElement();
        return $this->elementHelper;
    }

}
