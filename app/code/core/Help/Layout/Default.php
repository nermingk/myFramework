<?php
class Help_Layout_Default extends Core_Layout_Abstract
{
    protected function _init()
    {
        # set default layout .phtml
        $this->setLayoutTemplate(App::getConfig('Help','layout/default'));

        # set navbar template .phtml
        $this->getNavbar()->setTemplate('help/html/navbar.phtml');

        #set sidebar template .phtml
        $this->getSidebar()->setTemplate('help/html/sidebar.phtml');
    }
}