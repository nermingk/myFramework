<?php
class Prijava_View_Index extends Core_View_Default
{
    public function _init()
    {
        $this->setTemplate(App::getConfig('Prijava','template/index'));
        $this->setTitle("Prijava");
    }
}