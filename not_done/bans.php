<?php

define('L2WEB', true);
require_once ("include/core.php");
loggedInOrReturn('bancontrol.php');
if (!$user->isMod())
{
	die();
}
head($Lang['ban_list']);

echo '<center><a href="bans.php">' . $Lang['ban_list'] . '</a> | <a href="?a=add">' . $Lang['add'] . '</a></center>';

$a = getVar('a');
switch ($a)
{
	case 'add':
		if ($_POST)
		{
			$ip = getVar('ip');
			if (filter_var($ip, FILTER_VALIDATE_IP) && $ip == filter_var($ip, FILTER_VALIDATE_IP))
			{
				$ip = strip_tags(stripslashes(trim($ip)));
				$reas = strip_tags(stripslashes(trim(getVar('reason'))));
				$date = date("d.m.y H:i");
				$hours = getVar('hours', 'int');
				$days = getVar('days', 'int');
				$unix_time = time() + 3600 * $hours + 3600 * 24 * $days;
				$data = @fopen("include/bans.txt", "a+");
				fputs($data, "$date||$ip||$reas||$unix_time||\n");
				fclose($data);
				msg($Lang['success'], '<font color="red">' . sprintf($Lang['ip_disabled_reason'], $ip, $reas) . '<br /><a href="bans.php">' . $Lang['return_to_bans'] . '</a></font>');
				writeLog('ban', 'success', 'IP: ' . $ip . ' was banned. Reason: ' . $reas . ' Banned until ' . date("d.m.y ( H:i )", $unix_time));

			}
			else
			{
				msg($Lang['error'], $Lang['incorrect_ip'], 'error');
			}
		}
		else
		{
			$tpl->parse('ban_add', $Lang);
		}
		break;
	case 'del':


		$id = getVar('id');
		$id = filter_var(strip_tags(stripslashes(trim($id))), FILTER_VALIDATE_INT);
		if ($id)
		{

			$fstr = @file("include/bans.txt");
			unset($fstr[$id-1]);
			$fp = @fopen("include/bans.txt", "w");
			fwrite($fp, implode("", $fstr));
			fclose($fp);
			msg($Lang['success'], $Lang['ban_deleted']);
		}
		break;
	default:
		$data = @file("include/bans.txt");
		$parse['ban_rows'] = '';
		for ($i = 0; $i < sizeof($data); $i++)
		{
			$info = explode("||", $data[$i]);
			$parse1['delete'] = $Lang['delete'];
			$parse1['i'] = $i+1;
			$parse1['from'] = $info[0];
			$parse1['ip'] = $info[1];
			$parse1['reason'] = $info[2];
			$parse1['to'] = date("d.m.y H:i", $info[3]);
			$parse['ban_rows'] .= $tpl->parse('ban_row', $parse1, true);
		}
		$tpl->parse('ban', $parse);
		break;
}
foot();

?>