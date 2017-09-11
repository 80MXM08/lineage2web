<?php

define('L2WEB', true);
require_once("include/core.php");

if (!$_GET['cid'] || !is_numeric($_GET['cid'])) {
    head($Lang['not_found']);
    echo msg($Lang['error'], $Lang['not_found'], 'error', false);
    foot();
    die();
}
$id = fInt(filter_input(INPUT_GET, 'cid'));
$srv = fInt(filter_input(INPUT_GET, 'server'));
$sId = isset($GS[$srv]) ? $GS[$srv]['id'] : 0;

$qry = $sql[SQL_NEXT_ID + $sId]->query('CHAR_INFO', array('id' => $id));

if (!SQL::numRows($qry)) {
    head($Lang['not_found']);
    echo msg($Lang['error'], $Lang['not_found'], 'error', false);
    foot();
    die();
}
$char = SQL::fetchArray($qry);
head("User {$char['char_name']} Info");

$par['lang'] = User::getVar('lang');
$par['mod'] = User::isMod() == true ? 'true' : 'false';
$par['id'] = $char['charId'];
$par['srv'] = $sId;

if (Cache::check("user", implode(';', $par))) {
    $parse = $Lang;
    $parse['time'] = date('d.m.Y H:i:s');
    $parse['update_time'] = date('d.m.Y H:i:s', time() + 900);
    $parse['color'] = $char['sex'] == '0' ? '#8080FF' : '#FF8080';
    $parse['server'] = $sId;
    $parse['c_name'] = $char['char_name'];
    $parse['c_race'] = $char['race'];
    $parse['c_sex'] = $char['sex'];

    $onlinetimeH = round(($char['onlinetime'] / 60 / 60) - 0.5);
    $onlinetimeM = round(((($char['onlinetime'] / 60 / 60) - $onlinetimeH) * 60) - 0.5);
    if ($char['clan_id']) {
        $parse['clan_link'] = "<a href=\"claninfo.php?clan={$char['clan_id']}&amp;server=$sId\">{$char['clan_name']}</a>";
    } else {
        $parse['clan_link'] = "No Clan";
    }
    if ($char['online']) {
        $parse['onoff'] = 'on';
    } else {
        $parse['online'] = $Lang['offline'];
        $parse['onoff'] = 'off';
    }
    $parse['c_level'] = $char['level'];
    $parse['maxCp'] = $char['maxCp'];
    $parse['maxHp'] = $char['maxHp'];
    $parse['maxMp'] = $char['maxMp'];
    $parse['ClassName'] = $char['base_class'];
    $parse['pvpkills'] = $char['pvpkills'];
    $parse['pkkills'] = $char['pkkills'];

    /* $skill_list = $sql->query("SELECT * FROM `character_skills` WHERE `charId`='$id' AND `class_index`='0'");
      $i=0;
      while($skill=$sql->fetch_array($skill_list))
      {
      echo ($i==0)? '<tr>':'';
      $skill_id=($skill[skill_id]<1000)? '0'.$skill[skill_id]:$skill[skill_id];
      echo '<td><img src="img/skills/skill'.$skill_id .'.png" /></td>';
      if($i==4)
      {
      echo '</tr>';
      $i=0;
      }
      else
      {
      $i++;
      }
      } */
    $parse['eq_items'] = '';
    $r = $sql[SQL_NEXT_ID + $sId]->query('CHAR_ITEMS_BY_LOC', array("charID" => $id, "loc" => "PAPERDOLL"));
    while ($p = SQL::fetchArray($r)) {
        $qry = $sql[0]->query('ITEM_INFO', array("itemid" => $p['item_id']));
        $item = SQL::fetchArray($qry);
        $name = $item['name'];
        $addname = L2Web::formatAddName($item['add_name']);
        $enc = L2Web::getEnchant($p['enchant_level']);
        $type = L2Web::$l2web['parts'][$p['loc_data']];
        $parse['eq_items'] .= '<div style="position: absolute; width: 32px; height: 32px; padding: 0px;" class="' . $type . '"><a href="actions.php?a=item_data&id=' . $p['object_id'] . '&server=0" class="item_info"><img border="0" src="img/icons/' . $item['icon'] . '.png" alt="' . $name . '" title="' . $enc . $name . $addname . '" /></a></div>';
    }

    if (!User::isMod()) {
        $parse['inv_items'] = '<div id="inventory" align="left"><div id="inventory_items" class="flexcroll">';
        $r = $sql[SQL_NEXT_ID + $sId]->query('CHAR_ITEMS_BY_LOC', array("charID" => $id, "loc" => "INVENTORY"));
        while ($i = SQL::fetchArray($r)) {
            $qry = $sql[0]->query('ITEM_INFO', array("itemid" => $i['item_id']));
            $item = SQL::fetchArray($qry);
            $name = $item['name'];
            $addname = L2Web::formatAddName($item['add_name']);
            $enc = L2Web::getEnchant($i['enchant_level']);
            $count = L2Web::formatCount($i['count']);
            $parse['inv_items'] .= '<div class="floated"><a href="actions.php?a=item_data&id=' . $i['object_id'] . '&server=0" class="item_info"><img border="0" src="img/icons/' . $item['icon'] . '.png" alt="' . $name . '" title="' . $enc . $name . $addname . $count . '" /></a></div>';
        }
        $parse['inv_items'] .= '<div class="clearfloat"></div></div></div>';

        $parse['ware_items'] = '<div id="inventory" align="left"><div id="inventory_items" class="flexcroll">';
        $r = $sql[SQL_NEXT_ID + $sId]->query('CHAR_ITEMS_BY_LOC', array("charID" => $id, "loc" => "WAREHOUSE"));
        while ($w = SQL::fetchArray($r)) {
            $qry = $sql[0]->query('ITEM_INFO', array("itemid" => $w['item_id']));
            $item = SQL::fetchArray($qry);
            $name = $item['name'];
            $addname = L2Web::formatAddName($item['add_name']);
            $enc = L2Web::getEnchant($w['enchant_level']);
            $count = L2Web::formatCount($w['count']);
            $parse['ware_items'] .= '<div class="floated"><a href="actions.php?a=item_data&id=' . $w['object_id'] . '&server=0" class="item_info"><img border="0" src="img/icons/' . $item['icon'] . '.png" alt="' . $name . '" title="' . $enc . $name . $addname . $count . '" /></a></div>';
        }
        $parse['ware_items'] .= '<div class="clearfloat"></div></div></div>';
    }

    $parse['charlist'] = '';
    foreach ($GS as $dbs) {
        $sql2 = $sql[SQL_NEXT_ID + $dbs['id']]->query('OTHER_ACC_CHARS', array('charId' => $char['charId'], 'acc_name' => $char['account_name']));
        if (!SQL::numRows($sql2)) {
            continue;
        }
        $oparse = $Lang;
        $oparse['Name'] = $dbs['name'];
        $oparse['char_rows'] = '';
        while ($otherchar = SQL::fetchArray($sql2)) {

            if ($otherchar['clan_id']) {
                $clan_link = "<a href=\"claninfo.php?clan={$otherchar['clan_id']}&amp;server={$dbs['id']}\">{$otherchar['clan_name']}</a>";
            } else {
                $clan_link = $Lang['no_clan'];
            }
            $otherchar['sex'] == 0 ? $color = '#8080FF' : $color = '#FF8080';

            $otherchar['online'] ? $online = '<img src="img/online.png" alt="' . $Lang['online'] . '" />' : $online = '<img src="img/status/offline.png" alt="' . $Lang['offline'] . '"/>';
            $oparse['char_rows'].="<tr><td><img src=\"img/face/{$otherchar['race']}_{$otherchar['sex']}.gif\" alt=\"\" /></td><td><a href=\"user.php?cid={$otherchar['charId']}&amp;server={$dbs['id']}\"><font color=\"$color\">{$otherchar['char_name']}</font></a></td><td align=\"center\">{$otherchar['level']}</td><td align=\"center\">{$Lang['class_'.$otherchar['base_class']]}</td><td class=\"maxCp\" align=\"center\">{$otherchar['maxCp']}</td><td class=\"maxHp\" align=\"center\">{$otherchar['maxHp']}</td><td class=\"maxMp\" align=\"center\">{$otherchar['maxMp']}</td><td align=\"center\">{$clan_link}</td><td align=\"center\"><b>{$otherchar['pvpkills']}</b>/<b><font color=\"red\">{$otherchar['pkkills']}</font></b></td><td>{$online}</td></tr>";
        }
        $parse['charlist'].=TplParser::parse('user_other', $oparse, 1);
    }
    $content = TplParser::parse('user', $parse, 1);
    Cache::update($content);
    echo $content;
} else {
    echo Cache::get();
}
foot();
?>