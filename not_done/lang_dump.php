<?php
define('WEB', true);
include('include/core.php');
unlink('test.php');
$text='<?php
if(!defined(\'CORE\'))
{
	header("Location: ../../index.php");
	die();
}
';
$sql->query("SELECT * FROM `l2web`.`lang` WHERE lang='en' ORDER BY id ASC");
while($r=$sql->fetchArray())
{
    $text.='$Lang[\''.$r['name'].'\'] = \''.addslashes($r['value']).'\';
';
}
$text.='
?>';
file_put_contents('test.php',$text);
?>