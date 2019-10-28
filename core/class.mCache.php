<?php
if (!defined('CORE')) {
    header("Location: index.php");
    die();
}
class mCache {

    var $e = false;
    var $c = null;

    function mCache() {
        if (class_exists('Cache')) {
            $options = array(
    'cacheDir' => '/mcache/',
    'lifeTime' => 3600
);
            $this->c = new Cache('msession');
            $this->e = true;
            if (!$this->c->addServer($MC['host'], $MC['port'])) {
                $this->c = null;
                $this->e = false;
                die('Failed to connect to memcache');
            }
        }
        else
        {
            die('Memcache disabled');
        }
    }

    function get($key) {
        return $this->c!=null ? $this->c->get($key) : null;
    }

    function set($k, $d, $t = 600) {
        return $this->c!=null ? $this->c->set($k, $d, false, $t) : null;
    }
    function del($k) {
        return $this->c!=null ? $this->c->delete($k) : null;
    }
}
