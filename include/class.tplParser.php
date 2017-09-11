<?php

if (!defined('CORE'))
{
	header("Location: index.php");
	die();
}

class TplParser
{
    private static $tpl_dir = 'template';
    private static $default_tpl = 'default';
    private static $tpl;

    public static function setDir($tpl)
    {
        TplParser::$tpl=$tpl;
    }
    private static function get($template_name)
    {
        global $Lang;
        if (file_exists(TplParser::$tpl_dir . '/' . TplParser::$tpl . '/' . $template_name . '.tpl'))
        {
                return file_get_contents(TplParser::$tpl_dir . '/' . TplParser::$tpl . '/' . $template_name . '.tpl');
        }
        elseif (file_exists(TplParser::$tpl_dir . '/' . TplParser::$default_tpl . '/' . $template_name . '.tpl'))
        {
                return file_get_contents(TplParser::$tpl_dir . '/' . TplParser::$default_tpl . '/' . $template_name . '.tpl');
        }
        else
        {
                return msg($Lang['error'], sprintf($Lang['failed_to_get_content'], $template_name), 'error', true);
        }
    }
    public static function parse($template, $array, $return = false)
    {
        $template = TplParser::get($template);
        $content = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
        if ($return) { return $content; }
        echo $content;
    }
}
?>