<?php

define('L2WEB', true);
require_once ('core/core.php');

$stat = getString('stat');
if (isset($_GET['page'])) {
    $start = getInt('page');
} else {
    $start = 1;
}
if (!is_numeric($start) || $start == 0) {
    $start = 1;
}
$start = abs($start) - 1;
$cTop = Conf::get('web', 'top');
$startlimit = $start * $cTop;


if ($stat == '' || $stat == 'home') {
    $head = $Lang['__home_'];
} else {
    $head = isset($Lang['__head-' . $stat . '_']) ? $Lang['__head-' . $stat . '_'] : $Lang['__error_'];
}
head($head);
$server = getInt('server');
$gmsr = getGSById($server);
$sId = $gmsr['id'];


$par['lang'] = User::getVar('lang');
$par['stat'] = $stat != '' ? $stat : 'home';
$par['page'] = $start + 1;
$par['server'] = $sId;
$pars = implode(';', $par);
$page = 'stat';

if (html::check($page, $pars)) {
    $content = '';
    $parse['top'] = $cTop;
    $parse['srv'] = "&amp;server=" . $sId;
    $parse['server_list'] = null;
    foreach ($GS as $slist) {
        $selected = ($slist['id'] == $server) ? 'selected="selected"' : '';
        $parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat=' . $stat . '&amp;server=' . $slist['id'] . '\')" ' . $selected . '>' . $slist['name'] . '</option>';
    }
    $content .= tpl::parse('stat_menu', $parse, 1);
    unset($parse);
    switch ($stat) {

        case 'online':
            $res = DAO::get()::Char()::getOnlineLimited($sId, '1', $startlimit, $cTop);
            $page_foot = DAO::get()::Char()::getOnlineCount($sId, '1');
            $content .= '<h1>' . $Lang['__online_'] . '</h1>';
            break;

        case 'castles':
            $r = 0;
            $content .= '<table class="forts">';
			$territory_war_enabled=Conf::get('web', 'teritory_war');
            $res = $territory_war_enabled ? DAO::get()::Castle()::getClanAllyTerritory($sId) : DAO::get()::Castle()::getClanAlly($sId);
            foreach ($res as $row) {
                $rowparse = $row;
                $rowparse['tr1'] = ($r === 0) ? '<tr>' : '';
                $r++;
                $rowparse['castle_name'] = $Lang['__castle' . $row['id'] . '_'];
                $rowparse['castle_of_name'] = sprintf($Lang['__castle-of_'], $rowparse['castle_name'], '%s');

                $rowparse['ward_imgs'] = '';
                if ($territory_war_enabled) {

                    $ter_res = $row['wards'];
                    if ($ter_res != '') {
                        $wards = explode(';', $ter_res);
                        foreach ($wards as $ward) {
                            if ($ward == '') {
                                continue;
                            }
                            $rowparse['ward_imgs'] .= htmlImg('img/territories/' . $ward . '.png', $Lang['__ward-info' . $ward . '_']);
                        }
                    }
                    $rowparse['ward_imgs'] .= '<br/>';
                }
                $rowparse['siege_date'] = $Lang['__next-siege_'] . date('D j M Y H:i', $row['siegeDate'] / 1000);

                $rowparse['clan_link'] = ($row['clan_id']) ? htmlLink('clan.php?id=' . $row['clan_id'] . '&amp;server=' . $sId, $row['clan_name']) : $Lang['__no-owner_'];
                $rowparse['clan_leader_link'] = ($row['clan_leader_id']) ? htmlLink('user.php?id=' . $row['clan_leader_id'] . '&amp;server=' . $sId, $row['clan_leader_name']) : $Lang['__no-lord_'];

                $rowparse['ally_link'] = ($row['ally_id']) ? htmlLink('ally.php?id=' . $row['ally_id'] . '&amp;server=' . $sId, $row['ally_name']) : '';
                $rowparse['ally_leader_link'] = ($row['ally_leader_id']) ? htmlLink('user.php?id=' . $row['ally_leader_id'] . '&amp;server=' . $sId, $row['ally_leader_name']) : '';

                $rowparse['attackers_link'] = '';
                $attackers = DAO::get()::CastleSiege()::get($sId, $row['id'], '1');
                $s=1;
                if ($attackers) {
                    foreach ($attackers as $attacker) {
                        $rowparse['attackers_link'] .= htmlLink('clan.php?id=' . $attacker['clan_id'] . '&amp;server=' . $sId, $attacker['clan_name']);
                        $rowparse['attackers_link'] .=$s++%2==0?'<br />':' ';
                    }
                }
                $rowparse['defenders_link'] = '';
                $defenders = DAO::get()::CastleSiege()::get($sId, $row['id'], '0');
                $s=1;
                if ($defenders) {
                    foreach ($defenders as $defender) {
                        $rowparse['defenders_link'] .= htmlLink('clan.php?id=' . $defender['clan_id'], $defender['clan_name']);
                        if($defender['castle_owner'])
                        {
                            $rowparse['defenders_link'] .=htmlImg('img/icons/accessory_crown_i00.png', $Lang['__castle-owner_'], 'icon16');
                        }
                        $rowparse['defenders_link'] .=$s++%2==0?'<br />':' ';
                    }
                } else {
                    $rowparse['defenders_link'] .= $Lang['__npc_'];
                }
                $rowparse['tr2'] = ($r % 3 === 0) ? '</tr>' : '';
                $content .= tpl::parse('stat_castles', $rowparse);
            }
            $content .= '</table>';
            break;

        case 'fort':
            $r = 0;
            $content .= '<table class="forts">';
			$territory_war_enabled=Conf::get('web', 'teritory_war');
            $res = $territory_war_enabled ? DAO::get()::Fort()::getClanAllyTerritory($sId) : DAO::get()::Fort()::getClanAlly($sId);
            foreach ($res as $row) {
				$rowparse=$row;
                $rowparse['tr1'] = ($r == 0) ? '<tr>' : '';
                $r++;
                $rowparse['fort_of_name'] = sprintf($Lang['__fort-of_'], $row['name'], '%s');
                $rowparse['ward_imgs'] = '';
                if ($territory_war_enabled) {
                    $ter_res = $row['wards'];
                    if ($ter_res != '') {
                        $wards = explode(';', $ter_res);
                        foreach ($wards as $ward) {
                            if ($ward == '') {
                                continue;
                            }
                            $rowparse['ward_imgs'] .= htmlImg('img/territories/' . $ward . '.png', $Lang['__ward-info' . $ward . '_']);
                        }
                        $rowparse['ward_imgs'] .= '<br/>';
                    }
                }
                $rowparse['id'] = $row['id'];

                $rowparse['fort_name'] = $row['name'];
				
				$rowparse['clan_link'] = ($row['clan_id']) ? htmlLink('clan.php?id=' . $row['clan_id'] . '&amp;server=' . $sId, $row['clan_name']) : $Lang['__no-owner_'];
                $rowparse['clan_leader_link'] = ($row['clan_leader_id']) ? htmlLink('user.php?id=' . $row['clan_leader_id'] . '&amp;server=' . $sId, $row['clan_leader_name']) : $Lang['__no-lord_'];

                $rowparse['ally_link'] = ($row['ally_id']) ? htmlLink('ally.php?id=' . $row['ally_id'] . '&amp;server=' . $sId, $row['ally_name']) : '';
                $rowparse['ally_leader_link'] = ($row['ally_leader_id']) ? htmlLink('user.php?id=' . $row['ally_leader_id'] . '&amp;server=' . $sId, $row['ally_leader_name']) : '';

				
                //$rowparse['tax'] = $Lang['__tax_'];
                //$rowparse['tax_percent']=$row['taxPercent'];
				/*
				
				$rowparse['attackers_link'] = '';
                $attackers = DAO::get()::CastleSiege()::get($sId, $row['id'], '1');
                $s=1;
                if ($attackers) {
                    foreach ($attackers as $attacker) {
                        $rowparse['attackers_link'] .= htmlLink('clan.php?id=' . $attacker['clan_id'] . '&amp;server=' . $sId, $attacker['clan_name']);
                        $rowparse['attackers_link'] .=$s++%2==0?'<br />':' ';
                    }
                }
                $rowparse['defenders_link'] = '';
                $defenders = DAO::get()::CastleSiege()::get($sId, $row['id'], '0');
                $s=1;
                if ($defenders) {
                    foreach ($defenders as $defender) {
                        $rowparse['defenders_link'] .= htmlLink('clan.php?id=' . $defender['clan_id'], $defender['clan_name']);
                        if($defender['castle_owner'])
                        {
                            $rowparse['defenders_link'] .=htmlImg('img/icons/accessory_crown_i00.png', $Lang['__castle-owner_'], 'icon16');
                        }
                        $rowparse['defenders_link'] .=$s++%2==0?'<br />':' ';
                    }
                } else {
                    $rowparse['defenders_link'] .= $Lang['__npc_'];
                }
				*/
                $rowparse['attackers'] = $Lang['__attackers_'];
                $rowparse['attackers_link'] = '';
                $rowparse['time_held'] = $Lang['__time-held_'];
                foreach ($sql[$sId]->query('FORT_SIEGE', ['id' => $row['id']])as $attackers) {
                    $rowparse['attackers_link'] .= htmlLink('claninfo.php?clanid=' . $attackers['clan_id'] . '&amp;server=' . $sId, $attackers['clan_name']) . '<br />';
                }
                if ($row['lastOwnedTime']) {
                    $timeheld = time() - $row['lastOwnedTime'] / 1000;
                    $timehour = round($timeheld / 60 / 60);
                } else {
                    $timehour = 0;
                }
                $rowparse['fort_hold_time'] = $timehour . ' ' . $Lang['__hours_'];
                if ($r == 3) {
                    $rowparse['tr2'] = '</tr>';
                    $r = 0;
                }
                $content .= tpl::parse('stat_forts', $rowparse, 1);
            }
            $content .= '</table>';
            break;

        case 'clantop':
            $page_foot = $sql[$sId]->query('CLAN_COUNT_NON_GM')->fetchColumn();
            $content .= '<h1>' . $Lang['__head-clantop_'] . '</h1><hr />';
            $content .= '<h2>' . $Lang['__clantop-total_'] . ': ' . $page_foot . '</h2>';
            $content .= '<table border="1" align="center"><thead><tr style="color: green;"><th><b>' . $Lang['__head-clantop_'] . '</b></th>';
            $content .= '<th><b>' . $Lang['__leader_'] . '</b></th>';
            $content .= '<th><b>' . $Lang['__level_'] . '</b></th>';
            $content .= '<th><b>' . $Lang['__reputation_'] . '</b></th>';
            $content .= '<th><b>' . $Lang['__castle_'] . '</b></th>';
            $content .= '<th><b>' . $Lang['__members_'] . '</b></th>';
            $content .= '</tr></thead>';
            $content .= '<tbody>';

            $i = 1;
            foreach ($sql[$sId]->query('CLAN_TOP', [[':limit', (int) $startlimit, PDO::PARAM_INT], [':top', (int) $cTop, PDO::PARAM_INT]]) as $row) {
                if ($row['hasCastle'] != 0) {
                    $castle = $row['name'];
                } else {
                    $castle = $Lang['__no-castle_'];
                }
                $content .= '<tr' . (($i++ % 2) ? '' : ' class="altRow"') . ' onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td>' . htmlLink('claninfo.php?clan=' . $row['clan_id'] . '&server=' . $sId, $row['clan_name']) . '</td>'
                        . '<td>' . htmlLink('user.php?cid=' . $row['charId'] . '&server=' . $sId, $row['char_name']) . '</td><td class="numeric sortedColumn">' . $row['clan_level'] . '</td><td>' . $row['reputation_score'] . '</td><td>' . $castle . '</td><td class="numeric">' . $row['ccount'] .
                        '</td></tr>';
            }
            $content .= '</tbody></table>';
            break;

        case 'gm':

            $res = $sql[$sId]->query('GM_LIST', [[':limit', (int) $startlimit, PDO::PARAM_INT], [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = $sql[$sId]->query('GM_COUNT')->fetchColumn();
            $content .= '<h1>' . $Lang['__gm_'] . '</h1>';
            break;

        case 'count':
            $res = $sql[$sId]->query('CHAR_TOP_BY_ITEM_COUNT', [[':item', (int) Conf::get('web', 'stat_item_id'), PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = $sql[$sId]->query('CHAR_COUNT_BY_ITEM_COUNT', ['item' => Conf::get('web', 'stat_item_id')])->fetchColumn();
            $content .= '<h1>' . $Lang['__rich-players_'] . '</h1>';
            $addheader = '<td><b>' . $Lang['__adena_'] . '</b></td>';
            $addcol = true;
            break;

        case 'top_pvp';
            $res = $sql[$sId]->query('CHAR_TOP_BY_STAT', [[':order', 'pvpkills', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = $sql[$sId]->query('CHAR_COUNT_BY_STAT', ['order' => 'pvpkills'])->fetchColumn();
            $content .= '<h1>' . $Lang['__pvp_'] . '</h1>';
            break;

        case 'top_pk':
            $res = $sql[$sId]->query('CHAR_TOP_BY_STAT', [[':order', 'pkkills', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = $sql[$sId]->query('CHAR_COUNT_BY_STAT', ['order' => 'pkkills'])->fetchColumn();
            $content .= '<h1>' . $Lang['__pk_'] . '</h1>';
            break;

        case 'maxCp':
            $res = $sql[$sId]->query('CHAR_TOP_BY_ADD_STAT', [[':order', 'maxcp', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCount($sId);
            $content .= '<h1>' . $Lang['__cp_'] . '</h1>';
            $addheader = '<td class="maxCp"><b>' . $Lang['__max-cp_'] . '</b></td>';
            $addcol = true;
            break;

        case 'maxHp':
            $res = $sql[$sId]->query('CHAR_TOP_BY_ADD_STAT', [[':order', 'maxhp', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCount($sId);
            $content .= '<h1>' . $Lang['__hp_'] . '</h1>';
            $addheader = '<td class="maxHp"><b>' . $Lang['__max-hp_'] . '</b></td>';
            $addcol = true;
            break;

        case 'maxMp':
            $res = $sql[$sId]->query('CHAR_TOP_BY_ADD_STAT', [[':order', 'maxmp', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCount($sId);
            $content .= '<h1>' . $Lang['__mp_'] . '</h1>';
            $addheader = '<td class="maxMp"><b>' . $Lang['__max-mp_'] . '</b></td>';
            $addcol = true;
            break;

        case 'top':
            $res = $sql[$sId]->query('CHAR_TOP_BY_EXP', [[':race', '*', PDO::PARAM_STR],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCount($sId);
            $content .= '<h1>' . $Lang['__top_'] . ' ' . $cTop . '</h1>';
            break;

        case 'human':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 0, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 0);
            $content .= '<h1>' . $Lang['__race0_'] . '</h1>';
            break;

        case 'elf':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 1, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 1);
            $content .= '<h1>' . $Lang['__race1_'] . '</h1>';
            break;

        case 'dark_elf':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 2, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 2);
            $content .= '<h1>' . $Lang['__race2_'] . '</h1>';
            break;

        case 'orc':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 3, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 3);
            $content .= '<h1>' . $Lang['__race3_'] . '</h1>';
            break;

        case 'dwarf':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 4, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 4);
            $content .= '<h1>' . $Lang['__race4_'] . '</h1>';
            break;

        case 'kamael':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 5, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 5);
            $content .= '<h1>' . $Lang['__race5_'] . '</h1>';
            break;
        case 'ertheia':
            $res = $sql[$sId]->query('CHAR_TOP_BY_RACE', [[':race', 6, PDO::PARAM_INT],
                [':limit', (int) $startlimit, PDO::PARAM_INT],
                [':rows', (int) $cTop, PDO::PARAM_INT]]);
            $page_foot = DAO::get()::Char()::getCountByRace($sId, 6);
            $content .= '<h1>' . $Lang['__race6_'] . '</h1>';
            break;
        default:
            $parse = null;
            $tchar = DAO::get()::Char()::getCount($sId);
            //$c = $sql[$sId]->query('CHAR_COUNT');
            //$cc=$c->fetchColumn();
            $parse['race_rows'] = '';
            for ($i = 0; $i < Conf::get('game', 'race_count'); $i++) {
                if ($tchar) {
                    //$sqlq = $sql[$sId]->query('CHAR_COUNT_BY_RACE', ['race' => $i]);
                    $tfg = round(DAO::get()::Char()::getCountByRace($sId, $i) / ($tchar / 100), 2);
                } else {
                    $tfg = 0;
                }
                $parse['race_rows'] .= '<tr><th>' . $Lang['__race' . $i . '_'] . '</th><td><img src="img/stat/sexline.jpg" height="10px" width="' . $tfg . 'px" alt="" title="' . $tfg . '%" /> ' . $tfg . '%</td></tr>';
            }
            if ($tchar) {
                $male = DAO::get()::Char()::getCountBySex($sId, 0);
                $parse['mc'] = round($male / $tchar * 100, 2);
                $female = DAO::get()::Char()::getCountBySex($sId, 1);
                $parse['fc'] = round($female / $tchar * 100, 2);
            } else {
                $parse['mc'] = $parse['fc'] = 0;
            }
            //$result1 = $sql[SQL_NEXT_ID+$sId]->query(206, array('cabal' => '%dusk%'));
            //$dawn = $sql[SQL_NEXT_ID+$sId]->result($result1);
            //$result2 = $sql[SQL_NEXT_ID+$sId]->query(206, array('cabal' => '%dawn%'));
            //$dusk = $sql[SQL_NEXT_ID+$sId]->result($result2);
            $content .= tpl::parse('stat_home', $parse, 1);
            if (Conf::get('web', '7signs')) {
                //$result3 = $sql[$sId]->query('SEVEN_SIGNS');
                //$row = $sql[$sId]->fetchArray($result3);
                $row = DAO::get()::SevenSigns()::get($sId);
                $parse['twilScore'] = $row['avarice_dusk_score'] + $row['gnosis_dusk_score'] + $row['strife_dusk_score'];
                $parse['dawnScore'] = $row['avarice_dawn_score'] + $row['gnosis_dawn_score'] + $row['strife_dawn_score'];
                $parse['date'] = date('m/d/Y H:i');
                $parse['current_cycle'] = $row['current_cycle'];
                $parse['active_period'] = $row['active_period'];
                $parse['aowner'] = $row['avarice_owner'];
                $parse['gowner'] = $row['gnosis_owner'];
                $parse['sowner'] = $row['strife_owner'];
                if (0 == $parse['active_period']) {
                    $parse['status'] = $Lang['__preperation_'];
                } else if (1 == $parse['active_period']) {
                    $parse['status'] = sprintf($Lang['__competition_'], $parse['current_cycle']);
                } else if (2 == $parse['active_period']) {
                    $parse['status'] = $Lang['__calculation_'];
                } else if (3 == $parse['active_period']) {
                    $parse['status'] = sprintf($Lang['__seal-effect_'], $parse['current_cycle']);
                }

                $content .= tpl::parse('seven_signs', $parse, 1);
            }
            break;
    }

    if ($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop' && $stat != 'home') {
        $parse = null;

        $parse['addheader'] = isset($addheader) ? $addheader : '';
        $parse['char_rows'] = '';

        if ($startlimit != 0 || $startlimit != null) {
            $n = $startlimit + 1;
        } else {
            $n = 1;
        }
        foreach ($res as $top) {
            if ($top['clan_name']) {
                $clan_link = htmlLink('claninfo.php?id=' . $top['clanid'] . '&amp;server=' . $sId, $top['clan_name']);
            } else {
                $clan_link = $Lang['__no-clan_'];
            }
            if ($top['sex'] == 0) {
                $color = '#8080FF';
            } else {
                $color = '#FF8080';
            }
            if ($top['online'] != 0) {
                $online = '<font color="green">' . $Lang['__online_'] . '</font>';
            } else {
                $online = '<font color="red">' . $Lang['__offline_'] . '</font>';
            }
            $parse['char_rows'] .= '<tr><td align="center"><b>' . $n . '</b></td><td>' . htmlImg('./img/face/' . $top['race'] . '_' . $top['sex'] . '.gif', '') . '</td><td>' . htmlLink('user.php?id=' . $top['charId'] . '&amp;server=' . $sId, htmlFont($color, $top['char_name'])) . '</td><td><center> ' . $top['level'] . '</center></td><td><center>' . $Lang['__class-' . $top['base_class'] . '_'] . '</center></td><td>' . $clan_link . '</td><td><center><b>' . $top['pvpkills'] . '</b>/<b><font color="red">' . $top['pkkills'] .
                    '</font></b></center></td><td>' . $online . '</td>';

            if (isset($addcol) && isset($addcolcont)) {
                $parse['char_rows'] .= $addcolcont;
            } elseif (isset($addcol) && !isset($addcolcont)) {
                $parse['char_rows'] .= '<td class="' . $stat . '">' . $top[$stat] . '</td>';
            } else {
                
            }
            $parse['char_rows'] .= '</tr>';
            $n++;
        }
        $content .= tpl::parse('stat', $parse, 1);
    }

    $content .= '<br />';
    $no_foot = ['castles', 'fort', 'home'];
    if ($stat && !in_array($stat, $no_foot)) {

        $content .= page($sId, 'stat.php?stat=' . $stat, $start + 1, $page_foot);
    }
    $content .= '<br />';
    html::update($page, $pars, $content);
    echo $content;
} else {
    echo html::get($page, $pars);
}
foot();
