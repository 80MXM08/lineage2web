<?php

if (!defined('CORE')) {
    header('Location: index.php');
    exit();
}

class Conf {

    private static $CONFIG = [];
    //private static $TYPES = [];

    public static function init() {
        /*foreach (DAO::get()::Config()::getTypes() as $r) {
            Conf::addType($r['id'], $r['type']);
        }*/
        foreach (DAO::get()::Config()::getAll() as $r) {
            Conf::add($r['type'], $r['name'], $r['value']);
        }
    }

    public static function add($type, $name, $value) {
        Conf::$CONFIG[$type][$name] = html_entity_decode(stripslashes($value));
    }

    /*public static function addType($id, $type) {
        Conf::$TYPES[$id] = $type;
    }*/

    public static function get($type, $name) {
        if (isset(Conf::$CONFIG[$type][$name])) {
            return Conf::$CONFIG[$type][$name];
        } else {
            Conf::set($type, $name, '0');
            return '';
        }
    }

    public static function getAll() {
        return Conf::$CONFIG;
    }

    public static function getAllFromType($type) {
        if (isset(Conf::$CONFIG[$type])) {
            return Conf::$CONFIG[$type];
        }
    }

    public static function set($type, $name, $val) {
        Conf::add($type, $name, $val);
        //$id = array_search($type, Conf::$TYPES);
        //TODO: id==null ? make new type?
        throw new Exception("Not Implemented!{$type}-{$name}");
        DAO::get()::Config()::set($id, $name, $val);
    }
    public static function debug()
    {
        print_r(Conf::$CONFIG);
        print_r(Conf::$TYPES);
    }
}