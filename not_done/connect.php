<?php
define('WEB', True);
require_once("include/core.php");
head($Lang['how_to_connect']);
$tpl->parse('connect', $parse);
foot();
?>