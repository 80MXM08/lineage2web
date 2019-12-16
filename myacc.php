<?php

define('L2WEB', true);
require_once ('core/core.php');
User::isLoggedOrReturn('myacc.php');

head($Lang['__my-chars_']);
echo sprintf($Lang['__welcome_'], $_SESSION['account']);
echo '<br />';
$timevoted = $_SESSION['vote_time'];
$now = time();

if ($timevoted <= ($now - 60 * 60 * 12)) {
    echo "<a href=\"vote.php\"><font color=\"red\">" . $Lang['__vote_'] . "</font></a><br />";
} else {
    echo "<font color=\"red\">You can vote again after " . date('H:i:s', $timevoted - ($now - 60 * 60 * 12) - 60 * 60 * 2) . "</font><br />";
}
$parse['account'] = User::getUser();
$parse['reward'] = Conf::get('vote', 'reward');
$parse['gsRows'] = '';
foreach ($GS as $g) {
    $i = 0;
    $parse1['serverName'] = $g['name'];
    $parse1['charRows'] = '';
    foreach (DAO::get()::Char()::getAccountAllChars($g['id'], User::getUser()) as $char) {
        $parse2 = $char;
        $i++;
        $onlinetimeH = round(($char['onlinetime'] / 60 / 60) - 0.5);
        $onlinetimeM = round(((($char['onlinetime'] / 60 / 60) - $onlinetimeH) * 60) - 0.5);

        $parse2['online'] = $char['online'] ? 'online' : 'offline';
        $parse2['map_checked'] = ($char['onlinemap'] == 'true') ? 'checked="checked"' : '';
        $parse2['charLink'] = charLink($g['id'], $char['charId'], $char['char_name']);
        $parse2['clanLink'] = $char['clan_id'] ? clanLink($g['id'], $char['clan_id'], $char['clan_name']) : $Lang['__no-clan_'];
        $parse2['allyLink'] = $char['ally_id'] ? allyLink($g['id'], $char['ally_id'], $char['ally_name']) : '';
        $parse2['altRow'] = ($i % 2 == 0) ? ' style="altRow"' : '';
        $parse1['charRows'] .= tpl::parse('myacc_charrow', $parse2);
    }
    echo "</table>";
    $parse['gsRows'] .= tpl::parse('myacc_gsrow', $parse1);
    echo tpl::parse('myacc', $parse);
}
foot();
