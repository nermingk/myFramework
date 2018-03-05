<?php
abstract class Core_View_Abstract extends Varien_Object
{
    protected $templatePathsScope = "frontend"; // Valid values: 'frontend' and 'admin'
    protected $templatePaths = array();
    protected $template;
    protected $templatePath;
    protected $params;

    public function __construct()
    {
        parent::__construct();

        # load layout pats (core and local)
        $this->templatePaths = App::getConfig('Core','templatePath/'.$this->templatePathsScope);

        $this->_construct();

        $this->_init();
    }

    public function _construct()
    {
        $this->params = new Varien_Object();
    }

    protected function _init()
    {
        # set default template
        # $this->setTemplate(App::getConfig('Core','template/blank'));
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        $appRoot = App::getAppRoot();

        $coreTemplateFile = $appRoot . $this->templatePaths['core'] . $this->template;
        $localTemplateFile = $appRoot . $this->templatePaths['local'] . $this->template;

        # check local folder first
        if(file_exists($localTemplateFile))
        {
            $this->templatePath = $localTemplateFile;
        }
        elseif(file_exists($coreTemplateFile))
        {
            $this->templatePath = $coreTemplateFile;
        }
        else
        {
            die("Can't find template:" . $this->templatePath);
        }

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplatePath()
    {
        return str_replace(App::getAppRoot(),"/app",$this->templatePath);
    }


    public function getParams()
    {
        return $this->params;
    }


    public function setParams($object)
    {
        $this->params = $object;
    }

    public function render()
    {
        # todo: make this on/off
        if(get_class($this) != "Core_View_Html_Debug"){
            $view = new Varien_Object();
            $data = [
                'template' => $this->getTemplatePath(),
                'class' => get_class($this),
                'class_parents' => array_values(class_parents($this)),
                'params' => $this->getParams(),
                'added_from' => __METHOD__
            ];
            $view->setData($data);
            $_SESSION['view'] = $data;
        }

        require_once $this->templatePath;
    }




}