<?php

define('L2WEB', true);
require_once ("include/core.php");
if (User::getAccess() < Access::ADMIN6) {
    die();
}

function getAlignName($a) {
    global $Lang;
    switch ($a) {
        case 'l':
            return $Lang['lLeft'];
        case 't':
            return $Lang['lTop'];
        case 'c':
            return $Lang['lCenter'];
        case 'b':
            return $Lang['lBottom'];
        case 'r':
            return $Lang['lRight'];
        default:
            return $Lang['lUnknown_pos'];
    }
}

function getAccessName($a) {
    global $Lang;
    switch ($a) {
        case Access::GUEST:
            return $Lang['lGuests_up'];
        case Access::USER:
            return $Lang['lUsers_up'];
        case Access::MOD:
            return $Lang['lMods_up'];
        case Access::ADMIN:
        case Access::ADMIN1:
        case Access::ADMIN2:
        case Access::ADMIN3:
        case Access::ADMIN4:
        case Access::ADMIN5:
        case Access::ADMIN6:
            return $Lang['lAdmins'];
    }
}

function getLangKey($v) {
    global $Lang;
    foreach ($Lang as $key => $value) {
        if ($value == $v) {
            return $key;
        }
    }
    return $v;
}


function BlocksAdmin() {
    global $Lang, $sql;

    echo "<table border=\"1\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\"><tr align=\"center\">"
    . "<td class=\"colhead\">№</td><td class=\"colhead\">Virsraksts</td><td class=\"colhead\">Vieta</td><td colspan=\"1\" class=\"colhead\">Novietojums</td><td class=\"colhead\">Tips</td><td class=\"colhead\">Status</td><td class=\"colhead\">Kas redz</td><td class=\"colhead\">Darbības</td></tr>";

    foreach ($sql['core']->query('GET_BLOCKS') as $r) {
        $title = isset($Lang[$r['title']]) ? $Lang[$r['title']] : $r['title'];
        echo "<tr><td align=\"center\">{$r['id']}</td><td>{$title}</td>";

        echo "<td align=\"center\"><nobr>" . getAlignName($r['align']) . "</nobr></td><td>";
        if (true) {
            echo "<a href=\"?op=BlocksOrder&bidori={$r['id']}\"><img src=\"img/up.gif\" alt=\"Move Up\" title=\"Move Up\" border=\"0\"></a> ";
        }
        if (true) {
            echo "<a href=\"?op=BlocksOrder&bidori={$r['id']}\"><img src=\"img/down.gif\" alt=\"Move Down\" title=\"Move Down\" border=\"0\"></a>";
        }
        echo"</td>";
        if ($r['file'] == "") {
            $type = "HTML";
        } else {
            $type = "file";
        }
        echo "<td align=\"center\">$type</td>";
        if ($r['active'] == 1) {
            $active = "<font color=\"#009900\">On</font>";
            $change = "title=\"Turn Off\"><img src=\"img/inactive.gif\" border=\"0\" alt=\"Turn Off\"></a>";
        } else {
            $active = "<font color=\"#FF0000\">Off</font>";
            $change = "title=\"Turn On\"><img src=\"img/activate.gif\" border=\"0\" alt=\"Turn On\"></a>";
        }
        echo "<td align=\"center\">$active</td>";
        echo "<td align=\"center\">" . getAccessName($r['access']) . "</td>";
        echo "<td align=\"center\"><a href=\"?op=BlocksEdit&id={$r['id']}\" title=\"Labot\"><img src=\"img/edit.png\" border=\"0\" alt=\"Labot\"></a> ";
        echo " <a href=\"?op=BlocksDelete&id={$r['id']}\" title=\"Dzēst\"><img src=\"img/delete.png\" border=\"0\" alt=\"Dzēst\"></a>  <a href=\"?op=BlocksChange&id={$r['id']}\" $change</td></tr>";
    }
    echo '</table>';
}

