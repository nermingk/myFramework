<?php
class Admin_View_Html_Navbar extends Admin_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Admin','template/html/navbar'));
    }
}