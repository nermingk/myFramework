<?php
abstract class Core_Model_Abstract extends Varien_Object
{

    protected $_table;
    protected $_isObjectNew = true;


    protected function _construct()
    {
        parent::_construct();
        $this->_init();
    }

    protected function _init() {

    }

    public function getTable()
    {
        return $this->_table;
    }


    public function setTable($table)
    {
        $this->_table = $table;
    }

    public function load($id)
    {
        $sql = "SELECT * FROM ".$this->_table." WHERE ".$this->getIdFieldName()."=".$id;
        $row = App::Database()->getRow($sql);

        $safeValuesArray = array();
        foreach($row as $field => $value)
        {
            $safeValuesArray[$field] = htmlspecialchars($value);
        }
        $this->setData($safeValuesArray);

        # unset data if loaded from unexisting id
        if(!$this->getId()) $this->unsetData();

        $this->_afterLoad();

        return $this;

    }

    private function _afterLoad()
    {
        if($this->getId())
        {
            $this->_isObjectNew = false;
            $this->_origData = $this->_data;
        }
    }

    /**
     * @return boolean
     */
    public function getIsObjectNew()
    {
        return $this->_isObjectNew;
    }

    /**
     * @param boolean $isObjectNew
     */
    public function setIsObjectNew($isObjectNew)
    {
        $this->_isObjectNew = $isObjectNew;
    }


    public function getCollection()
    {
        $collectionClassName =  get_class($this) . "_Collection";
        return new $collectionClassName;
    }

    public function save()
    {
        $data = $this->getData();

        # add new record
        if($this->_isObjectNew)
        {
            $newId = App::Database()->addRow($this->_table,$this->_idFieldName,$data);

            if($newId)
            {
                $this->load($newId);
            }
            else
            {
                throw new Exception("Error in adding new record.");
            }
        }
        # update current record
        else
        {

            App::Database()->updateRow($this->_table,$this->_idFieldName,$data);
            $this->load($this->getId());
        }
    }


}