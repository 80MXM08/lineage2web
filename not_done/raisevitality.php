<?php
define('WEB', True);
require_once("include/core.php");
//пароль

if(isset($_GET['char']) && is_numeric($_GET['char']))
{
	$srv = getVar('server');
	$char = getVar('char');
	$id = getVar('id');
    if($_SESSION['webpoints']<=0)
    {
        echo "alert('You don\'t have enought webpoints');";
        exit();
    }
    
	$dbname = getDBName($srv);
	$checkchar = $sql->query("SELECT `account_name`, `charId`, `vitality_points`, `online` FROM `$dbname`.`characters` WHERE `charId` = '$char'");
	if($sql->num_rows($checkchar))
	{
		$char = $sql->fetch_array($checkchar);
		if(strtolower($char['account_name'])!=strtolower($_SESSION['account']))
		{
            echo "alert('This is not your character');\n";
			die();
		}
		if($char['online'])
		{
            echo "alert('Please log off character first');\n";
            die();
		}
		if($char['vitality_points']=='20000')
		{
            echo "alert('You have already max vitality points');\n";
            die();
		}
		else
		{
            if($char['vitality_points']+2500<20000)
            {
		          $sql->query("UPDATE `$dbname`.`characters` SET `vitality_points`=`vitality_points`+'2500' WHERE `charId` = '{$char['charId']}'");
                    echo "alert('Vitality Points successfully exchanged');\n";
            }
            else
            {
                $sql->query("UPDATE `$dbname`.`characters` SET `vitality_points`='20000' WHERE `charId` = '{$char['charId']}'");
                    echo "alert('Vitality Points successfully exchanged');\n";
            }
            $sql->query("UPDATE `accounts` SET `webpoints`=`webpoints`-'1' WHERE `login`='{$_SESSION['account']}'");
            echo "document.getElementById('vitality$id').width='";
            echo ($char['vitality_points']+2500)/250;
            echo "';\n";
            echo "document.getElementById('wp').firstChild.nodeValue='";
			echo $_SESSION['webpoints']-1;
			echo "';\n";
		}
	}
}
?>