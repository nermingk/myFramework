<?php
class Core_View_Html_Head extends Core_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Core','template/html/head'));
    }
}