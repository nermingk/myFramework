<?php
class Core_Layout_Default extends Core_Layout_Abstract
{
    protected function _init()
    {
        # set default layout
        $this->setLayoutTemplate(App::getConfig('Core','layout/default'));
    }
}