<?php
class Database
{
    public static $instance;

    private $_connection;
    //private $_results = array();


    public static function Connection()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $config = App::getConfig('Core','database');

        $host       = $config['host'];
        $dbname     = $config['dbname'];
        $username   = $config['username'];
        $password   = $config['password'];

            try
            {
                $this->_connection = new PDO("mysql:host=".$host.";dbname=".$dbname.";charset=utf8",$username,$password);
                $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
    }

    public function getResults($sql, $format = PDO::FETCH_ASSOC)
    {
        if($data = $this->_connection->query($sql))
        {
            # all results
            $results = $data->fetchAll($format);
        }
        return $results;
    }
    public function getRow($sql, $format = PDO::FETCH_ASSOC)
    {
        $row = array();
        if($data = $this->_connection->query($sql))
        {
            # single row
            $row = $data->fetch($format);
        }
        return $row;
    }

    /**
     * Add new row to database table - if success, 'id' of insterted record is returned
     * @param $table
     * @param $idFieldName
     * @param array $data
     * @return bool|string
     */
    public function addRow($table, $idFieldName, $data = array())
    {

        if(empty($data)) return false;

        # unset primary column from data
        if(isset($data[$idFieldName])) unset($data[$idFieldName]);

        # remove data keys not matching table column names
        $data = $this->_getValidDataArray($table,$data);

        # create secure values (escape quotes and double quotes)
        $securedValues = array();
        foreach($data as $key => $value)
        {
            $securedValues[$key] = addslashes($value);
        }

        # create $fields and $values strings
        $fields = implode(",",array_keys($securedValues));
        $values = '"'.implode('","',$securedValues).'"';

        $sql = "INSERT INTO $table ($fields) VALUES ($values)";

        try
        {
            $this->_connection->query($sql);

        }
        catch(PDOException $e)
        {
            echo "<strong>".$e->getMessage()."</strong><br>";
            echo '<pre>';
            print_r($e->getTrace());
            echo '</pre>';
        }

        return $this->_connection->lastInsertId();
    }

    public function updateRow($table, $idFieldName, $data = array())
    {
        if(empty($data) or !isset($data[$idFieldName])) return false;

        $id = $data[$idFieldName];

        # remove data keys not matching table column names
        $data = $this->_getValidDataArray($table,$data);

        # unset primary column from data
        if(isset($data[$idFieldName])) unset($data[$idFieldName]);

        $allFieldsAndValues = "";

        foreach($data as $field => $value)
        {
            $allFieldsAndValues = $allFieldsAndValues . $field .'='.$this->_connection->quote($value).',';

        }

        # remove , from end
        $allFieldsAndValues = rtrim($allFieldsAndValues,",");

        $sql = "UPDATE $table SET ".$allFieldsAndValues." WHERE ".$idFieldName."=".$id;

        try
        {
            $this->_connection->query($sql);

        }
        catch(PDOException $e)
        {
            echo "<strong>".$e->getMessage()."</strong><br>";
            echo '<pre>';
            print_r($e->getTrace());
            echo '</pre>';
        }
    }

    private function _getValidDataArray($table, $data)
    {
        # get table column names
        $columns = $this->getColumnNames($table);

        # remove data keys not matching table column names
        foreach(array_keys($data) as $key)
        {
            if(!in_array($key,$columns))
            {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Get table columns data (Field, Type, etc...)
     * @param $table
     * @return array
     */
    public function getColumns($table)
    {
        $sql = "SHOW COLUMNS FROM ".$table;
        $result = $this->getResults($sql);
        return $result;
    }

    /**
     * Get table column names
     * @param $table
     * @return array
     */
    public function getColumnNames($table)
    {
        $names = array();

        $columns = $this->getColumns($table);
        foreach($columns as $data)
        {
            $names[] = $data['Field'];
        }

        return $names;

    }
    /**
     * Prevent users to clone the instance
     */
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
}