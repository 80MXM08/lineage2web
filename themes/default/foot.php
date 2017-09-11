<?php

$parse = $Lang;
$parse['skinurl'] = 'themes/' . User::getVar('theme');
$parse['foot'] = '';
#TODO: build from SQL
if ($foot)
{
	$parse['blocks_right'] = includeBlock('stats', $Lang['stats'], 1, true);
	$parse['blocks_right'] .= includeBlock('top10', $Lang['top10'], 1, true);


	//$parse['blocks_right'].=includeBlock('vote', $Lang['vote'],1,true);
}
$parse['foot'] = TplParser::parse('theme/foot_foot' . ((!$foot) ? '_e' : ''), $parse, true);


$parse['copyrights'] = $Lang['l2_trademark'] . Config::get('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> (c) LineageII PvP Land') . '<br />';
$parse['debugs'] = '';
#TODO: remove comment
if (Config::get('debug', 'sql', '0') /*&& User::logged() && User::isAdmin()*/ )
{
	$tp = explode(" ", microtime());
	$endTime = $tp[1] . substr($tp[0], 1);
	$totalTime = round(bcsub($endTime, $startTime, 6), 4);
	$tst = round(SQL::getTime(), 4);
	$avgqt = round(SQL::getTime() / SQL::getQueryCount(), 4);
	$qc = round(SQL::getQueryCount(), 4);
	$parse2 = $parse;
	$parse2['timeString'] = sprintf($Lang['page_generated'], $totalTime, $tst, $qc, $avgqt);
	$parse2['debugDisplay'] = !User::getVar('debug_menu') ? 'block' : 'none';
	$parse2['debugDisplay2'] = User::getVar('debug_menu') ? 'block' : 'none';

	$parse['debugs'] .= SQL::debug($parse2);

}
if (Config::get('debug', 'user', 0))
{
	$parse['debugs'] .= User::debug();
}

TplParser::parse('theme/foot', $parse, false);
?>