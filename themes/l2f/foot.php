<?php

$parse = null;
$parse['skinurl'] = 'themes/' . User::getVar('theme');
$parse['foot'] = '';
if ($foot) {
    $parse['blocks_right'] = Block::show('r', true, true);
}
$parse['foot'] = tpl::parse('theme/foot_foot' . ((!$foot) ? '_e' : ''), $parse, true);


$parse['copyrights'] = $Lang['l2_trademark'] . Conf::get('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> (c) LineageII PvP Land') . '<br />';
$parse['debugs'] = '';
#TODO: remove comment
if (Conf::get('debug', 'sql', '0') /* && User::logged() && User::isAdmin() */) {
    $tp = explode(" ", microtime());
    $endTime = $tp[1] . substr($tp[0], 1);
    $totalTime = round(bcsub($endTime, $startTime, 6), 4);
    $tst = 0;
    $qc = 0;
    foreach ($sql as $s) {
        $tst += $s->getTime();
        $qc += $s->getQueryCount();
        $parse['debugs'] .= $s->debug($parse);
    }
    $avgqt = round($tst / $qc, 4);
    $parse['timeString'] = sprintf($Lang['page_generated'], $totalTime, $tst, $qc, $avgqt);
    $parse['debugDisplay'] = !User::getVar('debug_menu') ? 'block' : 'none';
    $parse['debugDisplay2'] = User::getVar('debug_menu') ? 'block' : 'none';
}
if (Conf::get('debug', 'user', 0)) {
    $parse['debugs'] .= User::debug();
}

tpl::parse('theme/foot', $parse, false);
