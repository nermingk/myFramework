<?php

abstract class Core_Layout_Abstract extends Varien_Object
{
    protected $layoutPathsScope = "frontend"; // Valid values: 'frontend' and 'admin'
    protected $layoutPaths = array();
    protected $layout;
    protected $layoutPath;
    protected $head;
    protected $content;
    protected $bottom;

    protected $navbar;
    protected $sidebar;
    protected $debug;
    /**
     * Core_Layout_Abstract constructor.
     */
    public function __construct()
    {
        parent::__construct();

        # load layout pats (core and local)
        $this->layoutPaths = App::getConfig('Core','layoutPath/'.$this->layoutPathsScope);

        $this->_construct();

        $this->_init();
    }

    public function _construct()
    {
        # <head> tag
        $this->head     = new Core_View_Html_Head();
        # navbar
        $this->navbar   = new Core_View_Html_Navbar();
        # sidebar
        $this->sidebar  = new Core_View_Html_Sidebar();
        # main content
        $this->content  = new Core_View_Default();
        # before </body>
        $this->bottom   = new Core_View_Html_Bottom();
        $this->debug    = new Core_View_Html_Debug();
    }

    # use to set up default layout
    protected function _init()
    {
        # set default layout
        # $this->setLayout(App::getConfig('Core','layout/default'));
    }

    /**
     * @param $layoutTemplatePath
     * @return Core_Layout_Abstract
     */
    public function setLayoutTemplate($layoutTemplatePath)
    {
        $this->layout = $layoutTemplatePath;

        $appRoot = App::getAppRoot();

        $coreLayoutFile = $appRoot . $this->layoutPaths['core'] . $this->layout;
        $localLayoutFile = $appRoot . $this->layoutPaths['local'] . $this->layout;

        # check local folder first
        if(file_exists($localLayoutFile))
        {
            $this->layoutPath = $localLayoutFile;
        }
        elseif(file_exists($coreLayoutFile))
        {
            $this->layoutPath = $coreLayoutFile;
        }
        else
        {
            die("Can't find layout:" . $this->layoutPath);
        }

        return $this;
    }

    protected function getLayout()
    {
        return $this->layout;
    }
    /**
     * @return Core_View_Html_Head
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setHead(Core_View_Default $view)
    {
        $this->head = $view;
        return $this;
    }

    /**
     * @return Core_View_Html_Navbar
     */
    public function getNavbar()
    {
        return $this->navbar;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setNavbar(Core_View_Default $view)
    {
        $this->navbar = $view;
        return $this;
    }

    /**
     * @return Core_View_Default
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setContent(Core_View_Default $view)
    {
        $this->content = $view;
        return $this;
    }

    /**
     * @return Core_View_Html_Sidebar
     */
    public function getSidebar()
    {
        return $this->sidebar;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setSidebar(Core_View_Default $view)
    {
        $this->sidebar = $view;
        return $this;
    }

    /**
     * @return Core_View_Html_Bottom
     */
    public function getBottom()
    {
        return $this->bottom;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setBottom(Core_View_Default $view)
    {
        $this->bottom = $view;
        return $this;
    }

    /**
     * @return Core_View_Html_Debug
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param Core_View_Default $view
     * @return Core_Layout_Abstract
     */
    public function setDebug(Core_View_Default $view)
    {
        $this->debug = $view;
        return $this;
    }

    /**
     *
     */
    public function render()
    {
        if(file_exists($this->layoutPath))
        {
            # todo: make this on/off
            if(get_class($this) != "Core_View_Html_Debug"){

                $data = [
                    'template' => str_replace(App::getAppRoot(),"/app",$this->layoutPath),
                    'class' => get_class($this),
                    'class_parents' => array_values(class_parents($this)),
                    'added_from' => __METHOD__
                ];

                $_SESSION['layout'] = $data;
            }
            require_once $this->layoutPath;
        }
        else
        {
            die("Can't find layout:" . $this->layoutPath);
        }
    }

}