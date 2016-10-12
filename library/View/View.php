<?php

namespace Guild\View;

class View {

    public static $config = array();
    protected $viewFile;
    protected $layoutFile;
    protected $model;
    protected $helpers = array(
        'basepath' => 'Guild\View\Helper\BasePath',
        'headtitle' => 'Guild\View\Helper\HeadTitle',
        'headmeta' => 'Guild\View\Helper\HeadMeta',
        'headstyle' => 'Guild\View\Helper\HeadStyle',
        'url' => 'Guild\View\Helper\Url',
        'translate' => 'Guild\View\Helper\Translate',
        # 'useridentity' => 'Guild\View\Helper\UserIdentity',
        # 'gravatar' => 'Guild\View\Helper\Gravatar',
        'headlink' => 'Guild\View\Helper\HeadLink',
        'headscript' => 'Guild\View\Helper\HeadScript',
        'inlinescript' => 'Guild\View\Helper\InlineScript',
            /*    'form' => 'Guild\Form\View\Helper\Form',
              'formlabel' => 'Guild\Form\View\Helper\FormLabel',
              'forminput' => 'Guild\Form\View\Helper\FormInput',
              'formrow' => 'Guild\Form\View\Helper\FormRow',
              'formbutton' => 'Guild\Form\View\Helper\FormButton',
              'formtextarea' => 'Guild\Form\View\Helper\FormTextarea', */
    );
    protected $__pluginCache = array();

    public function __construct($configuration = array()) {
        self::$config = $configuration;
        $this->setBasePath();
    }

    protected function setBasePath() {
        $basePath = new $this->helpers['basepath'];
        $basePath->setBasePath(self::$config['base_path']);
        $this->__pluginCache['basepath'] = $basePath;
    }

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

    public function __get($name) {
        return $this->model->get($name);
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
