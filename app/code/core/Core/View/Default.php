<?php
class Core_View_Default extends Core_View_Abstract
{
    protected $title;
    protected $item;
    protected $items;

    protected function _init()
    {
        # set default template
        $this->setTemplate(App::getConfig('Core','template/blank'));
    }
    public function _construct()
    {
        parent::_construct();
        //$this->setTitle(App::getConfig('Core','title'));
        $this->setTitle($this->_createTitleFromUrl());
    }
    private function _createTitleFromUrl()
    {
        if(isset($_GET['url'])){
            $url = $_GET['url'];
            return ucwords(str_replace("/"," | ",$url));
        }
        else{
            return App::getConfig('Core','title');
        }
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }


    /**
     * @param $item
     * @return Core_View_Default
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }


    /**
     * @param $items
     * @return Core_View_Default
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItemClass()
    {
        return get_class($this->getItem());
    }

    public function getItemsClass()
    {
        return get_class($this->getItems());
    }
}