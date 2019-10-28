<?php
define('L2WEB', true);
require_once('include/core.php');
switch ($_GET['a'])
{
    case 'i'://import
	foreach ($Lang as $key => $value)
	{

	    if (substr($key, 0, 1) === "_")
	    {
		$ukey = strtolower($key);
	    }
	    else
	    {
		$ukey = '_' . strtolower($key);
	    }
	    if (!DAO::getInstance()::getLang()::insert('en', $ukey, $value))
	    {
		echo '<br />Dublicate key - ' . $ukey;
	    }
	}
	break;
    case 'e': //export
	unlink('testlang.php');
	$text = '<?php
if(!defined(\'CORE\'))
{
	header(\'Location: ../../index.php\');
	die();
}

';
	foreach (DAO::getInstance()::getLang()::getAll('en') as $l)
	{
		$str2=html_entity_decode($l['value']);
	    $str=str_replace("'","\'",$str2);

	    $text .= '$Lang[\'' . $l['key'] . '\'] = \'' . $str . '\';
';
	}
	file_put_contents('testlang.php', $text);
	break;
}
