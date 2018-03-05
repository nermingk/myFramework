<?php
class Help_ModuleController extends Core_Controller_Abstract
{
    protected $page;

    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('help/layout/module');
    }

    public function indexAction()
    {
        # main content use custom View object (Help_View_Module)
        $content = $this->getView('help/view/module');

        $this->page->setContent($content)->render();
    }

    public function createAction()
    {
        $content = $this->getView();
        $content->setTemplate('help/module/create.phtml');
        //$content->setTitle("aaaaaaa");

        $this->page->setContent($content)->render();
    }

}