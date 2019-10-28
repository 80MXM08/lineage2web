<?php

$DB = array(
    "host" => "localhost", //MySQL Host
    "user" => "root", //MySQL User
    "password" => "", //MySQL Password
);

$webdb = 'ertheia';

ini_set('max_execution_time', '7200');
mysql_connect($DB['host'], $DB['user'], $DB['password']);
mysql_select_db($webdb);

$a = filter_input(INPUT_GET, 'a');
switch ($a) {
        case "optiondata":
        $query = mysql_query("SELECT * FROM `optiondata`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query)) {

            $s=array("\\\\","\\\\n", "\\n");
            $re=array("\\"," "," ");
            $desc="";
            $desc1 = mysql_real_escape_string(substr($r['effect1_desc'], 2, strlen($r['effect1_desc']) - 4));

            $desc2 = mysql_real_escape_string(substr($r['effect2_desc'], 2, strlen($r['effect2_desc']) - 4));

            $desc3 = mysql_real_escape_string(substr($r['effect3_desc'], 2, strlen($r['effect3_desc']) - 4));
            if ($desc1 != "") {
                $desc.=$desc1;
            }
            if ($desc2 != "") {
                $desc.="<br />".$desc2;
            }
            if ($desc3 != "") {
                $desc.="<br />".$desc3;
            }
            
            $desc=trim(str_replace($s, $re, $desc));
            $desc=preg_replace('!\s+!', ' ', $desc);
            mysql_query("UPDATE `optiondata` SET `desc`='$desc' WHERE `id`='{$r['id']}';") OR die(mysql_error());
        }
        mysql_query("ALTER TABLE `optiondata`
DROP COLUMN `effect1_desc`,
DROP COLUMN `effect2_desc`,
DROP COLUMN `effect3_desc`;
");
//header("Location: ");
        echo "done";
        break;
case "itemname":
        $query = mysql_query("SELECT * FROM `itemname`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query)) {

            $s=array("\\\\","\\\\n1","\\\\n", "\\n1","\\n");
            $re=array("\\"," "," "," ", " ");
            if($r['add_name']=="a,")
            {
                $add_name="";
            }
            else {
            $add_name = mysql_real_escape_string(substr($r['add_name'], 2, strlen($r['add_name']) - 4));
            $add_name=preg_replace('!\s+!', ' ', $add_name);
            }
            if($r['desc']=="a,")
            {
                $desc="";
            }
            else {
            $desc = mysql_real_escape_string(substr($r['desc'], 2, strlen($r['desc']) - 4));
            $desc=trim(str_replace($s, $re, $desc));
            $desc=preg_replace('!\s+!', ' ', $desc);
            }
            
            mysql_query("UPDATE `itemname` SET `add_name`='$add_name', `desc`='$desc' WHERE `id`='{$r['id']}';") OR die(mysql_error());
        }
//header("Location: ");
        echo "done";
        break;
        
        
        case "setitemgrp":
            $query = mysql_query("SELECT * FROM `setitemgrp`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query)) {

            //$s=array("\\\\","\\\\n1","\\\\n", "\\n1","\\n");
            //$re=array("\\"," "," "," ", " ");
            $part1="";
            if($r['a0']!="")
            {
                $part1.=':'.$r['a0'].':';
            }
            if($r['a1']!="")
            {
                $part1.=':'.$r['a1'].':';
            }
            if($r['a2']!="")
            {
                $part1.=':'.$r['a2'].':';
            }
            if($r['a3']!="")
            {
                $part1.=':'.$r['a3'].':';
            }
            if($r['a4']!="")
            {
                $part1.=':'.$r['a4'].':';
            }
            
            $part2="";
            if($r['p0']!="")
            {
                $part2.=':'.$r['p0'].':';
            }
            if($r['p1']!="")
            {
                $part2.=':'.$r['p1'].':';
            }
            if($r['p2']!="")
            {
                $part2.=':'.$r['p2'].':';
            }
            if($r['p3']!="")
            {
                $part2.=':'.$r['p3'].':';
            }
            if($r['p4']!="")
            {
                $part2.=':'.$r['p4'].':';
            }
            
            $part3="";
            if($r['g0']!="")
            {
                $part3.=':'.$r['g0'].':';
            }
            if($r['g1']!="")
            {
                $part3.=':'.$r['g1'].':';
            }
            if($r['g2']!="")
            {
                $part3.=':'.$r['g2'].':';
            }
            if($r['g3']!="")
            {
                $part3.=':'.$r['g3'].':';
            }
            if($r['g4']!="")
            {
                $part3.=':'.$r['g4'].':';
            }
            
            $part4="";
            if($r['b0']!="")
            {
                $part4.=':'.$r['b0'].':';
            }
            if($r['b1']!="")
            {
                $part4.=':'.$r['b1'].':';
            }
            if($r['b2']!="")
            {
                $part4.=':'.$r['b2'].':';
            }
            if($r['b3']!="")
            {
                $part4.=':'.$r['b3'].':';
            }
            if($r['b4']!="")
            {
                $part4.=':'.$r['b4'].':';
            }
            
            $part5="";
            if($r['h0']!="")
            {
                $part5.=':'.$r['h0'].':';
            }
            if($r['h1']!="")
            {
                $part5.=':'.$r['h1'].':';
            }
            if($r['h2']!="")
            {
                $part5.=':'.$r['h2'].':';
            }
            if($r['h3']!="")
            {
                $part5.=':'.$r['h3'].':';
            }
            if($r['h4']!="")
            {
                $part5.=':'.$r['h4'].':';
            }
            $desc0=$r['set_bonus_desc[0]'];
            if($desc0=='a,No set effect\0')
            {
                $desc0='';
            }
            else
            {
                $desc0=mysql_real_escape_string(substr($desc0, 2, strlen($desc0) - 4));
            }
            $desc1=$r['set_bonus_desc[1]'];
            if($desc1=='a,No set effect\0')
            {
                $desc1='';
            }
            else
            {
                $desc1=mysql_real_escape_string(substr($desc1, 2, strlen($desc1) - 4));
            }
            $desc2=$r['set_bonus_desc[2]'];
            if($desc2=='a,No set effect\0')
            {
                $desc2='';
            }
            else
            {
                $desc2=mysql_real_escape_string(substr($desc2, 2, strlen($desc2) - 4));
            }
            $desc3=$r['set_bonus_desc[3]'];
            if($desc3=='a,No set effect\0')
            {
                $desc3='';
            }
            else
            {
                $desc3=mysql_real_escape_string(substr($desc3, 2, strlen($desc3) - 4));
            }
            $desc4=$r['set_bonus_desc[4]'];
            if($desc4=='a,No set effect\0')
            {
                $desc4='';
            }
            else
            {
                $desc4=mysql_real_escape_string(substr($desc4, 2, strlen($desc4) - 4));
            }
            
            $extra="";
            if($r['extra_item_list[0]']!="")
            {
                $extra.=':'.$r['extra_item_list[0]'].':';
            }
            if($r['extra_item_list[1]']!="")
            {
                $extra.=':'.$r['extra_item_list[1]'].':';
            }
            if($r['extra_item_list[2]']!="")
            {
                $extra.=':'.$r['extra_item_list[2]'].':';
            }
            
            $extra_d=$r['set_extra_desc'];
            if($extra_d=='a,')
            {
                $extra_d='';
            }
            else
            {
                $extra_d=mysql_real_escape_string(substr($extra_d, 2, strlen($extra_d) - 4));
            }
            $enchant6=$r['enchant6'];
            if($enchant6!='')
            {
                $enchant6=mysql_real_escape_string(substr($enchant6, 2, strlen($enchant6) - 4));
            }
            $enchant7=$r['enchant7'];
            if($enchant7!='')
            {
                $enchant7=mysql_real_escape_string(substr($enchant7, 2, strlen($enchant7) - 4));
            }
            $enchant8=$r['enchant8'];
            if($enchant8!='')
            {
                $enchant8=mysql_real_escape_string(substr($enchant8, 2, strlen($enchant8) - 4));
            }
            mysql_query("UPDATE `setitemgrp` SET `part1`='$part1', `part2`='$part2',`part3`='$part3',`part4`='$part4',`part5`='$part5',`set_bonus_desc[0]`='$desc0',`set_bonus_desc[1]`='$desc1',`set_bonus_desc[2]`='$desc2',`set_bonus_desc[3]`='$desc3',`set_bonus_desc[4]`='$desc4',`extra`='$extra', `set_extra_desc`='$extra_d',`enchant6`='$enchant6',`enchant7`='$enchant7',`enchant8`='$enchant8' WHERE `id`='{$r['id']}';") OR die(mysql_error());
        }
        mysql_query("ALTER TABLE `setitemgrp` DROP COLUMN `a0`, DROP COLUMN `a1`, DROP COLUMN `a2`, DROP COLUMN `a3`, DROP COLUMN `a4`, DROP COLUMN `p0`, DROP COLUMN `p1`, DROP COLUMN `p2`, DROP COLUMN `p3`, DROP COLUMN `p4`, DROP COLUMN `g0`, DROP COLUMN `g1`, DROP COLUMN `g2`, DROP COLUMN `g3`, DROP COLUMN `g4`, DROP COLUMN `b0`, DROP COLUMN `b1`, DROP COLUMN `b2`, DROP COLUMN `b3`, DROP COLUMN `b4`, DROP COLUMN `h0`, DROP COLUMN `h1`, DROP COLUMN `h2`, DROP COLUMN `h3`, DROP COLUMN `h4`, DROP COLUMN `cnt3`, DROP COLUMN `extra_count`, DROP COLUMN `extra_item_list[0]`, DROP COLUMN `extra_item_list[1]`, DROP COLUMN `extra_item_list[2]`, DROP COLUMN `cnt4`,
CHANGE COLUMN `set_bonus_desc[0]` `desc1`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `part5`,
CHANGE COLUMN `set_bonus_desc[1]` `desc2`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `desc1`,
CHANGE COLUMN `set_bonus_desc[2]` `desc3`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `desc2`,
CHANGE COLUMN `set_bonus_desc[3]` `desc4`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `desc3`,
CHANGE COLUMN `set_bonus_desc[4]` `desc5`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `desc4`,
CHANGE COLUMN `set_extra_desc` `extra_desc`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `extra`;
");
        echo 'done';
            break;
            
            
        case 'skillname':
            $q1=mysql_query("SELECT Count(*) as c FROM `skillname` WHERE `desc` LIKE 'a,%'");
            echo mysql_result($q1, 'c').' records to go<br/>';
                    $query = mysql_query("SELECT `id`, `lvl`, `name`, `desc`, `desc1`, `desc2` FROM `skillname` WHERE `desc` LIKE 'a,%';") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query)) {

            //$s = array("\\\\n", "\\n", "\\0");
            //$re = array("<br />", "<br />", "");

            $name = mysql_real_escape_string(substr($r['name'], 2, strlen($r['name']) - 4));

            $desc = mysql_real_escape_string(substr($r['desc'], 2, strlen($r['desc']) - 4));
            if ($desc === "none") {
                $desc = "";
            }
            $desc1 = mysql_real_escape_string(substr($r['desc1'], 2, strlen($r['desc1']) - 4));
            if ($desc1 === "none") {
                $desc1 = "";
            }

            $desc2 = mysql_real_escape_string(substr($r['desc2'], 2, strlen($r['desc2']) - 4));
            if ($desc2 === "none") {
                $desc2 = "";
            }
            mysql_query("UPDATE `skillname` SET `name`='$name', `desc`='$desc', `desc1`='$desc1', `desc2`='$desc2' WHERE `id`='{$r['id']}' AND `lvl`='{$r['lvl']}';") OR die(mysql_error());
        }
//header("Location: ?a=step2");
        echo "done";
            break;
            
        case 'itemname':
            $query = mysql_query("SELECT * FROM `armorgrp`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query)) {
            $icon=$r['icon'];
            $weight=$r['weight'];
            $material=$r['material'];
            $cryst=$r['crystallizable'];
            $fam=$r['family'];
            $grade=$r['crystal_type'];
            $id=$r['id'];
            mysql_query("UPDATE `itemname` SET `icon`='$icon', `type`='a', `weight`='$weight', `material`='$material', `crystallizable`='$cryst', `family`='$fam', `grade`='$grade'  WHERE `id`='$id';") OR die(mysql_error());
        }
        /*mysql_query("ALTER TABLE `armorgrp`
DROP COLUMN `icon`,
DROP COLUMN `weight`,
DROP COLUMN `material`,
DROP COLUMN `crystallizable`,
DROP COLUMN `armor_type`,
DROP COLUMN `crystal_type`;");*/
            /*$query1 = mysql_query("SELECT * FROM `etcitemgrp`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query1)) {
            mysql_query("UPDATE `itemname` SET `icon`='{$r['icon']}',`type`='e',`weight`='{$r['weight']}',`material`='{$r['material']}',`crystallizable`='{$r['crystallizable']}',`family`='{$r['family']}',`grade`='{$r['grade']}'  WHERE `id`='{$r['id']}';") OR die(mysql_error());
        }
        mysql_query("DROP TABLE `etcitemgrp`;");
        $query2 = mysql_query("SELECT * FROM `weapongrp`") OR die(mysql_error());
        while ($r = mysql_fetch_assoc($query2)) {
            mysql_query("UPDATE `itemname` SET `icon`='{$r['icon']}',`type`='w',`weight`='{$r['weight']}',`material`='{$r['material']}',`crystallizable`='{$r['crystallizable']}',`family`='{$r['weapon_type']}',`grade`='{$r['crystal_type']}'  WHERE `id`='{$r['id']}';") OR die(mysql_error());
        }
        mysql_query("ALTER TABLE `weapongrp`
DROP COLUMN `icon`,
DROP COLUMN `weight`,
DROP COLUMN `material`,
DROP COLUMN `crystallizable`,
DROP COLUMN `weapon_type`,
DROP COLUMN `crystal_type`;");*/
        echo 'done ...';
            break;
            
################################################################################################
    default:
        echo 'Each script will take up to 2 hours, depending on your harware!<br/>';
        echo '<a href="?a=optiondata">OptionData</a><br />';
        echo '<a href="?a=itemname">ItemName</a><br />';
        echo '<a href="?a=setitemgrp">SetItemGrp</a><br />';
        echo '<a href="?a=skillname">SkillName</a><br />';
        echo '<a href="?a=itemname">ItemName</a><br />';
        break;
}