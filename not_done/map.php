<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['char']) && is_numeric($_GET['char']))
{
	$srv = getVar('server');
	$char = getVar('char');
	
	$dbname = getDBName($srv);
	//echo $srv;
	$checkchar = $sql->query("SELECT `account_name`, `charId`, `onlinemap` FROM `$dbname`.`characters` WHERE `charId` = '$char'");
	if($sql->num_rows($checkchar))
	{
		$char = $sql->fetch_array($checkchar);
		if(strtolower($char['account_name'])!=strtolower($_SESSION['account']))
		{
			die("nav tavs chars");
		}
		if($char['onlinemap']=='true')
		{
			$sql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='false' WHERE `charId` = '{$char['charId']}'");
            echo "obj.value=false;\n";
		}
		else
		{
			$sql->query("UPDATE `$dbname`.`characters` SET `onlinemap`='true' WHERE `charId` = '{$char['charId']}'");
            echo "obj.value=true;\n";
		}
	}
}
?>