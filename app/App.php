<?php


final class App
{
    # Application root absolute path
    # i.e. F:\xampp\htdocs\bnpApp
    static private $_appRoot;

    # Application doucument root absolute path
    # i.e. F:/xampp/htdocs/bnpApp
    static private $_docRoot;

    static protected $database;

    protected $modules;
    protected $routes = array();

    # default route: /home/index/index
    protected $router = 'home';
    protected $controller = 'index';
    protected $action = 'indexAction';


    public function __construct()
    {
        self::setAppRoot();
        $this->loadModules();
        $this->loadRoutes();
    }

    /**
     *
     */
    public function run()
    {
        $this->parseUrl();
    }

    /**
     * @return Database
     */
    public static function Database()
    {
        if(!isset(self::$database))
        {
            self::$database = Database::Connection();
        }

        return self::$database;
    }

    /**
     * @param bool $moduleName
     * @param bool $fields
     * @return bool|mixed|null
     */
    public static function getConfig($moduleName = false, $fields = false)
    {
        if (!$moduleName) return false;

        $config = null;

        $modules = include "config/modules.map.php";

        foreach ($modules as $pool => $names) {
            $poolPath = "code/" . $pool . "/";

            foreach ($names as $name) {
                if ($name == $moduleName) {
                    $configFile = $poolPath . $name . '/etc/config.php';

                    $config = include $configFile;

                    if ($fields) {
                        $fieldNames = explode('/', $fields);

                        foreach ($fieldNames as $_fieldName) {
                            # check if config field exists
                            if (isset($config[$_fieldName])) {
                                $config = $config[$_fieldName];
                            } # reset value and break if there is a error in field name
                            else {
                                $config = null;
                                break;
                            }
                        }

                    }

                    break;
                }

            }

        }


        return $config;

    }

    /**
     *
     */
    protected function loadModules()
    {
        $this->modules = include "config/modules.map.php";
    }

    /**
     *
     */
    protected function loadRoutes()
    {


        foreach ($this->modules as $pool => $modules) {
            $poolPath = "code/" . $pool . "/";

            foreach ($modules as $module) {
                $configFile = $poolPath . $module . "/etc/config.php";

                try {
                    $config = $this->_loadModuleConfig($configFile);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    echo "<br>";
                    echo "Please check module: " . $poolPath . $module;
                    die();
                }

                if ($config['router']) {
                    $routes[$config['router']] = $config['module'];
                }

            }
        }

        $this->routes = $routes;
    }

    /**
     * @param $configFile
     * @return mixed
     * @throws Exception
     */
    private function _loadModuleConfig($configFile)
    {
        if (!file_exists('app/' . $configFile)) {
            $msg = "Can't find config file: " . $configFile;
            throw new Exception($msg);
        }

        return include $configFile;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }


    /*
     returns: array
        [0]     = router name
        [1]     = controller name
        [2]     = controller method
        [3..n]  = params
    */
    /**
     *
     */
    protected function parseUrl()
    {
        $url = false;

        if (isset($_GET['url'])) {
            $url = explode("/", filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

        }


        $params = array();

        # check if router is in request
        if (isset($url[0])) {
            # check if is router declared in modules config files
            if (isset($this->routes[$url[0]])) {
                $this->router = $url[0];
            } else {
                $this->router = "error";
            }
        }

        $moduleName = $this->routes[$this->router];
        unset($url[0]);

        # check if controller name is in request
        if (isset($url[1])) {
            # check if conreoller class exists
            if (class_exists($moduleName . '_' . ucfirst($url[1]) . 'Controller')) {
                $this->controller = $url[1];
                unset($url[1]);
            } else {
                $moduleName = "Error";
            }
        }

        $controllerClassName = $moduleName . '_' . ucfirst($this->controller) . 'Controller';

        $controller = new $controllerClassName;

        if (isset($url[2])) {
            if (method_exists($controller, $url[2] . 'Action')) {
                $this->action = $url[2] . 'Action';
                unset($url[2]);
            } else {
                $controller = new Error_IndexController;
            }
        }

        if ($url) {
            $params = array_values($url);
        }

        call_user_func_array(array($controller, $this->action), $params);
    }


    /**
     * @param string $appRoot
     * @throws Exception
     */
    public static function setAppRoot($appRoot = '')
    {
        if (self::$_appRoot) {
            return;
        }

        if ('' === $appRoot) {
            $appRoot = dirname(__FILE__);
        }

        $appRoot = realpath($appRoot);

        if (is_dir($appRoot) and is_readable($appRoot)) {
            self::$_appRoot = $appRoot;
        } else {
            throw new Exception($appRoot . ' is not a directory or not readable by this user');
        }
    }

    /**
     * Retrieve application root absolute path
     *
     * @return string
     */
    public static function getAppRoot()
    {
        return self::$_appRoot;
    }


    /**
     * @param string $docRoot
     * @throws Exception
     */
    public static function setDocRoot($docRoot = '')
    {
        if (self::$_docRoot) {
            return;
        }

        if ('' === $docRoot) {
            $docRoot = dirname(__FILE__);
        }

        $docRoot = realpath($docRoot);

        if (is_dir($docRoot) and is_readable($docRoot)) {
            self::$_docRoot = $docRoot;
        } else {
            throw new Exception($docRoot . ' is not a directory or not readable by this user');
        }
    }

    /**
     * Retrieve application document root absolute path
     *
     * @return string
     */
    public static function getDocRoot()
    {
        return self::$_docRoot;
    }

    /**
     * @return string
     */
    public static function getBaseUrl()
    {
        $url = "http://" . $_SERVER['HTTP_HOST'];
        return $url;
    }

    /**
     * @param $path
     * @return null|string
     */
    public static function getUrl($path)
    {
        $url = null;
        $url = App::getBaseUrl() . $path;
        return $url;
    }

    /**
     * @return string
     */
    public static function getSkinUrl()
    {
        return App::getBaseUrl() . App::getConfig('Core','skin/path');
    }

    /**
     * @param string $str
     * @return bool|null|string
     */
    public static function getClassName($str = '')
    {
        if(!$str) return null;

        $arr = explode('/',$str);

        $className = '';
        foreach ($arr as $key => $val)
        {
            $className = $className .'_'.ucfirst(strtolower($val));

        }

        return substr($className,1);
    }

    /**
     * Get fromkey from config
     * @return mixed|null
     */
    public static function getFormkey()
    {
        return self::getConfig('Core','formkey');
    }

    /**
     * Check if formkey is valid
     * @param $formkey
     * @return bool
     */
    public static function isValidKey($formkey)
    {
        $key = self::getFormkey();
        if($key == $formkey)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
####################################################################
}

