<?php
class Admin_View_Homepage extends Admin_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Admin','template/homepage'));
        //$this->setTitle('Admin_View_Homepage');
    }
}