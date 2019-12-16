<?php

define('L2WEB', true);
require_once('core/core.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    head($Lang['__not-found_']);
    echo msg($Lang['__error_'], $Lang['__not-found_'], 'error', false);
    foot();
    die();
}
$class = isset($_GET['class']) ? fInt(filter_input(INPUT_GET, 'class')) : 0;
$id = fInt(filter_input(INPUT_GET, 'id'));
$srv = fInt(filter_input(INPUT_GET, 'server'));
$gsrv = getGSById($srv);
$sId = $gsrv['id'];
$reCache = fBool(filter_input(INPUT_GET, 'recache'));
$char = DAO::get()::Char()::getCharAndClanData($sId, $id);
if (!$char) {
    head($Lang['__not-found_']);
    echo msg($Lang['__error_'], $Lang['__not-found_'], 'error', false);
    foot();
    die();
}

head(sprintf($Lang['__user-s-info_'], $char['char_name']));


$par['lang'] = User::getVar('lang');
$par['mod'] = User::isMod() == true ? 'true' : 'false';
$par['id'] = $char['charId'];
$par['srv'] = $sId;
$pars = implode(';', $par);
$page = 'user';

if (html::check($page, $pars, $reCache)) {
    $parse = $char;
    //$parse['main_sub'] = $char['base_class'] == $char['classid'] ? $Lang['__main-class_'] : $Lang['__sub-class_'];
    $parse['main_sub'] = $Lang['__main-class_'];
    $parse['time'] = date('d.m.Y H:i:s');
    $parse['update_time'] = date('d.m.Y H:i:s', time() + 900);
    $parse['color'] = $char['sex'] == '0' ? '#8080FF' : '#FF8080';
    $parse['server'] = $sId;
    //$parse['ClassName'] = $Lang['__class-' . $char['classid'] . '_'];
    $parse['ClassName'] = $Lang['__class-' . $char['base_class'] . '_'];
    $parse['eq_items'] = $parse['inv_items'] = $parse['ware_items'] = $parse['charlist'] = $parse['skills'] = '';
    $onlinetimeH = round(($char['onlinetime'] / 60 / 60) - 0.5);
    $onlinetimeM = round(((($char['onlinetime'] / 60 / 60) - $onlinetimeH) * 60) - 0.5);
    $gs = getGSById($sId);
    if ($char['clan_id']) {
        $parse['clan_link'] = '<a href="claninfo.php?id=' . $char['clan_id'] . '&amp;server=' . $sId . '">' . $char['clan_name'] . '</a>';
    } else {
        $parse['clan_link'] = $Lang['__no-clan_'];
    }
    if ($char['ally_id']) {
        $parse['ally_link'] = '<a href="allyinfo.php?id=' . $char['ally_id'] . '&amp;server=' . $sId . '">' . $char['ally_name'] . '</a>';
    } else {
        $parse['ally_link'] = $Lang['__no-ally_'];
    }
    if ($char['online']) {
        $parse['onoff'] = 'on';
    } else {
        $parse['online'] = $Lang['__offline_'];
        $parse['onoff'] = 'off';
    }
    $parse['sub_rows'] = '';
    //$subs = DAO::getInstance()::getChar()::getSubclassesNotCurrent($sId, $char['charId'], $char['classid']);
    $subs = DAO::get()::Char()::getSubclasses($sId, $char['charId']);
    if ($subs) {
        foreach ($subs as $sub) {
            $sparse = $sub;
            $type = $char['base_class'] == $sub['class_id'] ? '[Main]' : '[Sub]';
            $sparse['class'] = '<a href="user.php?id=' . $id . '&amp;server=' . $sId . '&amp;class=' . $sub['class_index'] . '">' . $Lang['__class-' . $sub['class_id'] . '_'] . '</a> ' . $type;
            $hennas = DAO::get()::Henna()::getAll($sId, $char['charId'], $sub['class_index']);
            $sparse['henna'] = '';
            if ($hennas) {
                foreach ($hennas as $henna) {
                    $sparse['henna'] .= L2WEBH5::drawSimpleHenna($henna['symbol_id']);
                }
            }
            $parse['sub_rows'] .= tpl::parse('user_sub_rows', $sparse);
        }
    }
    $pdoll = DAO::get()::Item()::getByLoc($sId, $id, 'PAPERDOLL');
    if ($pdoll) {
        foreach ($pdoll as $p) {
            $parse['eq_items'] .= $gs['l2web']::drawItem($p, $sId, 'P');
        }
    }
    $henna = DAO::get()::Henna()::getAll($sId, $id, '0');
    if ($henna) {
        foreach ($henna as $h) {
            $parse['eq_items'] .= $gs['l2web']::drawHenna($h['symbol_id'], $h['slot']);
        }
    }

    if (User::isMod() || true) { //remove true

        $parse['inv_items'] .= '<div id="inventory" align="left"><div id="inventory_items" class="flexcroll">';
        $inv = DAO::get()::Item()::getByLoc($sId, $id, 'INVENTORY');
        if ($inv) {
            foreach ($inv as $i) {
                $parse['inv_items'] .= $gs['l2web']::drawItem($i, $sId, 'I');
            }
        }
        $parse['inv_items'] .= '<div class="clearfloat"></div></div><div id="I_tip"></div></div>';

        $parse['ware_items'] .= '<div id="inventory" align="left"><div id="inventory_items" class="flexcroll">';
        $ware = DAO::get()::Item()::getByLoc($sId, $id, 'WAREHOUSE');
        if ($ware) {
            foreach ($ware as $w) {
                $parse['ware_items'] .= $gs['l2web']::drawItem($w, $sId, 'W');
            }
        }
        $parse['ware_items'] .= '<div class="clearfloat"></div></div><div id="W_tip"></div></div>';

        $i = 0;
        $skills = DAO::get()::Skills()::get($sId, $id, '0');
        $parse['skills'] .= '<div id="inventory" align="left"><div id="inventory_items" class="flexcroll">';
        if ($skills) {
            foreach ($skills as $skill) {
                $parse['skills'] .= $gs['l2web']::drawSkill($sId, $skill['skill_id'], $skill['skill_level']);
            }
        }
        $parse['skills'] .= '<div class="clearfloat"></div></div><div id="S_tip"></div></div>';
    }

    foreach ($GS as $dbs) {
        $chars = DAO::get()::Char()::getOtherChars($dbs['id'], $char['charId'], $char['account_name']);
        if (count($chars) == 0) {
            continue;
        }
        $oparse['Name'] = $dbs['name'];
        $oparse['char_rows'] = '';
        foreach ($chars as $otherchar) {
            $orparse = $otherchar;
            $orparse['clan_link'] = $otherchar['clan_id'] ? '<a href="claninfo.php?id=' . $otherchar['clan_id'] . '&amp;server=' . $dbs['id'] . '">' . $otherchar['clan_name'] . '</a>' : $Lang['__no-clan_'];
            $orparse['ally_link'] = $otherchar['ally_id'] ? '<a href="allyinfo.php?id=' . $otherchar['ally_id'] . '&amp;server=' . $dbs['id'] . '">' . $otherchar['ally_name'] . '</a>' : $Lang['__no-ally_'];
            $orparse['color'] = ($otherchar['sex'] == 0) ? '#8080FF' : '#FF8080';
            $orparse['sId'] = $dbs['id'];
            $orparse['class'] = $Lang['__class-' . $otherchar['base_class'] . '_'];
            $orparse['online'] = $otherchar['online'] ? 'online' : 'offline';
            $orparse['lgOnline'] = $otherchar['online'] ? $Lang['__online_'] : $Lang['__offline_'];

            $oparse['char_rows'] .= tpl::parse('user_other_row', $orparse);
        }
        $parse['charlist'] .= tpl::parse('user_other', $oparse);
    }
    $content = tpl::parse('user', $parse);
    html::update($page, $pars, $content);
    echo $content;
} else {
    echo html::get($page, $pars);
}
foot();