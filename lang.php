<?php
define('L2WEB', true);
require('core/core.php');
head();
/*if (!User::isAdmin()) {
    die();
}*/
$a = isset($_GET['a'])?$_GET['a']:null;
$i=0;
switch($a)
{
case 'move2db':
//DAO::getInstance()::getLang()::getAll();
foreach($Lang as $k=>$v)
{
        $v=htmlentities($v);
        DAO::getInstance()::getLang()::insert('en',$k, $v);
        //$i++;
}

break;

case 'move2file':
unlink('testlang.php');
	$text = '<?php
if(!defined(\'CORE\'))
{
	header(\'Location: ../../index.php\');
	exit();
}

';
	foreach (DAO::getInstance()::getLang()::getAll('en') as $l)
	{
	    $str=str_replace("'","\'",$l['value']);

	    $text .= '$Lang[\'' . $l['key'] . '\'] = \'' . $str . '\';
';
	}
	file_put_contents('testlang.php', $text);
break;
case 'dostuff':
$lngs=DAO::getInstance()::getLang()::getAll('en');
foreach($lngs as $r)
{
    //$text.='$Lang[\''.$r['name'].'\'] = \''.addslashes($r['value']).'\';
	
	$new_key=substr($r['key'], 1, strlen($r['key']) - 1);
	echo $r['key'].' - ';
	$new = str_replace('_', '-', $new_key);
	echo $new.' - ';
	echo DAO::getInstance()::getLang()::updateKey('en',$r['key'], '__'.$new.'_', $r['value']);
	echo '<br />';
}
break;

}
?>
echo '<a href="?a=move2db">Move to DB</a><br />';
echo '<a href="?a=dostuff">Do stuff</a><br />';
echo '<a href="?a=move2file">Move to File</a><br />';
<table>
<?php

foreach($Lang as $k=>$v)
{
        //$v=$sql->escape($v);
        //$sql->query("INSERT INTO `l2web`.`lang` (`id`, `lang`, `name`, `value`) VALUES ('$i', 'en', '$key', '$value')");
		echo '<tr><td>'.$i++.'</td><td>'.$k.'</td><td>'.htmlentities($v).'</td></tr>';
        
}
?>
</table>
<?php
foot();