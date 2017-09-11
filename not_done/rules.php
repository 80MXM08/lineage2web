<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Rules");
$tpl->parsetemplate('rules', NULL);
foot();
?>