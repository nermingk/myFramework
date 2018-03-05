<?php
class Prijava_View_Section_Index extends Core_View_Default
{
    public function _init()
    {
        $this->setTemplate(App::getConfig('Prijava','template/section/index'));
        $this->setTitle("Sections");
    }
}