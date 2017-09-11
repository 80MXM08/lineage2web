<?php
die('Currently Disabled');
define('INWEB', True);
require_once("include/config.php");
//пароль
includeLang('webpoints');
head($Lang['webpoint_exchange']);

if($user->logged())
{
    if($_POST)
    {
    	$srvdb = getDBName($_POST['server']);
    	
        $char=$mysql->escape($_POST['char']);
        $item=0+$_POST['item'];
        if(!is_numeric($_POST['multiplier']) || $_POST['multiplier']==0){$_POST['multiplier']=1;}
        if(!is_numeric($item)){$item=1;}
        if(!is_numeric($char)){$char=1;}
        if($_POST['multiplier']<0){$_POST['multiplier']=abs($_POST['multiplier']);}
        //if($_POST['reward']==3){$_POST['multiplier']=1;}
        $multi=0+$_POST['multiplier'];
        $error=0;
        $errormsg="";
        $check = $mysql->result($mysql->query("SELECT `webpoints` FROM `accounts` WHERE `login`='{$_SESSION['account']}'"));
        if($check < $_POST['multiplier'])
        {
            $error++;
            $errormsg="Not enought webpoints";
        }
        if($error==0)
        {	
            $checkonline= $mysql->query("SELECT `account_name`, `online` FROM `$srvdb`.`characters` WHERE `charId`='".$char."'");
            if(!$mysql->num_rows($checkonline))
            {
                $error++;
                $errormsg="Character doesn't exist";
            }
        }
        if($error==0)
        {	
            $chon=$mysql->fetch_array($checkonline);
            if($chon['online']!=0)
            {
                $error++;
                $errormsg="Character is Online";
            }
            if($error==0 && $chon['account_name']!=strtolower($_SESSION['account']))
            {
                $error++;
                $errormsg="Invalid CharID";
            }
        }
        if($error==0)
        {
            $_SESSION['webpoints'] -= $multi; 
            
            switch($item)
            {
                case 1:
                    $itemId="4356";
                    $indb=$multi*4;
                break;
                case 2:
                    $itemId="4444";
                    $indb=$multi;
                break;
                default :
                    $itemId="-1";
                    $indb=0;
                break;
            }
            if(InsertItem($itemId, $indb, "INVENTORY", $char))
            {
                $mysql->query("INSERT INTO `$webdb`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$char', 'WebPointExchange', 'Success', 'WebPoint Count=\"$multi\", Reward=\"$itemId\" ');");
                $mysql->query("UPDATE `accounts` SET `webpoints` = `webpoints`-'$multi' WHERE `login`='{$_SESSION['account']}';");
                msg('Success', $Lang['webpoints_exchanged']);
            }
            else
            {
                $mysql->query("INSERT INTO `$webdb`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$char', 'WebPointExchange', 'Error', 'WebPoint Count=\"$multi\", Reward=\"$itemId\", Reason=\"Failed Insert Item to DB\"');");
                $error++;
                $errormsg="Failed Insert Item in DB";
            }
        }
        else
        {
            $mysql->query("INSERT INTO `$webdb`.`log` (`Account`, `CharId`, `Type`, `SubType`, `Comments`) VALUES ('{$_SESSION['account']}', '$char', 'WebPointExchange', 'Error', 'WebPoint Count=\"$multi\", Reason=\"$errormsg\" ');");
            msg('Error', $errormsg, 'error');
        }
    }
    else
    {
        $parse = $Lang;
        $parse['server_list'] = NULL;
	   $srv = $mysql->query($q[1], array('db'=>$webdb));
	   while($srname = $mysql->fetch_array($srv))
	   {
		  $parse['server_list'] .= '<option value="'.$srname['ID'].'">'.$srname['Name'].'</option>';
	   }
	   $parse['b_exchange'] = button($Lang['exchange'], $Lang['exchange'],1);
        $tpl->parsetemplate('webpoints', $parse);
    }
}
else
{
    msg($Lang['error'], $Lang['need_to_login'], 'error');
}
foot();
?>