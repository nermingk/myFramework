<?php
class Help_IndexController extends Core_Controller_Abstract
{
    protected $page;

    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('help/layout/default');
    }

    public function indexAction()
    {

        # main content use custom View object (Help_View_Homepage)
        $content = $this->getView('help/view/homepage');

        $this->page->setContent($content)->render();
    }

    public function infoAction()
    {
        # main content use Core View object
        $content = $this->getView()->setTemplate('help/info.phtml');

        $this->page->setContent($content)->render();
    }
}