<?php
class Help_DebugController extends Core_Controller_Abstract
{
    protected $page;

    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('help/layout/default');
    }

    public function indexAction()
    {
        $view = $this->getView()->setTemplate('help/debug.phtml');
        $view->setTitle('Debug');
        $this->page->setContent($view)->render();
    }


}