<?php
class Admin_View_Default extends Core_View_Default
{
    protected $templatePathsScope = "admin"; // Valid values: 'frontend' and 'admin'
    protected function _init()
    {
        # set default template
        $this->setTemplate(App::getConfig('Admin','template/blank'));
    }
}