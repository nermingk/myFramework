<?php
class Core_IndexController extends Core_Controller_Abstract
{
    public function indexAction()
    {
        $content = $this->getView('core/view/homepage');
        $page = $this->getLayout();
        $page->setContent($content);
        $page->render();

    }
}