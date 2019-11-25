<?php

define('L2WEB', true);
require_once ('core/core.php');

$stat = getString('stat');
$start=isset($_GET['page'])?getInt('page'):1;

if (!is_numeric($start) || $start == 0) {
    $start = 1;
}
$start = abs($start) - 1;
$rowCount = Conf::get('web', 'top');
$startLimit = $start * $rowCount;
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
    $parse['top'] = $rowCount;
    $parse['srv'] = "&amp;server=" . $sId;
    $parse['server_list'] = null;
    foreach ($GS as $slist) {
        $selected = ($slist['id'] == $server) ? 'selected="selected"' : '';
        $parse['server_list'] .= '<option onclick="GoTo(\'stat.php?stat=' . $stat . '&amp;server=' . $slist['id'] . '\')" ' . $selected . '>' . $slist['name'] . '</option>';
    }
    $content .= tpl::parse('stat_menu', $parse, 1);
    unset($parse);
    if ($stat == 'online') {
        $res = DAO::get()::Char()::getOnlineLimited($sId, '1', $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getOnlineCount($sId, '1');
        $content .= '<h1>' . $Lang['__online_'] . '</h1>';
    } else if ($stat == 'castles') {
        $r = 0;
        $content .= '<table class="forts">';
        $territory_war_enabled = Conf::get('web', 'teritory_war');
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

            $rowparse['clan_link'] = ($row['clan_id']) ? clanLink($sId, $row['clan_id'], $row['clan_name']) : $Lang['__no-owner_'];
            $rowparse['clan_leader_link'] = ($row['clan_leader_id']) ? charLink($sId, $row['clan_leader_id'], $row['clan_leader_name']) : $Lang['__no-lord_'];

            $rowparse['ally_link'] = ($row['ally_id']) ? '[' . allyLink($sId, $row['ally_id'], $row['ally_name']) . ']' : '';
            $rowparse['ally_leader_link'] = ($row['ally_leader_id']) ? '[' . charLink($sId, $row['ally_leader_id'], $row['ally_leader_name']) . ']' : '';

            $rowparse['attackers_link'] = '';
            $attackers = DAO::get()::CastleSiege()::get($sId, $row['id'], '1');
            $s = 1;
            if ($attackers) {
                foreach ($attackers as $attacker) {
                    $rowparse['attackers_link'] .= clanLink($sId, $attacker['clan_id'], $attacker['clan_name']);
                    $rowparse['attackers_link'] .= $s++ % 2 == 0 ? '<br />' : ' ';
                }
            }
            $rowparse['defenders_link'] = '';
            $defenders = DAO::get()::CastleSiege()::get($sId, $row['id'], '0');
            $s = 1;
            if ($defenders) {
                foreach ($defenders as $defender) {
                    $rowparse['defenders_link'] .= clanLink($sId, $defender['clan_id'], $defender['clan_name']);
                    if ($defender['castle_owner']) {
                        $rowparse['defenders_link'] .= htmlImg('img/icons/accessory_crown_i00.png', $Lang['__castle-owner_'], 'icon16');
                    }
                    $rowparse['defenders_link'] .= $s++ % 2 == 0 ? '<br />' : ' ';
                }
            } else {
                $rowparse['defenders_link'] .= $Lang['__npc_'];
            }
            $rowparse['tr2'] = ($r % 3 === 0) ? '</tr>' : '';
            $content .= tpl::parse('stat_castles', $rowparse);
        }
        $content .= '</table>';
    } else if ($stat == 'fort') {
        $r = 0;
        $content .= '<table class="forts">';
        $territory_war_enabled = Conf::get('web', 'teritory_war');
        $res = $territory_war_enabled ? DAO::get()::Fort()::getClanAllyTerritory($sId) : DAO::get()::Fort()::getClanAlly($sId);
        foreach ($res as $row) {
            $rowparse = $row;
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
            $rowparse['clan_link'] = ($row['clan_id']) ? clanLink($sId, $row['clan_id'], $row['clan_name']) : $Lang['__no-owner_'];
            $rowparse['clan_leader_link'] = ($row['clan_leader_id']) ? charLink($sId, $row['clan_leader_id'], $row['clan_leader_name']) : $Lang['__no-lord_'];
            $rowparse['ally_link'] = ($row['ally_id']) ? '[' . allyLink($sId, $row['ally_id'], $row['ally_name']) . ']' : '';
            $rowparse['ally_leader_link'] = ($row['ally_leader_id']) ? '[' . charLink($sId, $row['ally_leader_id'], $row['ally_leader_name']) . ']' : '';
            
            $rowparse['attackers_link'] = '';
            $attackers = DAO::get()::FortSiege()::getAttackingClanIdAndName($sId, $row['id']);
            $s = 1;
            if ($attackers) {
                foreach ($attackers as $attacker) {
                    $rowparse['attackers_link'] .= clanLink($sId, $attacker['clan_id'], $attacker['clan_name']);
                    $rowparse['attackers_link'] .= $s++ % 2 == 0 ? '<br />' : ' ';
                }
            }

            if ($row['lastOwnedTime']) {
                $timeheld = time() - $row['lastOwnedTime'] / 1000;
                $timehour = round($timeheld / 60 / 60);
            } else {
                $timehour = 0;
            }
            $rowparse['fort_hold_time'] = $timehour . ' ' . $Lang['__hours_'];
            $rowparse['tr2'] = '';
            if ($r == 3) {
                $rowparse['tr2'] .= '</tr>';
                $r = 0;
            }

            $content .= tpl::parse('stat_forts', $rowparse, 1);
        }
        $content .= '</table>';
    } else if ($stat == 'clantop') {
        $pageFoot = DAO::get()::Clan()::getCountNonGM($sId);
        $parse['page_foot'] = $pageFoot;
        $i = 1;
        $parse['rows'] = '';
        foreach (DAO::get()::Clan()::getTopNonGMLimited($sId, $startLimit, $rowCount) as $row) {
            if ($row['hasCastle'] != 0) {
                $castle = $row['name'];
            } else {
                $castle = $Lang['__no-castle_'];
            }
            $parse['rows'] .= '<tr' . (($i++ % 2) ? '' : ' class="altRow"') . ' onmouseover="this.bgColor = \'#505050\';" onmouseout="this.bgColor = \'\'"><td>' . clanLink($sId, $row['clan_id'], $row['clan_name']) . '</td>'
                    . '<td>' . charLink($sId, $row['charId'], $row['char_name']) . '</td><td class="numeric sortedColumn">' . $row['clan_level'] . '</td><td>' . $row['reputation_score'] . '</td><td>' . $castle . '</td><td class="numeric">' . $row['ccount'] .
                    '</td></tr>';
        }
        $content .= tpl::parse('stat_clantop', $parse);
    } else if ($stat == 'gm') {
        $res=DAO::get()::Char()::getGMLimited($sId, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getGMCount($sId);
        $content .= '<h1>' . $Lang['__gm_'] . '</h1>';
    } else if ($stat == 'count') {
        $statItem=Conf::get('web', 'stat_item_id');
        $itemName=DAO::get()::L2WItem()::getItemName($statItem);
        $res=DAO::get()::Char()::getRichLimited($sId, $statItem, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getRichCount($sId, $statItem);
        $content .= '<h1>' . $Lang['__rich-players_'] . '</h1>';
        $addheader = '<td><b>' . $itemName . '</b></td>';
        $addcol = true;
    } else if ($stat == 'top_pvp') {
        $stat2='pvpkills';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__pvp_'] . '</h1>';
    } else if ($stat == 'top_pk') {
        $stat2='pkkills';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__pk_'] . '</h1>';
    } else if ($stat == 'maxCp') {
         $stat2='maxCp';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__cp_'] . '</h1>';
        $addheader = '<td class="maxCp"><b>' . $Lang['__max-cp_'] . '</b></td>';
        $addcol = true;
    } else if ($stat == 'maxHp') {
        $stat2='maxHp';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__hp_'] . '</h1>';
        $addheader = '<td class="maxHp"><b>' . $Lang['__max-hp_'] . '</b></td>';
        $addcol = true;
    } else if ($stat == 'maxMp') {
        $stat2='maxMp';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__mp_'] . '</h1>';
        $addheader = '<td class="maxMp"><b>' . $Lang['__max-mp_'] . '</b></td>';
        $addcol = true;
    } else if ($stat == 'top') {
        $stat2='exp';
        $res=DAO::get()::Char()::getTopByStatLimited($sId,$stat2, $startLimit, $rowCount);
        $pageFoot=DAO::get()::Char()::getTopByStatCount($sId, $stat2);
        $content .= '<h1>' . $Lang['__top_'] . ' ' . $rowCount . '</h1>';
    } else if ($stat == 'human') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,0, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 0);
        $content .= '<h1>' . $Lang['__race0_'] . '</h1>';
    } else if ($stat == 'elf') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,1, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 1);
        $content .= '<h1>' . $Lang['__race1_'] . '</h1>';
    } else if ($stat == 'dark_elf') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,2, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 2);
        $content .= '<h1>' . $Lang['__race2_'] . '</h1>';
    } else if ($stat == 'orc') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,3, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 3);
        $content .= '<h1>' . $Lang['__race3_'] . '</h1>';
    } else if ($stat == 'dwarf') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,4, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 4);
        $content .= '<h1>' . $Lang['__race4_'] . '</h1>';
    } else if ($stat == 'kamael') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,5, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 5);
        $content .= '<h1>' . $Lang['__race5_'] . '</h1>';
    } else if ($stat == 'ertheia') {
        $res=DAO::get()::Char()::getTopByRaceLimited($sId,6, $startLimit, $rowCount);
        $pageFoot = DAO::get()::Char()::getCountByRace($sId, 6);
        $content .= '<h1>' . $Lang['__race6_'] . '</h1>';
    } else {
        $parse = null;
        $tchar = DAO::get()::Char()::getCount($sId);
        $parse['race_rows'] = '';
        for ($i = 0; $i < Conf::get('game', 'race_count'); $i++) {
            if ($tchar) {
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

        $content .= tpl::parse('stat_home', $parse);
        if (Conf::get('web', '7signs')) {
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

            $content .= tpl::parse('seven_signs', $parse);
        }
    }

    if ($stat && $stat != 'castles' && $stat != 'fort' && $stat != 'clantop' && $stat != 'home') {
        $parse = null;

        $parse['addheader'] = isset($addheader) ? $addheader : '';
        $parse['char_rows'] = '';

        if ($startLimit != 0 || $startLimit != null) {
            $n = $startLimit + 1;
        } else {
            $n = 1;
        }
        foreach ($res as $top) {
            if ($top['clan_name']) {
                $clan_link = clanLink($sId, $top['clanid'], $top['clan_name']);
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
            $parse['char_rows'] .= '<tr><td align="center"><b>' . $n . '</b></td><td>' . htmlImg('./img/face/' . $top['race'] . '_' . $top['sex'] . '.gif', '') . '</td><td>' . charLink($sId, $top['charId'], htmlFont($color, $top['char_name'])) . '</td><td><center> ' . $top['level'] . '</center></td><td><center>' . $Lang['__class-' . $top['base_class'] . '_'] . '</center></td><td>' . $clan_link . '</td><td><center><b>' . $top['pvpkills'] . '</b>/<b><font color="red">' . $top['pkkills'] .
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

        $content .= page($sId, 'stat.php?stat=' . $stat, $start + 1, $pageFoot);
    }
    $content .= '<br />';
    html::update($page, $pars, $content);
    echo $content;
} else {
    echo html::get($page, $pars);
}
foot();
