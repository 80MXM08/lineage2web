<?php
define('L2WEB', true);
require_once ("include/core.php");

//loggedInOrReturn('webshop.php');

if (isset($_GET['page'])) {
    $start = fInt(filter_input(INPUT_GET, 'page'));
} else {
    $start = 1;
}
$serverId = fInt(filter_input(INPUT_GET, 'server'));
if ($serverId) {
    $server = $GS[$serverId];
} else {
    $server = $GS[0];
}

if (!is_numeric($start) || $start == 0) {
    $start = 1;
}
$start = abs($start) - 1;
$startlimit = $start * Config::get('settings', 'TOP', '10');
$a = fString(filter_input(INPUT_GET, 'a'));
$par['lang'] = User::getVar('lang');
$par['a'] = $a != '' ? $a : 'home';
$par['page'] = $page = $start + 1;
$menu = "";
$menu.= "<h1>WebShop</h1><br />";
$menu.='<select name="server">';

foreach ($GS as $slist) {
    $selected = ($slist['id'] == $serverId) ? 'selected="selected"' : '';
    $menu .= '<option onclick="GoTo(\'webshop.php?a=' . $a .
            '&amp;server=' . $slist['id'] . '\')" ' . $selected . '>' . $slist['name'] . '</option>';
}
$menu.='</select>';
$menu.= "<center><a href=\"webshop.php\">All Items</a> | <a href=\"webshop.php?a=add\">Add Item</a> | <a href=\"webshop.php?a=my\">View My Items</a></center><br />";

