<?php
define('WEB', true);
include('include/core.php');
$i=1;
foreach($Lang as $key=>$value)
{
        $value=$sql->escape($value);
        $sql->query("INSERT INTO `l2web`.`lang` (`id`, `lang`, `name`, `value`) VALUES ('$i', 'en', '$key', '$value')");
        $i++;
}


?>