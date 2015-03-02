<?php

namespace Guild\View;

class View {

    protected $viewFile;
    protected $layoutFile;
    protected $model;
    protected $helpers = array(
        'basepath' => 'Guild\View\Helper\BasePath',
        'headtitle' => 'Guild\View\Helper\HeadTitle',
        'headmeta' => 'Guild\View\Helper\HeadMeta',
        'headstyle' => 'Guild\View\Helper\HeadStyle',
       # 'useridentity' => 'Mvc\View\Helper\UserIdentity',
       # 'gravatar' => 'Mvc\View\Helper\Gravatar',
        'headlink' => 'Guild\View\Helper\HeadLink',
        'headscript' => 'Guild\View\Helper\HeadScript',
        'inlinescript' => 'Guild\View\Helper\InlineScript',
    /*    'form' => 'Mvc\Form\View\Helper\Form',
        'formlabel' => 'Mvc\Form\View\Helper\FormLabel',
        'forminput' => 'Mvc\Form\View\Helper\FormInput',
        'formrow' => 'Mvc\Form\View\Helper\FormRow',
        'formbutton' => 'Mvc\Form\View\Helper\FormButton',
        'formtextarea' => 'Mvc\Form\View\Helper\FormTextarea',*/
        
    );
    protected $__pluginCache = array();

    public function setViewFile($viewFile) {
        $this->viewFile = $viewFile;
    }

    public function setLayoutFile($layoutFile) {
        $this->layoutFile = $layoutFile;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function render() {
        ob_start();
        require $this->viewFile;
        $this->content = ob_get_clean();
        require $this->layoutFile;
    }
    
    public function __call($methodName, $argv) {
        $method = strtolower($methodName);
        if (array_key_exists($method, $this->helpers)) {
            return $this->helper($method, $argv);
        } else {
            die('Helper ' . $methodName . ' not registered');
        }
    }

    public function helper($method, $argv) {
        if (!isset($this->__pluginCache[$method])) {
            $this->__pluginCache[$method] = new $this->helpers[$method];
        }
        if (is_callable($this->__pluginCache[$method])) {
            return call_user_func_array($this->__pluginCache[$method], $argv);
        }
        return $this->__pluginCache[$method];
    }

}
