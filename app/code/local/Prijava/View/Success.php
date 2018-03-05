<?php
class Prijava_View_Success extends Core_View_Default
{
    public function _init()
    {
        $this->setTemplate(App::getConfig('Prijava','template/success'));
        $this->setTitle("Prijava");
    }
}