<?php

if (!defined('CORE')) {
    header('Location: index.php');
    exit();
}

class html {

    const folder = 'cache';

    private static $enabled = false;
    private static $data = [];

    public static function init($active) {
        html::$enabled = $active;
        if (!$active) {
            return;
        }
        DAO::getInstance()::getCache()::get();
    }
    public static function add($id, $time, $recache)
    {
        html::$data[$id] = [$time, $recache];
    }
    public static function isEnabled() {
        return html::$enabled;
    }

    public static function check($page, $params = null, $force=false) {
        if (!html::$enabled || $force) {
            return true;
        }
        //$par['lang'] = User::getVar('lang');
        //$par['mod'] = User::isMod() == true ? 'true' : 'false';
        //$pars = implode(';', $par);
        //global $sql;
        $seconds = Conf::get('cache', $page, Conf::get('cache', 'default', '900'));
        $time = time() - $seconds;
        $md5 = md5($page . $params);

        if (!isset(html::$data[$md5])) {
            DAO::getInstance()::getCache()::add($md5, $page);
            html::add($md5, $time, 0);
            return true;
        }
        if (html::$data[$md5][0] > $time && html::$data[$md5][1] == 0) {
            return false;
        }
        return true;
    }

    public static function update($page, $params, $content) {
        if (!html::$enabled) {
            return true;
        }
        $id = md5($page . $params);
        DAO::getInstance()::getCache()::update($id, time());
        if (file_exists(html::folder . '/' . $id . '.html')) {
            unlink(html::folder . '/' . $id . '.html');
        }
        file_put_contents(html::folder . '/' . $id . '.html', $content);
    }

    public static function get($page, $params) {
        $id = md5($page . $params);
        if (file_exists(html::folder . '/' . $id . '.html')) {
            return file_get_contents(html::folder . '/' . $id . '.html');
        } else {
            return $id;
        }
    }

}