function BlocksNew() {
    global $sql, $Lang;
    echo "<h2>Add new Blocks</h2>"
    . "<form action=\"\" method=\"post\">"
    . "<table border=\"0\" align=\"center\">"
    . "<tr><td>Title:</td><td><input type=\"text\" name=\"title\" size=\"65\" style=\"width:400px\" maxlength=\"60\"></td></tr>"
    . "<tr><td>File:</td><td>"
    . "<select name=\"file\" style=\"width:400px\">"
    . "<option name=\"file\" value=\"\" selected>None</option>";
    $handle = opendir("blocks");
    while ($file = readdir($handle)) {
        if (preg_match("/.php/", $file)) {
            echo "<option value=\"$file\">$file</option>\n";
        }
    }
    closedir($handle);
    echo "</select></td></tr>"
    . "<tr><td>Content:</td><td><textarea name=\"content\" cols=\"65\" rows=\"15\" style=\"width:400px\"></textarea></td></tr>"
    . "<tr><td>Position:</td><td><select name=\"align\" style=\"width:400px\">"
    . "<option value=\"l\">Left</option>"
    . "<option value=\"t\">Top</option>"
    . "<option value=\"c\">Center</option>"
    . "<option value=\"b\">Bottom</option>"
    . "<option value=\"r\">Right</option>"
    . "</select></td></tr>";

    echo "<tr><td>Active</td><td><input type=\"radio\" name=\"active\" value=\"1\" checked>Yes &nbsp;&nbsp; <input type=\"radio\" name=\"active\" value=\"0\">No</td></tr>"
    . "<tr><td>Frame</td><td><input type=\"radio\" name=\"frame\" value=\"1\" checked>Yes &nbsp;&nbsp; <input type=\"radio\" name=\"frame\" value=\"0\">No</td></tr>"
    . "<tr><td>Access</td><td><select name=\"access\" style=\"width:400px\">"
    . "<option value=\"-1\" >Guests and Up</option>"
    . "<option value=\"0\" >Users and Up</option>"
    . "<option value=\"1\" >Mods and Up</option>"
    . "<option value=\"2\" >Admins</option>"
    . "</select></td></tr>"
    . "<tr><td colspan=\"2\" align=\"center\"><br /><input type=\"hidden\" name=\"op\" value=\"BlocksAdd\"><input type=\"submit\" value=\"Add Block\"></td></tr></table></form>";
}

function BlocksFile() {
    global $admin_file;
    echo "<h2>Pievienot jaunu faila bloku</h2>"
    . "<form action=\"" . $admin_file . ".php\" method=\"post\">"
    . "<table border=\"0\" align=\"center\">"
    . "<tr><td>Fails:</td><td><input type=\"text\" name=\"bf\" size=\"65\" style=\"width:400px\" maxlength=\"200\">"
    . "<tr><td>Tips:</td><td><input type=\"radio\" name=\"flag\" value=\"php\" checked>PHP &nbsp;&nbsp; <input type=\"radio\" name=\"flag\" value=\"html\">HTML</td></tr>"
    . "<tr><td colspan=\"2\" align=\"center\"><br /><input type=\"hidden\" name=\"op\" value=\"BlocksbfEdit\">"
    . "<input type=\"submit\" value=\"Izveidot bloku\"></td></tr></table></form>";
}

function BlocksOrder($weightrep, $weight, $bidrep, $bidori) {
    global $prefix, $admin_file;
    $result = sql_query("UPDATE " . $prefix . "_blocks SET weight='$weight' WHERE bid='$bidrep'");
    $result2 = sql_query("UPDATE " . $prefix . "_blocks SET weight='$weightrep' WHERE bid='$bidori'");
    Header("Location: " . $admin_file . ".php?op=BlocksAdmin");
}

function BlocksAdd() {
    global $sql, $Lang;

    $title = filter_input(INPUT_POST, 'title');
    $file = str_replace(".php", "", filter_input(INPUT_POST, 'file'));
    $content = filter_input(INPUT_POST, 'content');
    $align = filter_input(INPUT_POST, 'align');
    $active = filter_input(INPUT_POST, 'active', FILTER_VALIDATE_BOOLEAN);
    $frame = filter_input(INPUT_POST, 'frame', FILTER_VALIDATE_BOOLEAN);
    $access = filter_input(INPUT_POST, 'access');
    $next = $sql['core']->result($sql['core']->query("SELECT max(position)+1 as next FROM blocks WHERE align='$align'"));

    if ($file != "" && $title == "") {
        $title = getLangKey($file);
    } else {
        $title = getLangKey($title);
    }

    if (($content == "") && ($file == "")) {
        msg($Lang['lError'], $Lang['lEmpty_block']);
    } else {

        $sql['core']->query("INSERT INTO `blocks` (`title`, `align`, `position`, `frame`, `content`, `active`, `access`, `file`) VALUES ('$title', '$align', '$next', '$frame', '$content', '$active', '$access', '$file')");
        echo msg($Lang['lDone'], '<a href="?op=BlocksAdmin">' . $Lang['lGo_back'] . '</a>');
    }
}

