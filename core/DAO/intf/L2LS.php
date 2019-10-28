<?php

if (!defined('DAO')) {
    die();
}

interface iAccount {

    static function getTotal();

    static function get($acc);

    static function check($name, $pass);

    static function checkByCookie($login, $cookie, $ip);

    static function checkBySession($session, $ip);

    static function checkNameExists($name);

    static function updateSessionCookie($login, $session, $cookie, $ip);

    static function changePass($acc, $old, $pass);

    static function insert($acc, $pass, $ip);
}

interface iAccountData {

    static function get();

    static function check($var);

    static function set($var, $val);

    static function update($var, $val);

    static function insert($var, $val);
}
