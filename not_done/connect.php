<?php
define('WEB', True);
require_once("include/core.php");
head("How to connect");
$tpl->parse('connect', $parse);
foot();
?>