function BlocksEdit() {
    global $Lang, $sql;
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $r = $sql['core']->fetchArray($sql['core']->query("SELECT * FROM blocks WHERE id='$id';"));
    var_dump($r);
    if ($r['file'] != "") {
        $type = "(faila bloks)";
    } else {
        $type = "(HTML bloks)";
    }
    $title = isset($Lang[$r['title']]) ? $Lang[$r['title']] : $r['title'];
    echo "<h2>Bloks: $title $type</h2>"
    . "<form action=\"?op=BlocksEditSave&id=$id\" method=\"post\">"
    . "<table border=\"0\" align=\"center\">"
    . "<tr><td>Nosaukums:</td><td><input type=\"text\" name=\"title\" maxlength=\"50\" size=\"65\" style=\"width:400px\" value=\"$title\"></td></tr>";
    if ($r['file'] != "") {
        echo "<tr><td>Fails:</td><td><select name=\"blockfile\" style=\"width:400px\">";
        $dir = opendir("blocks");
        while ($file = readdir($dir)) {
            if ($file != '.' && $file != '..') {
                if (preg_match("/.php/", $file)) {

                    $selected = ($r['file'] . '.php' == $file) ? "selected" : "";
                    echo "<option value=\"$file\" $selected>" . $file . "</option>";
                }
            }
        }
        closedir($dir);
    } else {
        echo "<tr><td>Saturs:</td><td><textarea name=\"content\" cols=\"65\" rows=\"15\" style=\"width:400px\">{$r['content']}</textarea></td></tr>";
    }


    $sel1 = ($r['align'] == "l") ? "selected" : "";
    $sel2 = ($r['align'] == "t") ? "selected" : "";
    $sel3 = ($r['align'] == "c") ? "selected" : "";
    $sel4 = ($r['align'] == "b") ? "selected" : "";
    $sel5 = ($r['align'] == "r") ? "selected" : "";
    echo "<tr><td>Position:</td><td><select name=\"align\" style=\"width:400px\">"
    . "<option value=\"l\" $sel1>Left</option>"
    . "<option value=\"t\" $sel2>Top</option>"
    . "<option value=\"c\" $sel4>Center</option>"
    . "<option value=\"b\" $sel3>Bottom</option>"
    . "<option value=\"r\" $sel5>Right</option>"
    . "</select></td></tr>";

    $sel1 = ($r['active'] == 1) ? "checked" : "";
    $sel2 = ($r['active'] == 0) ? "checked" : "";

    echo "<tr><td>Active</td><td><input type=\"radio\" name=\"active\" value=\"1\" $sel1>Yes &nbsp;&nbsp;"
    . "<input type=\"radio\" name=\"active\" value=\"0\" $sel2>No</td></tr>";
    $sel1 = ($r['frame'] == 1) ? "checked" : "";
    $sel2 = ($r['frame'] == 0) ? "checked" : "";

    echo "<tr><td>Frame</td><td><input type=\"radio\" name=\"frame\" value=\"1\" $sel1>Yes &nbsp;&nbsp;"
    . "<input type=\"radio\" name=\"frame\" value=\"0\" $sel2>No</td></tr>";
    $sel1 = ($r['access'] == -1) ? "selected" : "";
    $sel2 = ($r['access'] == 0) ? "selected" : "";
    $sel3 = ($r['access'] == 1) ? "selected" : "";
    $sel4 = ($r['access'] >= 2) ? "selected" : "";
    echo "</td></tr><tr><td>Access</td><td><select name=\"access\" style=\"width:400px\">"
    . "<option value=\"-1\" $sel1>Guests</option>"
    . "<option value=\"0\" $sel2>Users</option>"
    . "<option value=\"1\" $sel3>Moderators</option>"
    . "<option value=\"2\" $sel4>Admins</option>"
    . "</select></td></tr></table><br>"
    . "<center>"
    . "<input type=\"submit\" value=\"Save\"></form></center>";
}

