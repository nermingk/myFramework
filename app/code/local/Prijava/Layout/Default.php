<?php
class Prijava_Layout_Default extends Core_Layout_Abstract
{
    protected function _init()
    {
        # set default layout .phtml
        $this->setLayoutTemplate(App::getConfig('Prijava','layout/default'));

        # set navbar template .phtml
        $this->getNavbar()->setTemplate('prijava/html/navbar.phtml');

        #set sidebar template .phtml
        $this->getSidebar()->setTemplate('prijava/html/sidebar.phtml');
    }
}