<?php
if (!defined('CORE')) {
    header("Location: index.php");
    exit();
}

class Config
{
    private static $CONFIG = array();
    private static $TYPES = array();//array(1=>'other', 2=>'debug', 3=>'cache', 4=>'features', 5=>'head', 6=>'news', 7=>'server', 8=>'settings', 9=>'voting', 10=>'webshop');
    public static function init()
    {
        global $sql;
        $sql[0]->query('GET_CONFIG_TYPES');
        while ($row = SQL::fetchArray())
        {
                Config::$TYPES[$row['id']] = $row['type'];
        }
        $sql[0]->query('GET_CONFIG');
        while ($row = SQL::fetchArray())
        {
                Config::$CONFIG[$row['type']][$row['name']] = html_entity_decode(stripslashes($row['value']));
        }
    }
    public static function get($type, $name, $default = '')
    {
        if(isset(Config::$CONFIG[$type][$name]))
        {
                return Config::$CONFIG[$type][$name];
        }
        else
        {
                if($default != '')
                {
                        Config::set($type, $name, $default);
                        return $default;
                }
                return null;
        }
    }
    public static function set($type, $name, $val)
    {
        global $sql;
        Config::$CONFIG[$type][$name] = $val;
        $id = array_search($type, Config::$TYPES);
        $params = array("name" => $name, "type" => $id, "val" => $val);
        $sql[0]->query('CHECK_CONFIG', $params);
        if(SQL::numRows())
        {
                $sql[0]->query('UPDATE_CONFIG', $params);
        }
        else
        {
                $sql[0]->query('INSERT_CONFIG', $params);
        }
    }
}