function BlocksEditSave() {
    global $sql, $Lang;
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title');
    $file = filter_input(INPUT_POST, 'blockfile');
    $content = filter_input(INPUT_POST, 'content');
    $align = filter_input(INPUT_POST, 'align');
    $active = filter_input(INPUT_POST, 'active', FILTER_VALIDATE_BOOLEAN);
    $frame = filter_input(INPUT_POST, 'frame', FILTER_VALIDATE_BOOLEAN);
    $access = filter_input(INPUT_POST, 'access');
    $titleK = getLangKey($title);
    $sql['core']->query("UPDATE blocks SET title='$titleK', file='$file', content='$content', align='$align', access='$access', active='$active', frame='$frame' WHERE id='$id';");
    echo msg($Lang['lDone'], '<a href="?op=BlocksAdmin">' . $Lang['lGo_back'] . '</a>');
}

function BlocksFileEdit() {
    global $prefix, $admin_file;
    echo "<h2>Labot bloku</h2>"
    . "<form action=\"" . $admin_file . ".php\" method=\"post\">"
    . "<table border=\"0\" align=\"center\">"
    . "<tr><td>Faila nosaukums:</td><td>"
    . "<select name=\"bf\" style=\"width:400px\">";
    $handle = opendir("blocks");
    while ($file = readdir($handle)) {
        if (preg_match("/^block\-(.+)\.php/", $file, $matches)) {
            $found = str_replace("-", " ", $matches[1]);
            if (mysql_num_rows(sql_query("SELECT * FROM " . $prefix . "_blocks WHERE blockfile='$file'")) > 0)
                echo "<option value=\"$file\">$found</option>\n";
        }
    }
    closedir($handle);
    echo "</select></td></tr>"
    . "<tr><td colspan=\"2\" align=\"center\"><input type=\"hidden\" name=\"op\" value=\"BlocksbfEdit\"><input type=\"submit\" value=\"Labot bloku\"></td></tr></table></form>";
}

function BlocksChange() {
    global $sql;
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $r = $sql['core']->fetchArray($sql['core']->query("SELECT * FROM blocks WHERE id='$id'"));
    if (isset($_GET['confirm'])) {
        $active = ($r['active'] == '0') ? '1' : '0';
        $sql['core']->query("UPDATE blocks SET active='$active' WHERE id='$id'");
        echo msg('Done', '<a href="?op=BlocksAdmin">Go Back</a>');
    } else {
        if ($r['active'] == '0') {
            echo "<center>Aktivizēt bloku \"{$r['title']}\"?<br /><br />";
        } else {
            echo "<center>Deaktivizēt bloku \"{$r['title']}\"?<br /><br />";
        }
        echo "[ <a href=\"?op=BlocksChange&id=$id&confirm\">Jā</a> | <a href=\"?op=BlocksAdmin\">Nē</a> ]</center>";
    }
}

function BlocksbfEdit() {
    global $prefix, $db, $admin_file;
    if ($_REQUEST['bf'] != "") {
        $bf = $_REQUEST['bf'];
        if (isset($_POST['flag'])) {
            $flaged = $_POST['flag'];
            $bf = str_replace("block-", "", $bf);
            $bf = str_replace(".php", "", $bf);
            $bf = 'block-' . $bf . '.php';
        } else {
            $bfstr = file_get_contents('blocks/' . $bf);
            if (strpos($bfstr, 'BLOCKHTML') === false) {
                $flaged = 'php';
                preg_match("/<\?php.*if.*\(\!defined\(\'BLOCK_FILE\'\)\).*exit;.*?}(.*)\?>/is", $bfstr, $out);
                unset($out[0]);
            } else {
                $flaged = 'html';
                preg_match("/<<<BLOCKHTML(.*)BLOCKHTML;/is", $bfstr, $out);
                unset($out[0]);
            }
        }
        $permtest = end_chmod("blocks", 777);
        if ($permtest)
            stdmsg("Kļūme", $permtest, 'error');
        echo "<h2>Bloks: $bf</h2>"
        . "<form action=\"" . $admin_file . ".php\" method=\"post\">"
        . "<table border=\"0\" align=\"center\">"
        . "<tr><td>Saturs:</td><td><textarea wrap=\"virtual\" name=\"blocktext\" cols=\"65\" rows=\"25\" style=\"width:400px\">" . $out[1] . "</textarea></td></tr>"
        . "<tr><td colspan=\"2\" align=\"center\"><br /><input type=\"hidden\" name=\"bf\" value=\"" . $bf . "\">"
        . "<input type=\"hidden\" name=\"flag\" value=\"" . $flaged . "\">"
        . "<input type=\"hidden\" name=\"op\" value=\"BlocksbfSave\">"
        . "<input type=\"submit\" value=\"Saglabāt\"> <input type=\"button\" value=\"Atpakaļ\" onClick=\"javascript:history.go(-1)\"></td></tr></table></form>";
    } else {
        Header("Location: " . $admin_file . ".php?op=BlocksFile");
    }
}

