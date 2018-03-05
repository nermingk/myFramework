<?php
class Admin_IndexController extends Admin_Controller_Abstract
{
    protected $page;

    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('admin/layout/default');
    }

    public function indexAction()
    {
        //$content = $this->getView('admin/view/homepage');
        $content = $this->getView();
        $this->page->setContent($content)->render();
    }

}