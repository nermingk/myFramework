<?php
class Help_View_Homepage extends Core_View_Default
{
    protected function _init()
    {
        $this->setTemplate(App::getConfig('Help','template/homepage'));

        /*

        OR

        $this->setTemplate('help/homepage.phtml');

        */
    }
}