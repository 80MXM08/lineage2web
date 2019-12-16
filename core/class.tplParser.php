<?php

if (!defined('CORE')) {
    header("Location: index.php");
    die();
}

class tpl {

    private static $tpl_dir = 'template';
    private static $default_tpl = 'default';
    private static $tpl;

    public static function setDir($tpl) {
        tpl::$tpl = $tpl;
    }

    private static function get($tn) {
        global $Lang;
        if (file_exists(tpl::$tpl_dir . '/' . tpl::$tpl . '/' . $tn . '.tpl')) {
            return file_get_contents(tpl::$tpl_dir . '/' . tpl::$tpl . '/' . $tn . '.tpl');
        } elseif (file_exists(tpl::$tpl_dir . '/' . tpl::$default_tpl . '/' . $tn . '.tpl')) {
            return file_get_contents(tpl::$tpl_dir . '/' . tpl::$default_tpl . '/' . $tn . '.tpl');
        } else {
            return msg($Lang['__error_'], sprintf($Lang['__failed-to-get-content_'], $tn), 'error', true);
        }
    }

    public static function parse($t, $a = null) {
        global $Lang;
        return preg_replace_callback('#\{([a-z0-9\-_]*?)\}#Ssi', function($m) use ($a, $Lang) {
            return isset($a[$m[1]]) ? $a[$m[1]] : ((isset($Lang[$m[1]])) ? $Lang[$m[1]] : $m[1]);
        }, tpl::get($t));
    }

}
