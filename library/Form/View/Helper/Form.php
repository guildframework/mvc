<?php

namespace Guild\Form\View\Helper;

class Form extends AbstractHelper
{

    protected $formLayout = null;

    public function __invoke($layout = null)
    {
        if ($layout) {
            $this->formLayout = $layout;
        }
        return $this;
    }

    public function openTag($form = null)
    {
        if ($this->formLayout == 'horizontal') {
            $form->setAttribute('class', 'form-horizontal');
            foreach ($form->getElements() as $element){
                $element->setOption('layout','horizontal');
            }
        }
        $formAttributes = $form->getAttributes();
        $tag = sprintf('<form %s>', $this->createAttributesString($formAttributes)) . PHP_EOL;
        return $tag;
    }

    public function closeTag()
    {
//        print_r($this->formLayout);
        return '</form>' . PHP_EOL;
    }

}
