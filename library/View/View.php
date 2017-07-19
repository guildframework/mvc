<?php

namespace Guild\View;

use Guild\Http\Response;
use Guild\Mvc\Router;
use Guild\View\Model\ViewModel;

class View
{
    /**
     * @var Response
     */
    protected $response;

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
        'form' => 'Guild\Form\View\Helper\Form',
        'formlabel' => 'Guild\Form\View\Helper\FormLabel',
        'forminput' => 'Guild\Form\View\Helper\FormInput',
        'formrow' => 'Guild\Form\View\Helper\FormRow',
        'formbutton' => 'Guild\Form\View\Helper\FormButton',
        'formsubmit' => 'Guild\Form\View\Helper\FormSubmit',
        'formtextarea' => 'Guild\Form\View\Helper\FormTextarea',
    );
    protected $__pluginCache = array();

    public function __construct($configuration = array())
    {
        self::$config = $configuration;
        $this->setBasePath();
    }

    protected function setBasePath()
    {
        $basePath = new $this->helpers['basepath'];
        $basePath->setBasePath(self::$config['base_path']);
        $this->__pluginCache['basepath'] = $basePath;
    }

    public function setViewFile(Router $router)
    {
        $this->viewFile = './app/view/' . strtolower($router->getController()) . '/' . $router->getAction() . '.phtml';
        if (!file_exists($this->viewFile)) {
            throw new \Exception('Template file not found');
        }
        return $this;
    }

    public function setLayoutFile()
    {
        $this->layoutFile = './app/view/layout/layout.phtml';
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function render(ViewModel $model)
    {
        $this->model = $model;
        $response = new Response();
        ob_start();
        include $this->viewFile;
        $this->content = ob_get_clean();
        ob_start();
        include $this->layoutFile;
        $output = ob_get_clean();
        $response->setContent($output);
        return $response;
    }

    public function __get($name)
    {
        return $this->model->get($name);
    }

    public function __call($methodName, $argv)
    {
        $method = strtolower($methodName);
        if (array_key_exists($method, $this->helpers)) {
            return $this->helper($method, $argv);
        } else {
            die('Helper ' . $methodName . ' not registered');
        }
    }

    public function helper($method, $argv)
    {
        if (!isset($this->__pluginCache[$method])) {
            $this->__pluginCache[$method] = new $this->helpers[$method];
        }
        if (is_callable($this->__pluginCache[$method])) {
            return call_user_func_array($this->__pluginCache[$method], $argv);
        }
        return $this->__pluginCache[$method];
    }

    /**
     * Get response object
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}