switch ($a) {
##################################################  Add Item to DB  #######################################
    case "additem":
        $objectId = getVar('item');
        $sql[3]->query("SELECT * FROM `$db`.`items` WHERE `object_id`='$objectId' AND `owner_id` IN (SELECT `charId` FROM `$db`.`characters` WHERE `account_name`='{$_SESSION['account']}' AND `online`='0') AND `item_id`!='57' AND `count`>'0' AND `mana_left`='-1' AND `time`='-1'");
        if (SQL::numRows()) {
            $count = fInt(filter_input(INPUT_GET, 'count'));
            $money = fInt(filter_input(INPUT_GET, 'money'));
            $moneyc = fInt(filter_input(INPUT_GET, 'money_count'));
            $comment = fInt(filter_input(INPUT_GET, 'comment'));
            $item = SQL::fetch_array();
            if ($count > $item['count']) {
                head();
                msg('Error', 'Incorrect count!', 'error');
                foot();
            }
            if ($money > '1' || $money < 0) {
                head();
                msg('Error', 'Incorrect money!', 'error');
                foot();
            }
            if ($moneyc <= 0 || $moneyc == '') {
                head();
                msg('Error', 'Incorrect money count', 'error');
                foot();
            }
            $sql[3]->query("SELECT `elemType`, `elemValue` FROM `$db`.`item_elementals` WHERE `itemId` = '$objectId';");
            $elements = "";
            if ($SQL::numRows()) {
                $el = array();
                while ($ele = SQL::fetchArray()) {
                    $el[] = implode(",", $ele);
                }
                $elements = implode(";", $el);
            }
            $sql[3]->query("SELECT `augAttributes`, `augSkillId`, `augSkillLevel` FROM `$db`.`item_attributes` WHERE `itemId` = '$objectId'");
            $aug = null;
            if ($sql[3]->numRows()) {
                $auga = SQL::fetchArray();
                $aug = implode(",", $auga);
            }
            $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
            $addinfo = SQL::fetchArray();
            $object_id = getConfig('webshop', 'inc', '0') + 1;

            $sql[0]->query("INSERT INTO `webshop` (`owner`, `object_id`, `item_id`, `count`, `enchant_level`, `money`, `money_count`, `sticky`, `added`, `comment`, `type`, `grade`, `elementals`, `augument`, `server`) VALUES ('{$_SESSION['account']}', '$object_id', '{$item['item_id']}', '$count', '{$item['enchant_level']}', '$money', '$moneyc', '0', NOW(), '$comment', '{$addinfo['type']}', '{$addinfo['grade']}', '$elements','$aug', '{$server['ID']}')");

            setConfig('webshop', 'inc', $object_id);
            if (SQL::getRowCount()) {
                $sql[3]->query("DELETE FROM `$db`.`items` WHERE `object_id`='$objectId'");
                $sql[3]->query("DELETE FROM `$db`.`item_elementals` WHERE `itemId`='$objectId'");
                $sql[3]->query("DELETE FROM `$db`.`item_attributes` WHERE `itemId`='$objectId'");
                $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
                $itemadd = SQL::fetchArray();
                $body = "You have added [url=item.php?id={$item['item_id']}][img]img/icons/{$itemadd['icon1']}.png[/img][/url][hr][url=webshop.php?a=view&id=$object_id]View Your Item[/url]|[url=webshop.php?a=add]Add Another[/url]";
                $sql[0]->query("INSERT INTO `messages` (`receiver`, `added`, `subject`, `msg`) VALUES ('{$_SESSION['account']}', NOW(), 'Webshop Item Add', '$body')");
                head();
                msg('Success', 'Your item has been added');
                foot();
            }
        } else {
            head();
            msg('Error', 'Nothing to add', 'error');
            foot();
        }
        die();

        break;
##################################################  Add Item to DB  #######################################
##################################################  Add Item   ############################################
    case "add":
        head("WebShop - Add Item");
        echo $menu;
        if ($_POST) {
            $objectId = fInt(filter_input(INPUT_POST, 'item'));
            $sql[3]->query("SELECT * FROM `$db`.`items` WHERE `object_id`='$objectId' AND `owner_id` IN (SELECT `charId` FROM `$db`.`characters` WHERE `account_name`='{$_SESSION['account']}' AND `online`='0') AND `item_id`!='57' AND `count`>'0' AND `mana_left`='-1' AND `time`='-1'");
            if (SQL::numRows()) {
                $item = SQL::fetchArray();
                $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
                $itemadd = SQL::fetchArray();
                ?>
                <form name="item" action="?a=additem" method="post">
                    <table cellpadding="5" cellspacing="5" border="2" width="425px">
                        <tr><td><img src="img/icons/<?php echo $itemadd['icon1']; ?>.png" alt="<?php echo $itemadd['name']; ?>" title="<?php echo $itemadd['name']; ?>" width="64" height="64"/></td>
                            <td><table border="1" width="315px">
                                    <tr><td>Name</td><td><?php echo $itemadd['name'] . $addname; ?></td></tr>
                                    <tr><td>Type</td><td><?php echo $item['type']; ?></td></tr>
                                    <tr><td>Body Part</td><td><?php echo $itemadd['bodypart']; ?></td></tr>
                <?php
                $grade = ($item['grade'] != 'none') ? "<img src=\"img/grade/{$item['grade']}-grade.png\" alt=\"{$item['grade']}\" title=\"{$item['grade']}\" />" : "none";
                ?>
                                    <tr><td>Grade</td><td><?php echo $grade; ?></td></tr>
                <?php
                if ($item['enchant_level'] != '' && $item['enchant_level'] > 0) {
                    ?>
                                        <tr><td>Enchant</td><td><?php echo $item['enchant_level']; ?></td></tr>
                    <?php
                }
                $eleq = $sql[3]->query("SELECT * FROM `$db`.`item_elementals` WHERE `itemId` = '$objectId';");
                if (SQL::numRows($eleq)) {
                    echo '<tr><td>Elementals</td><td><table>';
                    $type = $itemadd['type'];
                    while ($ele = SQL::fetchArray($eleq)) {
                        drawElement($type, $ele['elemType'], $ele['elemValue']);
                    }
                    echo '</table></td></tr>';
                }
                ?>
                                    <?php
                                    $augq = $sql[3]->query("SELECT * FROM `$db`.`item_attributes` WHERE `itemId` = '$objectId';");
                                    if (SQL::numRows($augq)) {
                                        $aug = SQL::fetchArray($augq);
                                        $augatr1 = $aug['augAttributes'] % 65536;
                                        $augatr2 = floor($aug['augAttributes'] / 65536);
                                        $sql[0]->query("SELECT `desc` FROM `$webdb`.`optiondata` WHERE `id`='$augatr1';");
                                        $aug1 = SQL::result();
                                        $sql[0]->query("SELECT `level`, `desc` FROM `$webdb`.`optiondata` WHERE `id`='$augatr2';");
                                        $aug2 = SQL::fetchArray();
                                        $color = augColor($aug2['level']);
                                        ?>
                                        <tr><td>Augment</td><td><font color="<?php echo $color; ?>"><?php echo $aug1 . '<br />' . $aug2['desc']; ?></font></td></tr>
                                        <?php
                                    }
                                    ?>

                                    <tr><td>Count</td><td><input type="text" name="count" /> Max:<?php echo $item['count']; ?></td></tr>
                                    <tr><td>Price<br /> per 1 item</td><td><select name="money"><option value="0">Adena</option><option value="1">Webpoints</option></select><input type="text" name="money_count" /></td></tr>
                                </table></td></tr></table><br />
                                    <?php
                                    if ($itemadd['desc'] != "" || $itemadd['grade'] == "none") {
                                        if ($itemadd['desc'] != "") {
                                            ?>
                            Description:<br />
                            <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $itemadd['desc']; ?></td></tr></table>
                                            <?php
                                        }
                                    } else {
                                        if ($itemadd['bodypart'] == "lhand")
                                            $itemadd['bodypart'] = "shield";
                                        $c = $sql[0]->query("SELECT `chest` FROM `$db`.`armorsets` WHERE `{$itemadd['bodypart']}`='{$itemadd['id']}'");
                                        if (SQL::numRows($c)) {
                                            $chest_id = SQL::result($c);
                                            $i['desc'] = SQL::result($sql[0]->query("SELECT `desc` FROM `all_items` WHERE `id`='$chest_id'"));
                                            ?>
                            Description:<br />
                            <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $itemadd['desc']; ?></td></tr></table>
                        <?php
                    }
                }
                ?>
                    Comment:<br />
                    <?php
                    textbbcode('item', 'comment');
                    ?>
                    <br /><input type="hidden" name="item" value="<?php echo $objectId; ?>" /> <input type="submit" value="Add Item" /></form>
                    <?php
                }
            } else {
                $qry = $sql[3]->query("SELECT * FROM `$db`.`items` WHERE `owner_id` IN (SELECT `charId` FROM `$db`.`characters` WHERE `account_name`='{$_SESSION['account']}' AND `online`='0') AND `item_id`!='57' AND `count`>'0' AND `mana_left`='-1' AND `time`='-1'");
                echo '<form action="" method="post"><select name="item">';
                while ($item = SQL::fetchArray($qry)) {
                    $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
                    $all = SQL::fetchArray();
                    $addname = $addname != '' ? ' - ' . $addname : '';
                    $ench = $item['enchant_level'] > 0 ? ' + ' . $item['enchant_level'] : '';
                    echo '<option value="' . $item['object_id'] . '">' . $all['name'] . $addname . $ench . '</option>';
                }
                echo '</select><br /><input type="submit" value="Next" /></form>';
            }
            foot();
            break;
##################################################  Add Item   ############################################
##################################################  My Items   ############################################
        case "my":
            $page = getVar('page');
            $par['user'] = $_SESSION['account'];
            $par['server'] = $server['ID'];
            $params = implode(';', $par);
            $cachefile = 'webshop';
            $qry = $sql[0]->query("SELECT * FROM `$webdb`.`webshop` WHERE `owner`='{$_SESSION['account']}' AND `server`='{$server['ID']}' LIMIT $startlimit, {$CONFIG['settings']['TOP']}");
            if (!SQL::numRows($qry)) {
                head();
                msg('Error', 'You don\'t have any item in webshop', 'error');
                foot();
            }
            head('WebShop - My Items');
            if ($cache->needUpdate($cachefile, $params)) {

                $menu.="<table border=\"1\">";
                $menu.="<tr><th>Icon</th><th>Name</th><th>Price</th><th>Owner</th><th>Action</th></tr>";

                while ($item = SQL::fetchArray($qry)) {
                    $details = $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
                    $item_d = SQL::fetchArray($details);
                    $addname = ($item_d['addname'] == "") ? "" : " - " . $item_d['addname'];
                    $price = ($item['money'] == "0") ? " Adena" : " WebPoints";
                    $grade = $item_d["grade"];
                    $grade = (!empty($grade) || $grade != "none") ? "&lt;img border=\\'0\\' src=\\'img/grade/" . $grade . "-grade.png\\' />" : "";
                    $enchant = $item["enchant_level"] > 0 ? " +" . $item["enchant_level"] : "";

                    $menu.="<tr><td>";
                    $menu.="<img src=\"img/icons/{$item_d['icon1']}.png\" alt=\"{$item_d['name']}\" title=\"{$item_d['name']}\" onmouseover=\"Tip('&lt;img src=\'img/icons/{$item_d['icon1']}.png\' /&rt;&lt;br /> {$item_d['desc']}',TITLE, '{$enchant} {$item_d['name']}$addname {$grade}', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\" />";
                    $menu.="</td><td>";
                    $menu.="{$item_d['name']}$addname x{$item['count']}";
                    $menu.="</td><td>";
                    $menu.="{$item['money_count']} $price";
                    $menu.="</td><td>";
                    $menu.="{$item['owner']}";
                    $menu.="</td><td>";
                    $menu.="<a href=\"webshop.php?a=view&amp;id={$item['object_id']}\">View</a> | <a href=\"webshop.php?a=transfer&amp;id={$item['object_id']}\">Edit/Transfer to Game</a>";
                    $menu.="</td></tr>";
                }
                $menu.="</table>";
                $count = SQL::result($sql[0]->query("SELECT Count(*) FROM `webshop` WHERE owner='{$_SESSION['account']}'"));
                $menu.=page($page, $count, '?a=my', $serverId);

                $cache->updateCache($cachefile, $menu, $params);
                echo $menu;
            } else {
                echo $cache->getCache($cachefile, $params);
            }
            foot();
            break;
##################################################  My Items   ############################################
###############################################  Transfer Item   ##########################################
        case "transfer":
            $id = getVar('id');
            $qry = $sql[0]->query("SELECT * FROM `$webdb`.`webshop` WHERE `object_id`='$id' AND `owner`='{$_SESSION['account']}'");
            if (!SQL::numRows($qry)) {
                head();
                msg('Error', 'Cannot find item', 'error');
                foot();
            }
            $item = SQL::fetchArray($qry);
            if ($_POST) {
                $char = getVar('char');
                $serv = getDBInfo($item['server']);
                $sql[3]->query("SELECT `charId`, `char_name` FROM `{$serv['database']}`.`characters` WHERE `account_name`='{$_SESSION['account']}' AND `online`='0'");
                if (!SQL::numRows()) {
                    head();
                    msg('Error', 'Character not found', 'error');
                    foot();
                }
                $char = SQL::fetchArray();
                $sql[0]->query("DELETE FROM `webshop` WHERE `object_id`='{$item['object_id']}'");
                if (!SQL::getRowCount()) {
                    head();
                    msg('Error', 'Failed to remove item from webshop', 'error');
                    foot();
                }
                $itemNum = SQL::result($sql[3]->query("SELECT MAX(`itemNum`) FROM `{$serv['database']}`.`character_premium_items` WHERE `charId`='{$char['charId']}'")) + 1;
                $sql[3]->query("INSERT INTO `{$serv['database']}`.`character_premium_items` (`charId`, `itemNum`, `itemId`, `itemCount`, `itemSender`, `itemEnchantLevel`, `itemAugument`, `itemElementals`) VALUES ('{$char['charId']}', '$itemNum', '{$item['item_id']}', '{$item['count']}', 'WebShop', '{$item['enchant_level']}', '{$item['augument']}', '{$item['elementals']}')");
                if (!SQL::getRowCount()) {
                    head();
                    msg('Error', 'Failed to insert item in game. Please contact ADMIN with this info [' . print_r($item) . ']', 'error');
                    foot();
                    die();
                }
                head();
                msg('Success', 'Your item has been successfully delivered to game. Please visit Dimensional Merchant to receive your item');
                foot();
                die();
            } else {
                $sql[0]->query("SELECT * FROM `all_items` WHERE `id`='{$item['item_id']}'");
                $itemi = SQL::fetchArray();
                $addname = ($itemi['addname'] != '') ? ' - ' . $itemi['adname'] : '';
                head('WebShop - Transfer Item');
                echo $menu;
                ?><form name="item" action="?a=edit" method="POST">
                <table cellpadding="5" cellspacing="5" border="2" width="425px">
                    <tr><td><img src="img/icons/<?php echo $itemi['icon1']; ?>.png" alt="<?php echo $itemi['name']; ?>" title="<?php echo $itemi['name']; ?>" width="64" height="64"/></td>
                        <td><table border="1" width="315px">
                                <tr><td>Name</td><td><?php echo $itemi['name'] . $addname; ?></td></tr>
                                <tr><td>Type</td><td><?php echo $itemi['type']; ?></td></tr>
                                <tr><td>Body Part</td><td><?php echo $itemi['bodypart']; ?></td></tr>
                                <tr><td>Active:</td><td>Yes: <input name="active" type="checkbox" <?php echo $item['active'] ? 'checked="checked"' : ''; ?> /></td></tr>
            <?php
            $grade = ($itemi['grade'] != 'none') ? "<img src=\"img/grade/{$itemi['grade']}-grade.png\" alt=\"{$itemi['grade']}\" title=\"{$itemi['grade']}\" />" : "none";
            ?>
                                <tr><td>Grade</td><td><?php echo $grade; ?></td></tr>
            <?php
            if ($item['enchant_level'] != '' && $item['enchant_level'] > 0) {
                ?>
                                    <tr><td>Enchant</td><td><?php echo $item['enchant_level']; ?></td></tr><?php
            }
            ?>
                                <tr><td>Count</td><td><?php echo $item['count']; ?></td></tr>
                                <tr><td>Price<br /> per 1 item</td><td><input type="text" name="moneyc" value="<?php echo $item['money_count']; ?>" /><select name="money"><option value="0" <?php echo $item['money'] == 0 ? "selected=\"\"" : ''; ?>>Adena</option><option value="1" <?php echo $item['money'] == 1 ? "selected=\"\"" : ''; ?>>Webpoints</option></select></td></tr>
                            </table></td></tr></table><br />
            <?php
            if ($itemi['desc'] != "" || $itemi['grade'] == "none") {
                if ($itemi['desc'] != "") {
                    ?>
                        Description:<br />
                        <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $itemi['desc']; ?></td></tr></table>
                    <?php
                }
            } else {
                if ($i['bodypart'] == "lhand")
                    $i['bodypart'] = "shield";

                $c = $sql[0]->query("SELECT `chest` FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
                if (SQL::numRows($c)) {
                    $chest_id = SQL::result($c);
                    $i['desc'] = SQL::result($sql[0]->query("SELECT `desc` FROM `all_items` WHERE `id`='$chest_id'"));
                    ?>
                        Description:<br />
                        <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc']; ?></td></tr></table>
                    <?php
                }
            }
            ?>
                Comment:<br />
                <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php textbbcode('item', 'comment', $item['comment']); ?></td></tr></table><input type="hidden" name="id" id="id" value="<?php echo $item['object_id']; ?>" />
            <?php echo button('Save Changes', 'submit', 1, false, 'submit'); ?>
            </form>
            <form action="?a=transfer" method="POST">
                <table><select name="char">
            <?php
            $serv = getDBInfo($item['server']);

            $sql[3]->query("SELECT `charId`, `char_name` FROM `{$serv['database']}`.`characters` WHERE `account_name`='{$_SESSION['account']}' AND `online`='0'");
            while ($char = SQL::fetchArray()) {
                echo '<option value="' . $char['charId'] . '">' . $char['char_name'] . '</option>';
            }
            ?>
                    </select>
                    <tr><td><input type="hidden" name="id" id="id" value="<?php echo $item['object_id']; ?>" />
                                <?php echo button('Send to Game', 'submit', 1, false, 'submit'); ?>
                            </form></td></tr></table>
            <?php
        }
        foot();
        break;
###############################################  Transfer Item   ##########################################
#################################################  View Item   ############################################
    case "view":
        $id = fInt(filter_input(INPUT_GET, 'id'));
        $q1 = $sql[0]->query('WEBSHOP_ITEM', array('id'=>$id));
        if (!SQL::numRows($qry)) {
            head();
            nsg('Error', 'Not found', 'error');
            foot();
            die();
        }
        $i = SQL::fetchArray($q1);
        $q2 = $sql[0]->query('ITEM_INFO', array('itemid'=>$i['itemId']));
        $ii = SQL::fetchArray();
        $addname = L2Web::formatAddName($ii['add_name']);
        if ($i['owner'] == '')
            $i['owner'] = 'No Owner';
        head("WebShop - View Item");
        echo $menu;
        ?>
            <table cellpadding="5" cellspacing="5" border="2" width="425px">
                <tr><td><img src="img/icons/<?php echo $ii['icon']; ?>.png" alt="<?php echo $ii['name']; ?>" title="<?php echo $ii['name']; ?>" width="64" height="64"/></td>
                    <td>
                        <table border="1" width="315px">
                            <tr><td>Name</td><td><?php echo $ii['name'] . $addname; ?></td></tr>
                            <tr><td>Type</td><td><?php echo $i['type']; ?></td></tr>
                            <tr><td>Body Part</td><td><?php echo $ii['bodypart']; ?></td></tr>
            <?php
            $grade =L2Web::getGrade($i['grade']);
            ?>
                            <tr><td>Grade</td><td><?php echo $grade; ?></td></tr>
        <?php
        if ($i['enchant_level'] != '' && $i['enchant_level'] > 0) {
            ?>
                                <tr><td>Enchant</td><td><?php echo $i['enchant_level']; ?></td></tr><?php
                    }
                    ?>
                            <tr><td>Elementals</td><td><table>
                    <?php
                    if ($i['elementals'] != '') {
                        $type = $i['type'];
                        $elearr = explode(";", $i['elementals']);
                        foreach ($elearr as $value) {
                            $ele = explode(",", $value);
                            if ($type == 'w') {
                                L2Web::drawWElement($ele[0], $ele[1]);
                            } else {
                                L2Web::drawAElement($ele[0], $ele[1]);
                            }
                        }
                    }
                    ?></table>
                                </td></tr>
            <?php
            if ($i['augment'] != '') {
                $aug = explode(',', $i['augment']);
                $auga[0] = $aug[0] % 65536;
                $auga[1] = floor($aug[0] / 65536);
                $sql[0]->query("SELECT `desc` FROM `optiondata` WHERE `id`='$auga[0]';");
                $aug1 = SQL::result();
                $sql[0]->query("SELECT `level`, `desc` FROM `optiondata` WHERE `id`='$auga[1]';");
                $aug2 = SQL::fetchArray();
                $color = augColor($aug2['level']);
                ?>
                                <tr><td>Augment</td><td><font color="<?php echo $color; ?>"><?php echo $aug1 . '<br />' . $aug2['desc']; ?></font></td></tr>
                <?php
            }
            ?>
                            <tr><td>Count</td><td><?php echo $i['count']; ?></td></tr>
                            <tr><td>Price<br /> per 1 item</td><td><?php echo $item['money_count']; ?> <?php echo ($i['money'] == 0) ? 'Adena' : 'WebPoints'; ?></td></tr>
                            <tr><td>Owner</td><td><?php echo $i['owner']; ?></td></tr>
                        </table>
                    </td></tr>
            </table>
            <br />
        <?php
        if ($ii['desc'] != "" || $ii['grade'] == "none") {
            if ($ii['desc'] != "") {
                ?>
                    Description:<br />
                    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $ii['desc']; ?></td></tr></table>
                                    <?php
                                }
                            } else {
                                if ($i['bodypart'] == "lhand")
                                    $i['bodypart'] = "shield";
                                $c = $sql[0]->query("SELECT `chest` FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
                                if (SQL::numRows($c)) {
                                    $chest_id = SQL::result($c);
                                    $i['desc'] = SQL::result($sql[0]->query("SELECT `desc` FROM `all_items` WHERE `id`='$chest_id'"));
                                    ?>
                    Description:<br />
                    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc']; ?></td></tr></table>
                                                <?php
                                            }
                                        }
                                        if ($item['comment'] != '') {
                                            ?>
                Comment:<br />
                <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo format_body($item['comment']); ?></td></tr></table>
                                            <?php
                                        }
                                        ?>
            <form action="?a=buy" method="post">
                <table><tr><td><input type="hidden" name="id" id="id" value="<?php echo $item['object_id']; ?>" />
                            Count: <input type="text" maxlength="3" id="itemcount" name="itemcount" size="3" title="Count" /><br />
                                        <?php echo button('Buy', 'submit', 1, false, 'submit'); ?>
                            </form></td></tr>
                </table>
                            <?php
                            foot();
                            break;
#################################################  View Item   ############################################
##################################################  Buy Item   ############################################
                        case "buy":
                            $id = getVar('id');
                            $count = getVar('itemcount');

                            $qry = $sql[0]->query("SELECT * FROM `webshop` WHERE `object_id`='$id' AND `active`='1'");
                            if (!SQL::numRows()) {
                                head();
                                msg('Error', 'Item not found', 'error');
                                foot();
                                die();
                            }

                            $item = SQL::fetchArray();
                            if ($_SESSION['account'] == $item['owner']) {
                                head();
                                msg('Error', 'You can\'t buy your items', 'error');
                                foot();
                                die();
                            }

                            $qry = $sql[0]->query("SELECT * FROM `all_items` WHERE id='{$item['item_id']}'");
                            $itemi = SQL::fetchArray();

                            if ($count > $item['count'])
                                $count = $item['count'];
                            $sum = $count * $item['money_count'];

                            if ($item['money'] == 0) { //adena
                                $qry = $sql[3]->query("SELECT `object_id`, SUM(`items`.`count`) AS adena FROM `$db`.`characters` , `items` WHERE `characters`.`charId` =  `items`.`owner_id` AND `items`.`item_id` = '57' AND `characters`.`account_name` = '{$_SESSION['account']}'");
                                //SELECT characters.charId, characters.char_name, items.object_id, items.`count`,items.loc FROM characters ,items WHERE characters.charId =  items.owner_id AND items.item_id = '57' AND characters.account_name =  '80mxm08'

                                $itema = SQL::fetchArray();
                                if ($itema['adena'] - $sum < 0 || $count > $item['count']) {
                                    if ($itema['adena'] - $sum < 0)
                                        err('Error', 'You don\'t have ' . $sum . ' Adena <br /> You have ' . $itema['adena'] . ' Adena in your account');
                                    else
                                        err('Error', 'Incorrect count');
                                }
                                else {
                                    $taked = 0;
                                    $left = $item['money_count'];
                                    $sql->query("SELECT `characters`.`charId`, `characters`.`char_name`, `items`.`object_id`, `items`.`count`,`items`.`loc` FROM `$db`.`characters` ,`$db`.`items` WHERE `characters`.`charId` =  `items`.`owner_id` AND `items`.`item_id` = '57' AND `characters`.`account_name` =  '{$_SESSION['account']}'");
                                    while ($adena = $sql->fetch_array()) {
                                        $cur = 0;
                                        if ($adena['count'] >= $left) {
                                            $cur = $left;
                                        } else {
                                            if ($adena['count'] == '0')
                                                continue;
                                            if ($left < $adena['count'])
                                                $cur = $left;
                                            else
                                                $cur = $adena['count'];
                                        }
                                        $left-=$cur;
                                        $sql->query("UPDATE `$db`.`items` SET `count` = `count`-'$cur' WHERE `object_id`='{$adena['object_id']}'");
                                        if ($left <= 0)
                                            break;
                                    }
                                    if ($count < $item['count']) {
                                        $object_id = getConfig('webshop', 'inc', '0') + 1;
                                        $sql->query("INSERT INTO `$webdb`.`webshop` (`owner`, `object_id`, `item_id`, `count`, `enchant_level`, `loc`, `active`, `elementals`, `augument`, `server`) VALUES ('{$_SESSION['account']}', '{$object_id}', '{$item['item_id']}', '{$count}', '{$item['enchant_level']}', 'WEBINV', '0', '{$item['elementals']}', '{$item['augument']}', '{$item['server']}')");
                                        setConfig('webshop', 'inc', $object_id);
                                        $sql->query("UPDATE `$webdb`.`webshop` SET `count`=`count`-'$count' WHERE `object_id`='{$item['object_id']}'");
                                        $object_id = getConfig('webshop', 'inc', '0') + 1;
                                        $sql->query("INSERT INTO `$webdb`.`webshop` (`owner`, `object_id`, `item_id`, `count`, `loc`, `active`, `server`) VALUES ('{$item['owner']}', '{$object_id}', '57', '{$sum}', 'WEBINV', '0', '{$item['server']}')");
                                        setConfig('webshop', 'inc', $object_id);
                                    } else {
                                        $object_id = getConfig('webshop', 'inc', '0') + 1;
                                        $sql->query("UPDATE `$webdb`.`webshop` SET `owner`='{$_SESSION['account']}', `active`='0' WHERE `object_id`='{$item['object_id']}'");
                                        setConfig('webshop', 'inc', $object_id);
                                        $sql->query("INSERT INTO `$webdb`.`webshop` (`owner`, `object_id`, `item_id`, `count`, `loc`, `active`) VALUES ('{$item['owner']}', '{$object_id}', '57', '$count', 'WEBINV', '0')");
                                    }
                                    $body = "You have bought [url=item.php?id={$item['item_id']}][img]img/icons/{$itemi['icon1']}.png[/img][/url][hr][url=webshop.php?a=viewbought&id=$object_id]View Your Item[/url]|[url=webshop.php]Buy Another[/url]";
                                    $sql->query("INSERT INTO `$webdb`.`messages` (`receiver`, `added`, `subject`, `msg`) VALUES ('{$_SESSION['account']}', NOW(), 'Webshop Item Buy', '$body')");
                                    $body = "Your item [url=item.php?id={$item['item_id']}][img]img/icons/{$itemi['icon1']}.png[/img][/url] has been bought[hr]|[url=webshop.php?a=add]Add Another[/url]";
                                    $sql->query("INSERT INTO `$webdb`.`messages` (`receiver`, `added`, `subject`, `msg`) VALUES ('{$item['owner']}', NOW(), 'Webshop Item Sell', '$body')");

                                    head("WebShop - Buy Item");
                                    echo $menu;
                                    msg('Success', 'You have successfully bought item');
                                    foot();
                                }
                            } else { //webpoints
                                if ($_SESSION['webpoints'] - $sum < 0) {
                                    err('Error', 'You don\'t have ' . $sum . ' webpoints <br /> You have ' . $_SESSION['webpoints'] . ' webpoints');
                                } else {
                                    $sql->query("UPDATE `accounts` SET `webpoints`=`webpoints`-'$sum' WHERE `login`='{$_SESSION['account']}'");
                                    $_SESSION['webpoints']-=$sum;
                                    $sql->query("UPDATE `accounts` SET `webpoints`=`webpoints`+'$sum' WHERE `login`='{$item['owner']}'");
                                    if ($count < $item['count']) {
                                        $object_id = getConfig('webshop', 'inc', '0') + 1;
                                        $sql->query("INSERT INTO `l2web`.`webshop` (`owner`, `object_id`, `item_id`, `count`, `enchant_level`, `loc`, `active`, `elementals`, `augument`) VALUES ('{$_SESSION['account']}', '$object_id', '{$item['item_id']}', '$count', '{$item['enchant_level']}', 'WEBINV', '0', '{$item['elementals']}', '{$item['augument']}')");
                                        setConfig('webshop', 'inc', $object_id);
                                        $sql->query("UPDATE `l2web`.`webshop` SET `count`=`count`-'$count' WHERE `object_id`='{$item['object_id']}'");
                                    } else {
                                        $sql->query("UPDATE `$webdb`.`webshop` SET `owner`='{$_SESSION['account']}', `active`='0' WHERE `object_id`='{$item['object_id']}'");
                                    }
                                    $body = "You have bought [url=item.php?id={$item['item_id']}][img]img/icons/{$itemi['icon1']}.png[/img][/url][hr][url=webshop.php?a=viewbought&id=$object_id]View Your Item[/url]|[url=webshop.php]Buy Another[/url]";
                                    $sql->query("INSERT INTO `$webdb`.`messages` (`receiver`, `added`, `subject`, `msg`) VALUES ('{$_SESSION['account']}', NOW(), 'Webshop Item Buy', '$body')");
                                    $body = "Your item [url=item.php?id={$item['item_id']}][img]img/icons/{$itemi['icon1']}.png[/img][/url] has been bought[hr]|[url=webshop.php?a=add]Add Another[/url]";
                                    $sql->query("INSERT INTO `$webdb`.`messages` (`receiver`, `added`, `subject`, `msg`) VALUES ('{$item['owner']}', NOW(), 'Webshop Item Sell', '$body')");
                                    head("WebShop - Buy Item");
                                    echo $menu;
                                    msg('Success', 'You have successfully bought item');
                                    foot();
                                }
                            }
                            break;
##################################################  Buy Item   ############################################
#################################################   Edit Item   ###########################################
                        case "edit":
                            $item_id = getVar('id');
                            $active = getVar('active');
                            $moneyc = getVar('moneyc');
                            $money = getVar('money');
                            $comment = getVar('comment');
                            $sql->query("SELECT * FROM `$webdb`.`webshop` WHERE `object_id`='$item_id' AND `owner`='{$_SESSION['account']}'");
                            if (!$sql->num_rows()) {
                                err('Error', 'Item not found');
                            }
                            if ($moneyc <= 0 || $moneyc == '') {
                                err('Error', 'Invalid money count');
                            }
                            if ($money < 0 || $money > 1) {
                                err('Error', 'Invalid money type');
                            }
                            $active = $active == true ? '1' : '0';
                            $sql->query("UPDATE `$webdb`.`webshop` SET `active`='$active', `money`='$money', `money_count`='$moneyc', `comment`='$comment' WHERE `object_id`='$item_id' AND `owner`='{$_SESSION['account']}'");
                            //$item=$sql->fetch_array();
                            if ($sql->row_count) {
                                suc('Success', 'Item has been edited successfully');
                            } else {
                                err('Error', 'Failed to edit item');
                            }
                            break;
#################################################   Edit Item   ###########################################
###############################################  View All items   #########################################
                        default:
                            head("WebShop");
                            echo $menu;
                            $type = fInt(filter_input(INPUT_GET, 'type'));
                            $grade = fInt(filter_input(INPUT_GET, 'grade'));
                            ?>
                <form action="" method="post">
                    <table><tr><td>Name</td><td>Type</td><td>Grade</td><td></td></tr>
                        <tr><td><input type="text" id="s" name="s" value="<?php echo fInt(filter_input(INPUT_GET, 's')); ?>" /></td>
                            <td>
                                <select id="type" name="type">
                                    <option value="" <?php echo ($type == '') ? 'selected="selected"' : ''; ?>>All</option>
                                    <option value="armor" <?php echo ($type == 'armor') ? 'selected="selected"' : ''; ?>>Armor</option>
                                    <option value="weapon" <?php echo ($type == 'weapon') ? 'selected="selected"' : ''; ?>>Weapon</option>
                                    <option value="potion" <?php echo ($type == 'potion') ? 'selected="selected"' : ''; ?>>Potion</option>
                                    <option value="scroll" <?php echo ($type == 'scroll') ? 'selected="selected"' : ''; ?>>Scroll</option>
                                </select></td><td>
                                <select id="grade" name="grade">
                                    <option value="" <?php echo ($grade == '') ? 'selected="selected"' : ''; ?>>All</option>
                                    <option value="no" <?php echo ($grade == 'no') ? 'selected="selected"' : ''; ?>>No Grade</option>
                                    <option value="d" <?php echo ($grade == "d") ? ' selected="selected"' : ''; ?>>D-Grade</option>
                                    <option value="c" <?php echo ($grade == 'c') ? 'selected="selected"' : ''; ?>>C-Grade</option>
                                    <option value="b" <?php echo ($grade == 'b') ? 'selected="selected"' : ''; ?>>B-Grade</option>
                                    <option value="a" <?php echo ($grade == 'a') ? 'selected="selected"' : ''; ?>>A-Grade</option>
                                    <option value="s" <?php echo ($grade == 's') ? 'selected="selected"' : ''; ?>>S-Grade</option>
                                    <option value="s80" <?php echo ($grade == 's80') ? 'selected="selected"' : ''; ?>>S80-Grade</option>
                                    <option value="s84" <?php echo ($grade == 's84') ? 'selected="selected"' : ''; ?>>S84-Grade</option>
                                </select></td>
                            <td>
                                <input type="submit" value="Submit" />
                            </td>
                        </tr></table></form>
                <?php
                echo "<table border=\"1\">";
                echo "<tr><th>Item</th><th>Price</th><th>Count</th><th>Owner</th></tr>";
                $r = $sql[0]->query("SELECT * FROM `webshop` WHERE `active`='1' AND `server`='{$server['id']}' AND `type` LIKE '%$type%' AND `grade` LIKE '%$grade%' LIMIT $startlimit, " . Config::get('settings', 'TOP') . ";");
                
                while ($ws = SQL::fetchArray($r)) {
                    $qry = $sql[0]->query('ITEM_INFO', array("itemid" => $ws['item_id']));
                    $i = SQL::fetchArray($qry);
                    $name = $i['name'];
                    $addname = L2Web::formatAddName($i['add_name']);
                    $icon=$i['icon'];
                    $price = ($ws['money'] == "0") ? " Adena" : " WebPoints";
                    $enc = L2Web::getEnchant($ws['enchant_level']);
                    echo '<tr><td><a href="actions.php?a=item_data&id=' . $ws['object_id'] . '&server=ws" class="item_info"><img border="0" src="img/icons/' . $icon . '.png" alt="' . $name . '" title="' . $enc . $name . $addname . '" /></a></td>';
                    echo '<td>'.$ws['m_count'].' '.$price.'</td>';
                    echo '<td>'.$ws['count'].'</td>';
                    echo '<td>'.$ws['owner'].'</td></tr>';
    }
                echo "</table>";
                $count = $sql[0]->result($sql[0]->query("SELECT Count(*) FROM `webshop` WHERE `active`='1' AND `server`='{$server['id']}' AND `type` LIKE '%$type%' AND `grade` LIKE '%$grade%';"));
                $link = "";
                if ($grade != '')
                    $link.="?grade=$grade";
                if ($type != '') {
                    if ($link == '') {
                        $link = "?";
                    } else {
                        $link.="&amp;";
                    }
                    $link.="type=$type";
                }
                echo page($page, $count, $link, $serverId);
                foot();
                break;
        }
        ?>