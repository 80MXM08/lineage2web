<?php
define('WEB', True);
require_once("include/core.php");
//пароль
head("UnStuck");
if(isset($_GET['cid']))
{
	$charid=0+$sql->escape($_GET['cid']);
	$query=$sql->query("SELECT `account_name`, `online` FROM `characters` WHERE `charId`='".$charid."'");
	if($sql->num_rows($query))
	{
		$char=$sql->fetch_array($query);
		if(strtolower($char['account_name'])==strtolower($_SESSION['account']))
		{
			if($char['online']!=1)
			{
				$sql->query("UPDATE `characters` SET `x`='82698', `y`='148638', `z`='-3473' WHERE `account_name`='{$_SESSION['account']}' AND `charId`='$charid'");
                //$sql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$charid', 'Unstuck', 'Success', '---');");
				msg('Success','Character has been unstucked');
			}else
			{
			    //$sql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$charid', 'Unstuck', 'Error', 'Char is Online');");
				msg('Error', 'You cannot unstuck character who is online', 'error');
			}
			
			
		}else
		{
            //$sql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$charid', 'Unstuck', 'Error', 'Char is not Owned by this account');");
			msg('Error', 'You can only unstuck your character', 'error');
		}
	}else
	{
        //$sql->query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$charid', 'Unstuck', 'Error', 'Account=\"{$_SESSION['account']}\", CharId=\"$charid\", Reason=\"Character not found\"');");
		msg('Error', 'Character NOT Found', 'error');
	}
}
foot();
?>