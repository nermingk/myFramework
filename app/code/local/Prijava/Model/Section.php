<?php
class Prijava_Model_Section extends Core_Model_Abstract
{
    protected function _init()
    {
        $this->setTable('section');
        $this->setIdFieldName('id');
    }


}