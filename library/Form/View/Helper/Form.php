<?php

namespace Mvc\Form\View\Helper;

class Form extends AbstractHelper {

    public function openTag($form = null) {
        $formAttributes = $form->getAttributes();
        $tag = sprintf('<form %s>', $this->createAttributesString($formAttributes)) . PHP_EOL;
        return $tag;
    }

    public function closeTag() {
        return '</form>' . PHP_EOL;
    }

}
