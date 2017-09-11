<?php
$DB = array(
    "host"      => "localhost", //MySQL Host
    "user"      => "root",      //MySQL User
    "password"  => "",    //MySQL Password
);
$db = $DB['database'];
$webdb='l2web';

ini_set('max_execution_time', '300');
mysql_connect($DB['host'],$DB['user'],$DB['password']);
mysql_select_db($webdb);
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=0");
header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
$a=$_GET['a'];
switch($a)
{

################################################################################################
    case 'step1': # move columns from grp to name
    
    $query=mysql_query("SELECT `id`,`icon`, `icon1`, `icon2`, `icon3`, `icon4`, `durability`, weight, crystallizable, `grade` FROM armorgrp UNION SELECT `id`,`icon`, `icon1`, `icon2`, `icon3`, `icon4`, `durability`, weight, crystallizable, `grade` FROM etcitemgrp UNION SELECT `id`,`icon`, `icon1`, `icon2`, `icon3`, `icon4`, `durability`, weight, crystallizable, `grade` FROM weapongrp;") or die(mysql_error());
    while($it=mysql_fetch_assoc($query))
    {
        $it['icon']=mysql_real_escape_string($it['icon']);
        $q="UPDATE `itemname` SET `icon`='{$it[icon]}', `icon1`='{$it[icon1]}', `icon2`='{$it[icon2]}', `icon3`='{$it[icon3]}', `icon4`='{$it[icon4]}', `durability`='{$it[durability]}', `weight`='{$it[weight]}', `crystallizable`='{$it[crystallizable]}', `grade`='{$it[grade]}' WHERE `id`='{$it[id]}';";
        mysql_query($q) or die("Query (".$q.") <br /> Error: ".mysql_error());
        
    }
    mysql_query("ALTER TABLE `armorgrp`
DROP COLUMN `icon`,
DROP COLUMN `icon1`,
DROP COLUMN `icon2`,
DROP COLUMN `icon3`,
DROP COLUMN `icon4`,
DROP COLUMN `durability`,
DROP COLUMN `weight`,
DROP COLUMN `crystallizable`,
DROP COLUMN `grade`;") or die(mysql_error());
mysql_query("ALTER TABLE `etcitemgrp`
DROP COLUMN `icon`,
DROP COLUMN `icon1`,
DROP COLUMN `icon2`,
DROP COLUMN `icon3`,
DROP COLUMN `icon4`,
DROP COLUMN `durability`,
DROP COLUMN `weight`,
DROP COLUMN `crystallizable`,
DROP COLUMN `grade`;") or die(mysql_error());
mysql_query("ALTER TABLE `weapongrp`
DROP COLUMN `icon`,
DROP COLUMN `icon1`,
DROP COLUMN `icon2`,
DROP COLUMN `icon3`,
DROP COLUMN `icon4`,
DROP COLUMN `durability`,
DROP COLUMN `weight`,
DROP COLUMN `crystallizable`,
DROP COLUMN `grade`;") or die(mysql_error());
header("Location: ?a=step2");
    break;
################################################################################################
    case 'step2': ####Clear itemname descriptions
$query = mysql_query("SELECT `id`, `desc`, `bonus_desc`, `extra_desc`, `enchant_desc` FROM `itemname`") OR die(mysql_error());
while($r=mysql_fetch_assoc($query))
{

    $s=array("\\\\n","\\n",  "\\0");
    $re=array("<br />","<br />",  "");
    $desc = $r['desc'];
    $desc=substr($desc, 2, strlen($desc)-2);
    $bonus_desc = $r['bonus_desc'];
    $bonus_desc=substr($bonus_desc, 2, strlen($bonus_desc)-2);
    $extra_desc = $r['extra_desc'];
    $extra_desc=substr($extra_desc, 2, strlen($extra_desc)-2);
    $enchant_desc = $r['enchant_desc'];
    $enchant_desc=substr($enchant_desc, 2, strlen($enchant_desc)-2);
    $desc=str_replace($s, $re, $desc);
    $bonus_desc=str_replace($s, $re, $bonus_desc);
    $extra_desc=str_replace($s, $re, $extra_desc);
    $enchant_desc=str_replace($s, $re, $enchant_desc);
    $desc=mysql_real_escape_string($desc);
    $bonus_desc=mysql_real_escape_string($bonus_desc);
    $extra_desc=mysql_real_escape_string($extra_desc);
    $enchant_desc=mysql_real_escape_string($enchant_desc);
    mysql_query("UPDATE `itemname` SET `desc`='$desc', `bonus_desc`='$bonus_desc', `extra_desc`='$extra_desc', `enchant_desc`='$enchant_desc' WHERE `id`='{$r['id']}';") OR die(mysql_error());
}
header("Location: ?a=step3");
    break;
################################################################################################
    case 'step3': ####Update item type
    mysql_query("ALTER TABLE `itemname`
ADD COLUMN `type`  char(1) NOT NULL DEFAULT 'e' AFTER `grade`;");
    $q=mysql_query("SELECT id FROM armorgrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `type`='a' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    $q=mysql_query("SELECT id FROM etcitemgrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `type`='e' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    $q=mysql_query("SELECT id FROM weapongrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `type`='w' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    header("Location: ?a=step4");
    break;
###############################################################################################
    case 'step4': #copy all set_ids columns into one
    $query=mysql_query("SELECT id, `set_ids[0]`, `set_ids[1]`, `set_ids[2]`, `set_ids[3]`, `set_ids[4]` FROM itemname") OR die(mysql_error());
    while($it=mysql_fetch_assoc($query))
    {
        $set_ids='';
        if($it['set_ids[0]']!='') $set_ids.=$it['set_ids[0]'];
        if($it['set_ids[1]']!='') {$set_ids==''?$set_ids.=$it['set_ids[1]']:$set_ids.=';'.$it['set_ids[1]'];}
        if($it['set_ids[2]']!='') {$set_ids==''?$set_ids.=$it['set_ids[2]']:$set_ids.=';'.$it['set_ids[2]'];}
        if($it['set_ids[3]']!='') {$set_ids==''?$set_ids.=$it['set_ids[3]']:$set_ids.=';'.$it['set_ids[3]'];}
        if($it['set_ids[4]']!='') {$set_ids==''?$set_ids.=$it['set_ids[4]']:$set_ids.=';'.$it['set_ids[4]'];}
        if($set_ids!='')
            mysql_query("UPDATE itemname SET set_ids='$set_ids' WHERE id='{$it['id']}';") OR die(mysql_error());
    }
    mysql_query("ALTER TABLE `itemname`
DROP COLUMN `set_ids[0]`,
DROP COLUMN `set_ids[1]`,
DROP COLUMN `set_ids[2]`,
DROP COLUMN `set_ids[3]`,
DROP COLUMN `set_ids[4]`;");
header("Location: ?a=step5");
    break;
################################################################################################
    case 'step5':
    $qry=mysql_query("SELECT id, icon, icon1, icon2, icon3, icon4 FROM itemname WHERE icon !='';") OR die(mysql_error());
    $search=array('BranchSys.Icon.','BranchSys.Icon2.','BranchSys2.Icon.','br_cashtex.item.','branchsys2.icon2.','BranchSys2.','BranchSys.','Icon.', 'icon.','Branchsys2.','branchsys2.','icon2.','etc_i.');
    $replace=array('','','','','','','','','','','','','');
    while($it=mysql_fetch_assoc($qry))
    {
        $icon=mysql_real_escape_string(str_replace($search, $replace, $it['icon']));
        $icon1=str_replace($search, $replace, $it['icon1']);
        $icon2=str_replace($search, $replace, $it['icon2']);
        $icon3=str_replace($search, $replace, $it['icon3']);
        $icon4=str_replace($search, $replace, $it['icon4']);
        mysql_query("UPDATE itemname SET icon='$icon', icon1='$icon1', icon2='$icon2', icon3='$icon3', icon4='$icon4' WHERE id='{$it['id']}'") OR die(mysql_error());
    }
    header("Location: ?a=step6");
    echo 'Moving to step 6 ...';
    break;
################################################################################################
    case 'step6': #missing icons from sql
$query = mysql_query("SELECT id, name, icon, icon1, icon2, icon3, icon4 FROM itemname WHERE icon != ''") OR mysql_error();
$i=0;
$err=0;
while($r=mysql_fetch_assoc($query))
{
    $icon = $r['icon'];
    $icon1 = $r['icon1'];
    $icon2 = $r['icon2'];
    $icon3 = $r['icon3'];
    $icon4 = $r['icon4'];
    if(!file_exists('img/icon/'.$icon.'.png'))
    {
        echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon.'] doesnt exists<br />';
        $err++;
    }
    if($icon1!='')
    {
       if(!file_exists('img/icon/'.$icon1.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon1.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon2!='')
    {
       if(!file_exists('img/icon/'.$icon2.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon2.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon3!='')
    {
       if(!file_exists('img/icon/'.$icon3.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon3.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon4!='')
    {
       if(!file_exists('img/icon/'.$icon4.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon4.'] doesnt exists<br />';
            $err++;
        } 
    }
$i++;
}
header("Location: ?a=step7");
echo 'Moving to step 7 ...';
    break;
################################################################################################
    case 'step7': #useless icons
    if ($handle = opendir('img/icon/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $file = str_replace('.png', '', $file);
            $file = mysql_real_escape_string($file);
            $query = mysql_query("SELECT id FROM itemname WHERE icon='$file' OR icon1='$file' OR icon2='$file' OR icon3='$file' OR icon4='$file'") OR mysql_error();
            if(!mysql_num_rows($query))
            {
                echo "$file<br />";
                $file=stripslashes($file);
                rename("img/icon/$file.png", "img/notused/$file.png");
            }
            else
            {
                $file=stripslashes($file);
                rename("img/icon/$file.png", "img/icons/$file.png");
            }
        }
    }
    closedir($handle);
}
header("Location: ?a=finish");
echo 'Moving to finish...';
    break;
################################################################################################
    case 'finish':
    mysql_query("ALTER TABLE `itemname`
ADD COLUMN `item_type`  tinyint(2) UNSIGNED NOT NULL DEFAULT 0 AFTER `grade`;");
    $q=mysql_query("SELECT id, armor_type FROM armorgrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `item_type`='{$it['armor_type']}' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    $q=mysql_query("SELECT id, family FROM etcitemgrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `item_type`='{$it['family']}' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    $q=mysql_query("SELECT id, weapon_type FROM weapongrp;") OR die(mysql_error());
    while($it=mysql_fetch_assoc($q))
    {
        mysql_query("UPDATE itemname SET `item_type`='{$it['weapon_type']}' WHERE id='{$it[id]}'") OR die(mysql_error());
    }
    mysql_query("ALTER TABLE `armorgrp`
DROP COLUMN `armor_type`;") or die(mysql_error());
mysql_query("ALTER TABLE `etcitemgrp`
DROP COLUMN `family`;") or die(mysql_error());
mysql_query("ALTER TABLE `weapongrp`
DROP COLUMN `weapon_type`;") or die(mysql_error());
    echo 'ALL done!';
    break;
################################################################################################
    default:
    echo '<a href="?a=step1">START</a><br />';
    break;
################################################################################################
}
mysql_close();
?>