<?php
class Core_View_Homepage extends Core_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Core','template/homepage'));
        $this->setTitle('Core_View_Homepage');
    }
}