<?php
abstract class Core_Model_Collection_Abstract extends Varien_Data_Collection
{
    protected $_db;
    protected $_table;

    protected $_select;


    public function __construct()
    {
        parent::__construct();
        $this->_db = App::Database();
        $this->_init();

    }

    protected function _init() {

    }


    public function loadResults()
    {


        # add filters and order to select
        $this->_prepareSelect();


        $rows = $this->_db->getResults($this->getSelect());

        if(!$rows) return $this;


        foreach($rows as $_row)
        {
            $item = $this->getNewEmptyItem();
            $item->setData($_row);
            $item->setIsObjectNew(false);
            $this->addItem($item);
        }

        return $this;
    }

    private function _prepareSelect()
    {
        $sql = "SELECT * FROM " . $this->_table;

        $filters = $this->_filters;

        if (!empty($filters)) {
            foreach ($filters as $key => $_filter) {
                # first filter fo not need type: and / or
                if ($key == 0) {
                    $filterStr = $_filter->getField() . "='" . $_filter->getValue() . "'";
                } # type: and / or
                else {
                    $filterStr = $filterStr . " " . $_filter->getType() . " " . $_filter->getField() . "='" . $_filter->getValue() . "'";
                }
            }

            $sql = $sql . " WHERE (" . $filterStr . ")";
        }

        if($this->_orders)
        {

            $orders = "";
            foreach($this->_orders as $field => $type)
            {
                $orders = $orders . $field . " ". $type . ',';
            }

            $sql = $sql . " ORDER BY ".rtrim($orders,',');
        }


        $this->_select = $sql;
    }


    public function getSelect()
    {
        return $this->_select;
    }



}