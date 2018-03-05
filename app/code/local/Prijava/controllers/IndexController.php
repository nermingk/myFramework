<?php
class Prijava_IndexController extends Core_Controller_Abstract
{
    protected $page;

    /**
     * Prijava_IndexController constructor.
     */
    public function __construct()
    {
        # set default layout for this controller
        $this->page = $this->getLayout('prijava/layout/default');
    }

    public function indexAction()
    {
        $view = new Prijava_View_Index();
        $this->page->setContent($view)->render();
    }

    public function successAction()
    {
        $view = new Prijava_View_Success();
        $this->page->setContent($view)->render();
    }

}