<?php

if (!defined('CORE')) {
    header("Location: index.php");
    die();
}

$DB = array(
    0 => array(
        "host" => "localhost",      //MySQL Host
        "port" => "3306",           //MySQL Port
        "user" => "l2web",          //MySQL User
        "password" => "",           //MySQL Password
        "database" => "l2web"       //L2Web Database (default - l2web)
    ),
    1 => array(
        "host" => "localhost",      //MySQL Host
        "port" => "3306",           //MySQL Port
        "user" => "l2jls",          //MySQL User
        "password" => "",           //MySQL Password
        "database" => "l2jls"       //L2J Account DataBase (default - l2jls)
    ),
    2 => array(
        "host" => "localhost",      //MySQL Host
        "port" => "3306",           //MySQL Port
        "user" => "l2jcs",          //MySQL User
        "password" => "",           //MySQL Password
        "database" => "l2jcs"       //L2J Comunity DataBase (default - l2jcs)
    ),
        /* 3 => array(
          "host" => "localhost",    //MySQL Host
          "port" => "3306",         //MySQL Port
          "user" => "l2jdb",         //MySQL User
          "password" => "",         //MySQL Password
          "database" => "l2jdb"     //L2J Character DataBase (default - l2jdb)
          ) */
);
?> 