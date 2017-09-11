<?php

define('L2WEB', true);
require_once ('include/core.php');
$stat = fString(filter_input(INPUT_GET, 'stat'));
if (isset($_GET['page']))
{
	$start = fInt(filter_input(INPUT_GET, 'page'));
}
else
{
	$start = 1;
}
if (!is_numeric($start) || $start == 0)
{
	$start = 1;
}
$start = abs($start) - 1;
$cTop=Config::get('settings', 'TOP', '10');
$startlimit = $start * $cTop;


if ($stat == '' || $stat == 'home')
{
	$head = $Lang['home'];
}
else
{
	$head = isset($Lang['head_' . $stat])?$Lang['head_' . $stat]:$Lang['error'];
}
head($head);
$server=fInt(filter_input(INPUT_GET, 'server'));
$par['lang'] = User::getVar('lang');
$par['stat'] = $stat != '' ? $stat : 'home';
$par['page'] = $start + 1;
$par['server'] = $server != '' ? $server : '0';
$params = implode(';', $par);
if (Cache::check('stat', $params))
{
	$content = '';
	$parse = $Lang;
	$parse['human'] = $Lang['race0'];
	$parse['elf'] = $Lang['race1'];
	$parse['dark_elf'] = $Lang['race2'];
	$parse['orc'] = $Lang['race3'];
	$parse['dwarf'] = $Lang['race4'];
	$parse['kamael'] = $Lang['race5'];
	if (isset($_GET['server']))
	{
		$parse['srv'] = "&amp;server=" . $server;
                $sId = isset($GS[$server]) ? $GS[$server]['id'] : 0;
	}
        else
        {
            $sId = 0;
        }
	$parse['server_list'] = null;
	$sId = 0;
	foreach ($GS as $slist)
	{
		$selected = ($slist['id'] == $server) ? 'selected="selected"' : '';
		$parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat=' . $stat . '&amp;server=' . $slist['id'] . '\')" ' . $selected . '>' . $slist['name'] . '</option>';
	}
	$content .= TplParser::parse('stat_menu', $parse, 1);
	unset($parse);
	switch ($stat)
	{

		case 'online':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_LIST_ONLINE', array('limit' => $startlimit, 'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('ONLINE_COUNT');
			$content .= '<h1>' . $Lang['online'] . '</h1>';
			break;

		case 'castles':
			$result = $sql[SQL_NEXT_ID + $sId]->query('CASTLE_INFO');

			$r = 0;
			$content .= '<table class="forts">';
			while ($row = SQL::fetchArray($result))
			{
				unset($rowparse);
				$rowparse = array();
				$rowparse['tr1'] = ($r == 0) ? '<tr>' : '';
				$r++;
				$rowparse['castle_of_name'] = sprintf($Lang['castle_of'], $row['name'], '%s');
				$rowparse['ward_imgs'] = '';
				$ter = $sql[SQL_NEXT_ID + $sId]->query('CASTLE_WARDS',array('id'=>$row['id']));
				$ter_res = $sql[SQL_NEXT_ID + $sId]->result($ter);
				if ($ter_res != '')
				{
					$wards = explode(';', $ter_res);
					foreach ($wards as $ward)
					{
						if ($ward == '')
							continue;
						$rowparse['ward_imgs'] .= '<img src="img/territories/' . $ward . '.png" alt="' . $Lang['ward_info' . $ward] . '" title="' . $Lang['ward_info' . $ward] . '" />';
					}
				}
				else
				{
					$rowparse['ward_imgs'] .= '<br />';
				}
				$rowparse['siege_date'] = $Lang['next_siege'] . date('D j M Y H:i', $row['siegeDate'] / 1000);
				$rowparse['castle_name'] = $row['name'];
				$rowparse['castle'] = $Lang['castle'];
				$rowparse['details'] = $Lang['details'];
				$rowparse['owner_clan'] = $Lang['owner_clan'];
				$rowparse['owner_clan_leader'] = $Lang['lord'];
				$rowparse['owner_clan_link'] = ($row['clan_id']) ? '<a href="claninfo.php?clan=' . $row['clan_id'] . '&amp;server=' . $sId . '">' . $row['clan_name'] . '</a>' : $Lang['no_owner'];
				$rowparse['owner_clan_leader_link'] = ($row['charId']) ? '<a href="user.php?cid=' . $row['charId'] . '&amp;server=' . $sId . '">' . $row['char_name'] . '</a>' : $Lang['no_lord'];
				$rowparse['tax'] = $Lang['tax'];
				$rowparse['tax_percent'] = $row['taxPercent'];
				$rowparse['attackers'] = $Lang['attackers'];
				$rowparse['attackers_link'] = '';
				$result1 = $sql[SQL_NEXT_ID + $sId]->query('CASTLE_SIEGE',array('id'=>$row['id'], 'type'=>'1'));
				while ($attackers = SQL::fetchArray($result1))
				{
					$rowparse['attackers_link'] .= '<a href="claninfo.php?clanid=' . $attackers['clan_id'] . '&amp;server=' . $sId . '">' . $attackers['clan_name'] . '</a><br />';
				}
				$rowparse['defenders'] = $Lang['defenders'];
				$rowparse['defenders_link'] = '';
				$result2 = $sql[SQL_NEXT_ID + $sId]->query('CASTLE_SIEGE',array('id'=>$row['id'], 'type'=>'0'));
				if (SQL::numRows($result2))
				{
					while ($defenders = SQL::fetchArray($result2))
					{
						$rowparse['defenders_link'] .= '<a href="claninfo.php?clanid=' . $defenders['clan_id'] . '">' . $defenders['clan_name'] . '</a><br /> ';
					}
				}
				else
				{
					$rowparse['defenders_link'] .= $Lang['npc'];
				}

				if ($r == 3)
				{
					$rowparse['tr2'] = '</tr>';
					$r = 0;
				}
				$content .= TplParser::parse('stat_castles', $rowparse, 1);
			}
			$content .= "</table>";

			break;

		case 'fort':
			$result = $sql[SQL_NEXT_ID + $sId]->query('FORT_INFO');

			$r = 0;

			$content .= '<table class="forts">';
			while ($row = SQL::fetchArray($result))
			{

				unset($rowparse);
				//$rowparse = array();
                $rowparse=$Lang;
				$rowparse['tr1'] = ($r == 0) ? '<tr>' : '';
				$r++;
				$rowparse['fort_of_name'] = sprintf($Lang['fort_of'], $row['name'], '%s');
				$rowparse['ward_imgs'] = '';
				$ter = $sql[SQL_NEXT_ID + $sId]->query('FORT_WARDS',array('id'=>$row['id']));

				(SQL::numRows($ter)) ? $ter_res = $sql[SQL_NEXT_ID + $sId]->result($ter) : $ter_res = '';
				if ($ter_res != '')
				{
					$wards = explode(';', $ter_res);
					foreach ($wards as $ward)
					{
						if ($ward == '')
							continue;
						$rowparse['ward_imgs'] .= '<img src="img/territories/' . $ward . '.png" alt="' . $Lang['ward_info' . $ward] . '" title="' . $Lang['ward_info' . $ward] . '" /> ';
					}
				}
				else
				{
					$rowparse['ward_imgs'] .= '<br />';
				}
				$rowparse['id'] = $row['id'];

				$rowparse['fort_name'] = $row['name'];
                /*
				$rowparse['fort'] = $Lang['fort'];
				$rowparse['details'] = $Lang['details'];
				$rowparse['owner_clan'] = $Lang['owner_clan'];
				$rowparse['lord'] = $Lang['lord'];*/
				$rowparse['owner_link'] = ($row['clan_id']) ? '<a href="claninfo.php?clan=' . $row['clan_id'] . '&amp;server=' . $sId . '">' . $row['clan_name'] . '</a>' : $Lang['no_owner'];
				$rowparse['lord_link'] = ($row['charId'] != '') ? '<a href="user.php?cid=' . $row['charId'] . '&amp;server=' . $sId . '">' . $row['char_name'] . '</a>' : $Lang['no_lord'];
				$rowparse['tax'] = $Lang['tax'];
				//$rowparse['tax_percent']=$row['taxPercent'];
				$rowparse['attackers'] = $Lang['attackers'];
				$rowparse['attackers_link'] = '';
				$rowparse['time_held'] = $Lang['time_held'];
				$result1 = $sql[SQL_NEXT_ID + $sId]->query('FORT_SIEGE',array('id'=>$row['id']));
				while ($attackers = SQL::fetchArray($result1))
				{
					$rowparse['attackers_link'] .= '<a href="claninfo.php?clanid=' . $attackers['clan_id'] . '&amp;server=' . $sId . '">' . $attackers['clan_name'] . '</a><br />';
				}
				if ($row['lastOwnedTime'])
				{
					$timeheld = time() - $row['lastOwnedTime'] / 1000;
					$timehour = round($timeheld / 60 / 60);
				}
				else
				{
					$timehour = 0;
				}
				$rowparse['fort_hold_time'] = $timehour . ' ' . $Lang['hours'];
				if ($r == 3)
				{
					$rowparse['tr2'] = '</tr>';
					$r = 0;
				}
				$content .= TplParser::parse('stat_forts', $rowparse, 1);
			}
			$content .= '</table>';
			break;

		case 'clantop':
			$result = $sql[SQL_NEXT_ID + $sId]->query('CLAN_TOP', array('limit' => $startlimit, 'top' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CLAN_COUNT_NON_GM');
			$content .= "<h1>{$Lang['head_clantop']}</h1><hr />";
			$content .= "<h2>{$Lang["clantop_total"]}: " . $sql[SQL_NEXT_ID + $sId]->result($page_foot) . "</h2>";
			$content .= "<table border=\"1\" align=\"center\"><thead><tr style=\"color: green;\"><th><b>{$Lang['head_clantop']}</b></th>";
			$content .= "<th><b>{$Lang['leader']}</b></th>";
			$content .= "<th><b>{$Lang['level']}</b></th>";
			$content .= "<th><b>{$Lang['reputation']}</b></th>";
			$content .= "<th><b>{$Lang['castle']}</b></th>";
			$content .= "<th><b>{$Lang['members']}</b></th>";
			$content .= "</tr></thead>";
			$content .= "<tbody>";

			$i = 1;
			while ($row = SQL::fetchArray($result))
			{
				if ($row['hasCastle'] != 0)
				{
					$castle = $row['name'];
				}
				else
				{
					$castle = $Lang['no_castle'];
				}
				$content .= "<tr" . (($i++ % 2) ? "" : " class=\"altRow\"") . " onmouseover=\"this.bgColor = '#505050';\" onmouseout=\"this.bgColor = ''\"><td><a href=\"claninfo.php?clan=" . $row["clan_id"] . "&server=$sId \">" . $row["clan_name"] .
					"</a></td><td><a href=\"user.php?cid={$row['charId']}&server=$sId \">" . $row["char_name"] . "</a></td><td class=\"numeric sortedColumn\">" . $row["clan_level"] . "</td><td>{$row['reputation_score']}</td><td>" . $castle . "</td><td class=\"numeric\">" . $row["ccount"] .
					"</td></tr>";
			}
			$content .= "</tbody></table>";
			break;

		case 'gm':
			$res = $sql[SQL_NEXT_ID + $sId]->query('GM_LIST', array('limit' => $startlimit, 'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('GM_COUNT');
			$content .= '<h1>' . $Lang['gm'] . '</h1>';
			break;

		case 'count':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_ITEM_COUNT', array(
				'item' => Config::get('settings','stat_item_id','57'),
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_ITEM_COUNT', array('item' => Config::get('settings','stat_item_id','57')));
			$content .= '<h1>' . $Lang['rich_players'] . '</h1>';
			$addheader = '<td><b>' . $Lang['adena'] . '</b></td>';
			$addcol = true;
			break;

		case 'top_pvp';
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_STAT', array(
				'order' => 'pvpkills',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_STAT', array('order' => 'pvpkills'));
			$content .= '<h1>' . $Lang['pvp'] . '</h1>';
			break;

		case 'top_pk':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_STAT', array(
				'order' => 'pkkills',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_STAT', array('order' => 'pkkills'));
			$content .= '<h1>' . $Lang['pk'] . '</h1>';
			break;

		case 'maxCp':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_ADD_STAT', array(
				'order' => 'maxCp',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT');
			$content .= '<h1>' . $Lang['cp'] . '</h1>';
			$addheader = '<td class="maxCp"><b>' . $Lang['max_cp'] . '</b></td>';
			$addcol = true;
			break;

		case 'maxHp':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_ADD_STAT', array(
				'order' => 'maxHp',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT');
			$content .= '<h1>' . $Lang['hp'] . '</h1>';
			$addheader = '<td class="maxHp"><b>' . $Lang['max_hp'] . '</b></td>';
			$addcol = true;
			break;

		case 'maxMp':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_ADD_STAT', array(
				'order' => 'maxMp',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT');
			$content .= '<h1>' . $Lang['mp'] . '</h1>';
			$addheader = '<td class="maxMp"><b>' . $Lang['max_mp'] . '</b></td>';
			$addcol = true;
			break;

		case 'top':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_EXP', array(
				'race' => '*',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT');
			$content .= '<h1>' . $Lang['top'] . ' ' . $cTop . '</h1>';
			break;

		case 'human':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '0',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '0'));
			$content .= '<h1>' . $Lang['race0'] . '</h1>';
			break;

		case 'elf':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '1',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '1'));
			$content .= '<h1>' . $Lang['race1'] . '</h1>';
			break;

		case 'dark_elf':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '2',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '2'));
			$content .= '<h1>' . $Lang['race2'] . '</h1>';
			break;

		case 'orc':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '3',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '3'));
			$content .= '<h1>' . $Lang['race3'] . '</h1>';
			break;

		case 'dwarf':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '4',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '4'));
			$content .= '<h1>' . $Lang['race4'] . '</h1>';
			break;

		case 'kamael':
			$res = $sql[SQL_NEXT_ID + $sId]->query('CHAR_TOP_BY_RACE', array(
				'race' => '5',
				'limit' => $startlimit,
				'rows' => $cTop));
			$page_foot = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => '5'));
			$content .= '<h1>' . $Lang['race5'] . '</h1>';
			break;

		default:
            $parse=$Lang;
			/*$parse = array();
			$parse['home'] = $Lang['home'];
			$parse['male'] = $Lang['male'];
			$parse['female'] = $Lang['female'];
			$parse['seven_signs'] = $Lang['seven_signs'];*/
            
			$tchar = $sql[SQL_NEXT_ID + $sId]->result($sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT'), 0, 0);
			$parse['race_rows'] = '';
			for ($i = 0; $i < 6; $i++)
			{
				if ($tchar)
				{
					$sqlq = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_RACE', array('race' => $i));
					$tfg = round($sql[SQL_NEXT_ID + $sId]->result($sqlq) / ($tchar / 100), 2);
				}
				else
				{
					$tfg = 0;
				}
				$parse['race_rows'] .= '<tr><th>' . $Lang['race' . $i] . '</th><td><img src="img/stat/sexline.jpg" height="10px" width="' . $tfg . 'px" alt="" title="' . $tfg . '%" /> ' . $tfg . '%</td></tr>';

			}
			if ($tchar)
			{
				$male = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_SEX', array('sex' => '0'));
				$parse['mc'] = round($sql[SQL_NEXT_ID + $sId]->result($male) / ($tchar / 100), 2);
				$female = $sql[SQL_NEXT_ID + $sId]->query('CHAR_COUNT_BY_SEX', array('sex' => '1'));
				$parse['fc'] = round($sql[SQL_NEXT_ID + $sId]->result($female) / ($tchar / 100), 2);
			}
			else
			{
				$parse['mc'] = $parse['fc'] = 0;
			}
			//$result1 = $sql[SQL_NEXT_ID+$sId]->query(206, array('cabal' => '%dusk%'));
			//$dawn = $sql[SQL_NEXT_ID+$sId]->result($result1);

			//$result2 = $sql[SQL_NEXT_ID+$sId]->query(206, array('cabal' => '%dawn%'));
			//$dusk = $sql[SQL_NEXT_ID+$sId]->result($result2);

			$result3 = $sql[SQL_NEXT_ID + $sId]->query('SEVEN_SIGNS');
			$row = SQL::fetchArray($result3);
			$parse['twilScore'] = $row['avarice_dusk_score'] + $row['gnosis_dusk_score'] + $row['strife_dusk_score'];
			$parse['dawnScore'] = $row['avarice_dawn_score'] + $row['gnosis_dawn_score'] + $row['strife_dawn_score'];
			$parse['date'] = date('m/d/Y H:i');
			$parse['current_cycle'] = $row['current_cycle'];
			$parse['active_period'] = $row['active_period'];
			$parse['aowner'] = $row['avarice_owner'];
			$parse['gowner'] = $row['gnosis_owner'];
			$parse['sowner'] = $row['strife_owner'];
    if (0 == $parse['active_period']) {
        $parse['status']=$Lang['preperation'];
	}
	else if (1 == $parse['active_period']) {
        $parse['status']=sprintf($Lang['competition'],$parse['current_cycle']);
	}
	else if (2 == $parse['active_period']) {
        $parse['status']=$Lang['calculation'];
	}
	else if (3 == $parse['active_period']) {
        $parse['status']=sprintf($Lang['seal_effect'],$parse['current_cycle']);
    }

			$content .= TplParser::parse('seven_signs', $parse, 1);

			break;
	}

	if ($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop' && $stat!='home')
	{
	   $parse=$Lang;
		/*$parse = array();
        
		$parse['place'] = $Lang['place'];
		$parse['face'] = $Lang['face'];
		$parse['name'] = $Lang['name'];
		$parse['level'] = $Lang['level'];
		$parse['class'] = $Lang['class'];
		$parse['clan'] = $Lang['clan'];
		$parse['pvp_pk'] = $Lang['pvp_pk'];
		$parse['status'] = $Lang['status'];*/
		$parse['addheader'] = isset($addheader) ? $addheader : '';
		$parse['char_rows'] = '';

		if ($startlimit != 0 || $startlimit != null)
		{
			$n = $startlimit + 1;
		}
		else
		{
			$n = 1;
		}
		while ($top = SQL::fetchArray($res))
		{
			if ($top['clan_name'])
			{
				$clan_link = '<a href="claninfo.php?clan=' . $top['clanid'] . '&amp;server=' . $sId . '">' . $top['clan_name'] . '</a>';
			}
			else
			{
				$clan_link = $Lang['no_clan'];
			}
			if ($top['sex'] == 0)
			{
				$color = '#8080FF';
			}
			else
			{
				$color = '#FF8080';
			}
			if ($top['online'] != 0)
			{
				$online = '<font color="green">' . $Lang['online'] . '</font>';
			}
			else
			{
				$online = '<font color="red">' . $Lang['offline'] . '</font>';
			}
			$parse['char_rows'] .= '<tr><td align="center"><b>' . $n . '</b></td><td><img src="./img/face/' . $top['race'] . '_' . $top['sex'] . '.gif" alt="" /></td><td><a href="user.php?cid=' . $top['charId'] . '&amp;server=' . $sId . '"><font color="' . $color .
				'">' . $top['char_name'] . '</font></a></td><td><center> ' . $top['level'] . '</center></td><td><center>' . $Lang['class_'.$top['base_class']] . '</center></td><td>' . $clan_link . '</td><td><center><b>' . $top['pvpkills'] . '</b>/<b><font color="red">' . $top['pkkills'] .
				'</font></b></center></td><td>' . $online . '</td>';

			if (isset($addcol) && isset($addcolcont))
			{
				$parse['char_rows'] .= $addcolcont;
			}
			elseif (isset($addcol) && !isset($addcolcont))
			{
				$parse['char_rows'] .= '<td class="' . $stat . '">' . $top[$stat] . '</td>';
			}
			else
			{
			}
			$parse['char_rows'] .= '</tr>';
			$n++;
		}
		$content .= TplParser::parse('stat', $parse, 1);

	}

	$content .= '<br />';
	if ($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'home')
	{
		$page_foot = $sql[SQL_NEXT_ID + $sId]->result($page_foot);
		$content .= page($start + 1, $page_foot, 'stat.php?stat='.$stat, $sId);
	}
	$content .= '<br />';
	Cache::update($content);
	echo $content;
}
else
{
	echo Cache::get();
}
foot();

?>