<?php
if (!defined('CORE')) {
    header('Location: ../../index.php');
    exit();
}

$parse['skinurl'] = 'themes/' . User::getVar('theme');
$parse['foot'] = '';
if ($foot) {
    $parse['blocks_right'] = Block::show('r');
}
$parse['foot'] = tpl::parse('theme/foot_foot' . ((!$foot) ? '_e' : ''), $parse);


$parse['copyrights'] = $Lang['__l2-trademark_'] . Conf::get('web', 'copy');
$parse['debugs'] = '';

if ((Conf::get('debug', 'bar')=='2') || (Conf::get('debug', 'bar') == '1' && User::isAdmin())) {
    $tp = explode(" ", microtime());
    $endTime = $tp[1] . substr($tp[0], 1);
    $totalTime = round(bcsub($endTime, $startTime, 6), 4);
    $tst = 0;
    $qc = 0;
    foreach ($sql as $s) {
        if ($s->isDebug()) {
            $tst += $s->getTime();
            $qc += $s->getQueryCount();
            $parse['debugs'] .= $s->debug($parse);
        }
    }

    $parse['timeString'] = sprintf($Lang['__page-generated_'], $totalTime, $tst, $qc);
    $parse['debugDisplay'] = !User::getVar('debugMenu') ? 'block' : 'none';
    $parse['debugDisplay2'] = User::getVar('debugMenu') ? 'block' : 'none';
}
else
{
    $parse['debugDisplay'] = 'none';
    $parse['debugDisplay2'] = 'none';
}
if (Conf::get('debug', 'user')) {
    $parse['debugs'] .= User::printDebug();
}

echo tpl::parse('theme/foot', $parse);
