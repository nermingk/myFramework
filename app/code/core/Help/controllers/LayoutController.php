<?php
class Help_LayoutController extends Core_Controller_Abstract
{
    protected $page;

    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('help/layout/default');
    }

    public function indexAction()
    {
        # main content use custom View object (Help_View_Layout)
        $content = $this->getView('help/view/layout');

        $this->page->setContent($content)->render();
    }

}