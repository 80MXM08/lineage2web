<?php

if (!defined('CORE')) {
    header("Location: index.php");
    exit();
}

class Cache {

    private static $folder = "cache";
    private static $cacheId;
    private static $enabled = false;

    public static function init($active) {
        Cache::$enabled = $active;
    }

    private static function isEnabled() {
        return Cache::$enabled;
    }

    private static function getId() {
        return Cache::$cacheId;
    }

    private static function setId($id) {
        Cache::$cacheId = $id;
    }

    public static function check($page, $params = null) {
        if (!Cache::isEnabled()) { return true; }

        global $sql;
        $seconds = Config::get('cache', $page, Config::get('cache', 'default', '900'));
        $time = time() - $seconds;
        $qry = $sql[0]->query('GET_CACHE_BY_PAGE', array('page' => $page, 'params' => $params));
        if (!SQL::numRows()) {
            $sql[0]->query('ADD_CACHE', array('page' => $page, 'params' => $params));
            Cache::setId($sql[0]->getLastId());
            return true;
        }
        $cch = SQL::fetchArray($qry);
        Cache::setId($cch['id']);
        if ($cch['time'] > $time && $cch['recache'] == '0') {
            return false;
        }
        return true;
    }

    public static function update($content) {
        if (!Cache::isEnabled()) {
            return true;
        }

        global $sql;
        $id = Cache::getId();
        $sql[0]->query('UPDATE_CACHE_BY_ID', array('time' => time(), 'id' => $id));
        if (file_exists(Cache::$folder . '/' . $id . '.html')) {
            unlink(Cache::$folder . '/' . $id . '.html');
        }
        file_put_contents(Cache::$folder . '/' . $id . '.html', $content);
    }

    public static function get() {
        return file_get_contents(Cache::$folder . '/' . Cache::getId() . '.html');
    }

}

?>