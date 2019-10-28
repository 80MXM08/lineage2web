<?php

if (!defined('CORE')) {
    die();
}
define('DAO', TRUE);
require_once ('core/DAO/intf/Factory.php');
require_once ('core/DAO/intf/L2LS.php');
require_once ('core/DAO/intf/L2GS.php');
require_once ('core/DAO/intf/L2Web.php');

class DAO {

    private static $INSTANCE;

    static function get() {
        return DAO::$INSTANCE;
    }

    static function init($engine) {
        switch ($engine) {
            case "MSSQL":
            case "OracleDB":
            case "PostgreSQL":
            case "H2":
            case "HSQLDB":
                exit('Not supported!');

            default:
            case "MariaDB":
            case "MySQL":
                require ('core/DAO/impl/MySQL.php');
                DAO::$INSTANCE = new MySQL();
                break;
        }
    }

}
