<?php
if (!defined('DAO')) {
    header('Location: index.php');
    die();
}
interface iConfig {

    static function getTypes();

    static function getAll();

    static function get($typeId, $name);

    static function update($typeId, $name, $value);

    static function add($typeId, $name, $value);
}

interface iCache {

    static function reCache($page);

    static function get();

    static function add($id, $page);

    static function update($id, $time);
}

interface iBlock {

    static function get();
}

interface iL2WGameServer {

    static function get();
}


interface iL2Witem {
    
}



interface iL2WHenna {
    
}
interface iL2WSkills {
    
}
interface iLog {
    
}
interface iBan {
    
}
interface iMessages {

    static function getUnread();

    static function getUnreadCount();

    static function getSent();

    static function getSentCount();

    static function getReceived();

    static function getReceivedCount();
}


interface iNews {

    static function getAll();

    static function get($id);
}
interface iLang {
    
}