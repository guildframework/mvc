<?php

namespace Mvc\View;

class ViewModel {

    /**
     * @var array Cache for the plugin call
     */
    private $__pluginCache = array();
    public $variables;
    protected $helpers = array(
        'headtitle'     => 'Mvc\View\Helper\HeadTitle',
        'headmeta'      => 'Mvc\View\Helper\HeadMeta',
        'headstyle'     => 'Mvc\View\Helper\HeadStyle',
        'useridentity'  => 'Mvc\View\Helper\UserIdentity',       
        'gravatar'      => 'Mvc\View\Helper\Gravatar',
        'headlink'      => 'Mvc\View\Helper\HeadLink',
        'headscript'    => 'Mvc\View\Helper\HeadScript',
        'inlinescript'  => 'Mvc\View\Helper\InlineScript',
        'form'          => 'Mvc\Form\View\Helper\Form',
        'formlabel'     => 'Mvc\Form\View\Helper\FormLabel',
        'forminput'     => 'Mvc\Form\View\Helper\FormInput',
        'formrow'       => 'Mvc\Form\View\Helper\FormRow',     
        'formbutton'    => 'Mvc\Form\View\Helper\FormButton',
        'formtextarea'  => 'Mvc\Form\View\Helper\FormTextarea',
    );

    public $viewFile;
    public $layoutFile;
    public $userHelper = NULL;
    public $formHelper = NULL;
    public $issueHelper = NULL;
    public $terminate = FALSE;

    public function __construct($variables = null) {
        if (!empty($variables)) {
            foreach ($variables as $key => $value) {
                $this->variables[(string) $key] = $value;
            }
        }
        $this->setViewPath();
        $this->run();
    }

    public function __get($name) {
        return $this->variables[$name];
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

    public function basePath($file = NULL) {
        $scriptFile = filter_input(INPUT_SERVER, 'PHP_SELF');
        if (isset($file)) {
            return str_replace('index.php', '', $scriptFile) . $file;
        } else {
            return str_replace('index.php', '', $scriptFile);
        }
    }

    public function setViewPath() {
        $module = \Mvc\Application::$module;
        $controller = \Mvc\Application::$controller;
        $action = \Mvc\Application::$action;
        $this->viewFile = './module/' . $module . '/view/' . strtolower($controller) . '/' . $action . '.phtml';
        $this->layoutFile = './module/' . $module . '/view/layout/layout.phtml';
    }

    public function issues() {
        if (!isset($this->issueHelper)) {
            require 'application/library/View/Helper/Issues.php';
            $this->issueHelper = new \View\Helper\Issues();
        }
        return $this->issueHelper;
    }

    public function setTerminal($terminate) {
        $this->terminate = (bool) $terminate;
        return $this;
    }

    public function run() {

        ob_start();
        require $this->viewFile;
        $this->content = ob_get_clean();
        if ($this->terminate) {
            echo $this->content;
        } else {
            require $this->layoutFile;
        }
    }

}
