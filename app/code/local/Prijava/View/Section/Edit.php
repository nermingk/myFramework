<?php
class Prijava_View_Section_Edit extends Core_View_Default
{
    public function _init()
    {
        $this->setTemplate(App::getConfig('Prijava','template/section/edit'));
        $this->setTitle("Section/Edit");
    }

}