function BlocksbfSave() {
    global $prefix, $db, $admin_file;
    if (isset($_POST['blocktext'])) {
        if (!empty($_POST['blocktext'])) {
            if (isset($_POST['bf'])) {
                $bf = $_POST['bf'];
                if ($handle = fopen('blocks/' . $bf, 'w')) {
                    $htmlB = "";
                    $htmlE = "";
                    if (isset($_POST['flag'])) {
                        $flaged = $_POST['flag'];
                        if ($flaged == 'html') {
                            $htmlB = "\$content=<<<BLOCKHTML\n";
                            $htmlE = "\nBLOCKHTML;\n";
                        }
                    }
                    $str_set = $_POST['blocktext'];
                    fwrite($handle, "<?php\n\nif (!defined('BLOCK_FILE')) {\nheader(\"Location: ../index.php\");\nexit;\n}\n\n" . $htmlB . $str_set . $htmlE . "\r\n?>");
                    Header("Location: " . $admin_file . ".php?op=BlocksAdmin");
                }
                fclose($handle);
            }
        }
    }
}

function BlocksDelete() {
    global $Lang, $sql;
    $id = getInt('id');
    $r = $sql['core']->fetchArray($sql['core']->query("SELECT align, position FROM blocks WHERE id='$id';"));
    if (!$sql['core']->numRows()) {
        echo msg($Lang['lError'], $Lang['lInvalid_id'], 'error');
    }
    $r2 = $sql['core']->query("SELECT id FROM blocks WHERE position>'{$r['position']}' AND align='{$r['align']}';");
    while ($r3 = $sql['core']->fetchArray($r2)) {
        $sql->query("UPDATE blocks SET position='{$r['position']}' WHERE id='{$r3['id']}';");
        $r['position'] ++;
    }
    $sql['core']->query("DELETE FROM blocks WHERE id='$id'");
    echo msg($Lang['lDone'], '<a href="?op=BlocksAdmin">' . $Lang['lGo_back'] . '</a>');
}

head();

echo "<h2>Block Management</h2><br />"
    . "[ <a href=\"?op=BlocksAdmin\">Main</a>"
    . " | <a href=\"?op=BlocksNew\">Add new Block</a>"
    . " | <a href=\"?op=BlocksFile\">Add new File</a>"
    . " | <a href=\"?op=BlocksFileEdit\">Edit File</a> ]";
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
switch ($op) {
    case "BlocksAdmin":
    default:
        BlocksAdmin();
        break;

    case "BlocksNew":
        BlocksNew();
        break;

    case "BlocksFile":
        BlocksFile();
        break;

    case "BlocksFileEdit":
        BlocksFileEdit();
        break;

    case "BlocksAdd":
        BlocksAdd();
        break;

    case "BlocksEdit":
        BlocksEdit();
        break;

    case "BlocksEditSave":
        BlocksEditSave();
        BlocksEdit();
        break;

    case "BlocksChange":
        BlocksChange();
        break;

    case "BlocksDelete":
        BlocksDelete();
        break;

    case "BlocksOrder":
        BlocksOrder();
        break;

    case "BlocksbfEdit":
        BlocksbfEdit();
        break;

    case "BlocksbfSave":
        BlocksbfSave();
        break;
}
foot();

