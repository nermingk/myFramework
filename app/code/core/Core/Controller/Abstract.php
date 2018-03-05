<?php
abstract class Core_Controller_Abstract
{


    protected function redirect($controllerPath)
    {
        $location = App::getBaseUrl() . $controllerPath;

        if(!headers_sent())
        {
            header("Location:".$location, TRUE, 302);
            exit;
        }
        exit('<meta http-equiv="refresh" content="0; url='.$location.'" />');
    }


    /**
     * @param string $layoutClassPath
     * @return Core_Layout_Default
     */
    protected function getLayout($layoutClassPath = '')
    {
        if(!$layoutClassPath)
        {
            return new Core_Layout_Default();
        }
        else
        {
            $className = App::getClassName($layoutClassPath);
            return new $className;
        }
    }


    /**
     * @param string $viewClassPath
     * @return Core_View_Default
     */
    protected function getView($viewClassPath = '')
    {
        if(!$viewClassPath)
        {
            return new Core_View_Default();
        }
        else
        {
            $className = App::getClassName($viewClassPath);
            return new $className;
        }
    }
}