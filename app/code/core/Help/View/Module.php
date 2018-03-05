<?php
class Help_View_Module extends Core_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Help','template/module'));
    }
}