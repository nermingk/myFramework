<?php
class Prijava_View_Section_Add extends Core_View_Default
{
    public function _init()
    {
        $this->setTemplate(App::getConfig('Prijava','template/section/add'));
        $this->setTitle("Section/Add");
    }
}