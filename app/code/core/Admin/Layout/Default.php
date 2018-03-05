<?php
class Admin_Layout_Default extends Core_Layout_Default
{
    protected $layoutPathsScope = "admin"; // Valid values: 'frontend' and 'admin'

    protected function _init()
    {
        # set default layout
        $this->setLayoutTemplate(App::getConfig('Admin','layout/default'));

        # set navbar template .phtml
        $this->setNavbar(new Admin_View_Html_Navbar());
    }
}