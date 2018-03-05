<?php
abstract class Admin_Controller_Abstract extends Core_Controller_Abstract
{

    /**
     * @param string $layoutClassPath
     * @return Admin_Layout_Default
     */
    protected function getLayout($layoutClassPath = '')
    {
        if(!$layoutClassPath)
        {
            return new Admin_Layout_Default();
        }
        else
        {
            $className = App::getClassName($layoutClassPath);
            return new $className;
        }
    }

    /**
     * @param string $viewClassPath
     * @return Admin_View_Default
     */
    protected function getView($viewClassPath = '')
    {
        if(!$viewClassPath)
        {
            return new Admin_View_Default();
        }
        else
        {
            $className = App::getClassName($viewClassPath);
            return new $className;
        }
    }
}