<?php
if(!defined('CORE'))
{
	header("Location: ../../index.php");
	die();
}
$user_ip = $_SERVER['REMOTE_ADDR'];
$data = file("include/bans.txt");
for ($i = 0; $i < sizeof($data); $i++)
{
	$info = explode("||", $data[$i]);
	$date = $info[0];
	$ip = $info[1];
	$op = $info[2];
	$end_ban = $info[3];
	$real_time = time();
	$convert = date("d.m.y H:i", $end_ban);
	if($user_ip == $ip)
	{
		if($real_time > $end_ban)
		{
			$rem = $i;
			$fstr = file("include/bans.txt");
			unset($fstr[$rem]);
			$fp = fopen("include/bans.txt", "w");
			fwrite($fp, implode("", $fstr));
			fclose($fp);
			writeLog('ban', 'success', 'IP ('.$info[1].') unbaned. Ban duration is over');
		}
		else
		{
			head($Lang['you_banned'], 0);
            $parse=$Lang;
            $parse['secs'] = $info[3];
            $parse['ip']=$info[1];
            $parse['reas']=$info[2];
            $parse['date_from']=$info[0];
            $parse['date_to']=date("d.m.y H:i", $info[3]);
            TplParser::parse('banned',$parse);
			foot(0);
			exit;
		}
	}
}
?>