<?php
ini_set('max_execution_time', '3600');
define('L2WEB', true);
require_once ("./../include/core.php");




header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=0");
header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
$a = filter_input(INPUT_GET, 'a');
echo '<a href="?a='.$a.'">try again</a><br />';
switch ($a)
{
    case "step1":
	$query = $sql['core']->query("SELECT * FROM `skillname_h5` WHERE done='0';");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name = substr($r['name'], 2, strlen($r['name']) - 4);

	    $desc = substr($r['desc'], 2, strlen($r['desc']) - 4);
	    if ($desc === "none")
	    {
		$desc = "";
	    }
	    $desc1 = substr($r['desc1'], 2, strlen($r['desc1']) - 4);
	    if ($desc1 === "none")
	    {
		$desc1 = "";
	    }

	    $desc2 = substr($r['desc2'], 2, strlen($r['desc2']) - 4);
	    if ($desc2 === "none")
	    {
		$desc2 = "";
	    }
	    $qry	 = 'UPDATE skillname_h5 SET name=?, `desc`=?, desc1=?, desc2=?, done=? WHERE id=? AND level=?';
	    $arr	 = [$name, $desc, $desc1, $desc2, 1, $r['id'], $r['level']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step2">STEP 2</a><br />';
	break;
    case 'step2':

	echo '<a href="?a=step2">try again</a><br />';
	$query = $sql['core']->query("SELECT * FROM `skillgrp_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $icon1	 = $r['icon1'];
	    $icon2	 = $r['icon2'];
	    $mp	 = $r['mp_consume'];
	    $hp	 = $r['hp_consume'];
	    $qry	 = 'UPDATE skillname_h5 SET icon=?, icon2=?, mp_consume=?, hp_consume=? WHERE id=? AND level=?';
	    $arr	 = [$icon1, $icon2, $mp, $hp, $r['id'], $r['level']];
	    try
	    {
		$sql['core']->query($qry, $arr);
	    }
	    catch (Exception $ex)
	    {
		die($ex);
	    }
	}
	echo "done<br />";
	echo '<a href="?a=step3">STEP 3</a><br />';
	break;

    case 'step3':
	$query = $sql['core']->query("SELECT * FROM `itemname_h5` WHERE `done`='0'");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $part1 = "";
	    if ($r['set1'] != "")
	    {
		$part1 .= $r['set1'] . ':';
	    }
	    if ($r['set2'] != "")
	    {
		$part1 .= $r['set2'] . ':';
	    }
	    if ($r['set3'] != "")
	    {
		$part1 .= $r['set3'] . ':';
	    }
	    if ($r['set4'] != "")
	    {
		$part1 .= $r['set4'] . ':';
	    }
	    if ($r['set5'] != "")
	    {
		$part1 .= $r['set5'] . ':';
	    }


	    $desc = $r['description'];
	    if ($desc == 'a,')
	    {
		$desc = '';
	    }
	    else
	    {
		$desc = substr($desc, 2, strlen($desc) - 4);
	    }
	    $desc1 = $r['set_bonus_desc'];
	    if ($desc1 == 'a,')
	    {
		$desc1 = '';
	    }
	    else
	    {
		$desc1 = substr($desc1, 2, strlen($desc1) - 4);
	    }
	    $desc2 = $r['set_extra_desc'];
	    if ($desc2 == 'a,')
	    {
		$desc2 = '';
	    }
	    else
	    {
		$desc2 = substr($desc2, 2, strlen($desc2) - 4);
	    }
	    $desc3 = $r['special_enchant_desc'];
	    if ($desc3 == 'a,')
	    {
		$desc3 = '';
	    }
	    else
	    {
		$desc3 = substr($desc3, 2, strlen($desc3) - 4);
	    }

	    $qry	 = 'UPDATE itemname_h5 SET `set`=?, `description`=?, `set_bonus_desc`=?, `set_extra_desc`=?, `special_enchant_desc`=?, `done`=? WHERE `id`=?';
	    $arr	 = [$part1, $desc, $desc1, $desc2, $desc3, '1', $r['id']];
	    try
	    {
		$sql['core']->query($qry, $arr);
	    }
	    catch (Exception $ex)
	    {
		die($ex);
	    }
	}
	echo "done<br />";
	echo '<a href="?a=step4">STEP 4</a><br />';
	break;
    case 'step3a':
	$query = $sql['core']->query("SELECT * FROM `itemname_h5` WHERE `done`='1'");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $part1 = "";
	    if ($r['set1'] != "")
	    {
		$part1 .= $r['set1'] . ':';
	    }
	    if ($r['set2'] != "")
	    {
		$part1 .= $r['set2'] . ':';
	    }
	    if ($r['set3'] != "")
	    {
		$part1 .= $r['set3'] . ':';
	    }
	    if ($r['set4'] != "")
	    {
		$part1 .= $r['set4'] . ':';
	    }
	    if ($r['set5'] != "")
	    {
		$part1 .= $r['set5'] . ':';
	    }
	    $part1 = substr($part1, 0, strlen($part1) - 1);

	    $qry	 = 'UPDATE itemname_h5 SET `set`=?, `done`=? WHERE `id`=?';
	    $arr	 = [$part1, '2', $r['id']];
	    try
	    {
		$sql['core']->query($qry, $arr);
	    }
	    catch (Exception $ex)
	    {
		die($ex);
	    }
	}
	echo "done<br />";
	echo '<a href="?a=step4">STEP 4</a><br />';

	break;

    case 'step4':
	$s	 = array("\\\\n", "\\n", "\\0");
	$re	 = array("<br />", "<br />", "");
	$query	 = $sql['core']->query("SELECT * FROM `itemname_h5` WHERE `done`='2'");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $aname = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $r['add_name'])));
	    $desc = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $r['desc'])));
	    $bdesc = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $r['bonus_desc'])));
	    $edesc = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $r['extra_desc'])));
	    $endesc = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $r['enchant_desc'])));

	    $qry	 = 'UPDATE `itemname_h5` SET `add_name`=?, `desc`=?, `bonus_desc`=?, `extra_desc`=?, `enchant_desc`=?, `done`=? WHERE `id`=?';
	    $arr	 = [$aname, $desc, $bdesc, $edesc, $endesc, '3', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step5">STEP 5</a><br />';
	break;
    case 'step5':
	foreach ($sql['core']->query("SELECT * FROM `armorgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `type`=?, `icon`=?, `icon1`=?, `icon2`=?, `icon3`=?, `icon4`=?, `grade`=?, `weight`=?, `crystallizable`=?, `durability`=?, `done`=? WHERE `id`=?';
	    $arr	 = ['a', $r['icon1'], $r['icon2'], $r['icon3'], $r['icon4'], $r['icon5'], $r['crystal_type'], $r['weight'], $r['crystallizable'], $r['durability'], '4', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step6">STEP 6</a><br />';
	break;
    case 'step6':
	foreach ($sql['core']->query("SELECT * FROM `etcitemgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `type`=?, `icon`=?, `grade`=?, `weight`=?, `crystallizable`=?, `done`=? WHERE `id`=?';
	    $arr	 = ['e', $r['icon1'], $r['grade'], $r['weight'], $r['crystallizable'], '4', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step7">STEP 7</a><br />';
	break;
    case 'step7':
	foreach ($sql['core']->query("SELECT * FROM `weapongrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `type`=?, `icon`=?, `icon1`=?, `icon2`=?, `grade`=?, `weight`=?, `crystallizable`=?, `durability`=?, `done`=?, `frame`=? WHERE `id`=?';
	    $arr	 = ['w', $r['icon1'], $r['icon2'], $r['icon3'], $r['crystal_type'], $r['weight'], $r['crystallizable'], $r['durability'], '4', $r['timetab'], $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step8">STEP 8</a><br />';
	break;
    case 'step8':
	foreach ($sql['core']->query("SELECT * FROM `armorgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `material`=?, `frame`=?, `body_part`=?, `done`=? WHERE `id`=?';
	    $arr	 = [$r['material'], $r['timetab'], $r['body_part'], '5', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step9">STEP 9</a><br />';
	break;
    case 'step9':
	foreach ($sql['core']->query("SELECT * FROM `armorgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `type2`=? WHERE `id`=?';
	    $arr	 = [$r['armor_type'], $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step10">STEP 10</a><br />';
	break;
    case 'step10':
	foreach ($sql['core']->query("SELECT * FROM `etcitemgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `material`=?, `frame`=?, `type2`=?, `body_part`=? `done`=? WHERE `id`=?';
	    $arr	 = [$r['material'], $r['fort'], $r['family'], '', '5', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step11">STEP 11</a><br />';
	break;
    case 'step11':
	foreach ($sql['core']->query("SELECT * FROM `weapongrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `material`=?, `body_part`=?, `type2`=?, `done`=? WHERE `id`=?';
	    $arr	 = [$r['material'], $r['body_part'], $r['weapon_type'], '5', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step12">STEP 12</a><br />';
	break;
    case 'step12':
	foreach ($sql['core']->query("SELECT * FROM `etcitemgrp_h5`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $quest = "";
	    if ($r['quest1'] != "")
	    {
		$quest .= ':' . $r['quest1'] . ':';
	    }
	    if ($r['quest2'] != "")
	    {
		$quest .= ':' . $r['quest2'] . ':';
	    }
	    if ($r['quest3'] != "")
	    {
		$quest .= ':' . $r['quest3'] . ':';
	    }
	    if ($r['quest4'] != "")
	    {
		$quest .= ':' . $r['quest4'] . ':';
	    }
	    if ($r['quest5'] != "")
	    {
		$quest .= ':' . $r['quest5'] . ':';
	    }
	    if ($r['quest6'] != "")
	    {
		$quest .= ':' . $r['quest6'] . ':';
	    }
	    $qry	 = 'UPDATE `etcitemgrp_h5` SET `quest`=? WHERE `id`=?';
	    $arr	 = [$quest, $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step13">STEP 13</a><br />';
	break;
    case 'step14':
	foreach ($sql['core']->query("SELECT * FROM `weapongrp_h5` WHERE `is_hero`='1'")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `itemname_h5` SET `mtype`=? WHERE `id`=?';
	    $arr	 = ['4', $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step14">STEP 14</a><br />';
	break;
    case 'step15':
	$s	 = array(",");
	$re	 = array(":");
	foreach ($sql['core']->query("SELECT * FROM `itemname_h5` WHERE `extra_ids` <> ''")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $set = ':' . str_replace($s, $re, $r['extra_ids']) . ':';

	    $qry	 = 'UPDATE `itemname_h5` SET `extra_ids`=? WHERE `id`=?';
	    $arr	 = [$set, $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step16">STEP 16</a><br />';
	break;

    case 'step16':
	$query = $sql['core']->query("SELECT * FROM `itemname_h5_2`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $part1 = '';
	    if ($r['set1'] != "")
	    {
		$part1 .= ':'.$r['set1'] . ':';
	    }
	    if ($r['set2'] != "")
	    {
		$part1 .= ':'.$r['set2'] . ':';
	    }
	    if ($r['set3'] != "")
	    {
		$part1 .= ':'.$r['set3'] . ':';
	    }
	    if ($r['set4'] != "")
	    {
		$part1 .= ':'.$r['set4'] . ':';
	    }
	    if ($r['set5'] != "")
	    {
		$part1 .= ':'.$r['set5'] . ':';
	    }
	    
	    $qry	 = 'UPDATE itemname_h5 SET `set`=? WHERE `id`=?';
	    $arr	 = [$part1, $r['id']];
	    try
	    {
		$sql['core']->query($qry, $arr);
	    }
	    catch (Exception $ex)
	    {
		die($ex);
	    }
	}
	echo "done<br />";
	echo '<a href="?a=step17">STEP 17</a><br />';
	break;

    case 'step17':
	$s	 = array(",");
	$re	 = array(":");
	foreach ($sql['core']->query("SELECT * FROM `itemname_h5` WHERE `extra_ids` <> ''")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $set = explode(':', $r['extra_ids']);
	    $e='';
	    foreach($set as $s)
	    {
		if($s=='') continue;
		$e.=$s.',';
	    }
	    $e=substr($e, 0, strlen($e) - 1);
	    $qry	 = 'UPDATE `itemname_h5` SET `extra_ids`=? WHERE `id`=?';
	    $arr	 = [$e, $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step18">STEP 18</a><br />';
	break;
    case 'step18':
	$s	 = array(",");
	$re	 = array(":");
	foreach ($sql['core']->query("SELECT * FROM `itemname_h5` WHERE `set` <> '' OR `enchant_amount` <> '0'")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $set = explode(':', $r['extra_ids']);
	    $e='';
	    foreach($set as $s)
	    {
		if($s=='') continue;
		$e.=$s.',';
	    }
	    $e=substr($e, 0, strlen($e) - 1);
	    $qry	 = 'UPDATE `armorgrp_h5` SET `set`=?, `extra_ids`=?, `enchant_amount`=?, `bonus_desc`=?, `extra_desc`=?, `enchant_desc`=? WHERE `id`=?';
	    $arr	 = [$r['set'],$r['extra_ids'],$r['enchant_amount'],$r['bonus_desc'],$r['extra_desc'],$r['enchant_desc'], $r['id']];
	    $sql['core']->query($qry, $arr);
	    $sql['core']->query("UPDATE itemname_h5 SET `set`='', extra_ids='', enchant_amount='', bonus_desc='', enchant_desc='', extra_desc='' WHERE id=?", [$r['id']]);
	}
	echo "done<br />";
	echo '<a href="?a=step19">STEP 19</a><br />';
	break;
    case 'step19':
	foreach ($sql['core']->query("SELECT `skill_id`, `skill_level`, `cast_range` FROM `skillgrp_h5_2`")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $qry	 = 'UPDATE `skillgrp_h5` SET `mp_consume`=? WHERE `id`=? AND `level`=?';
	    $arr	 = [$r['cast_range'], $r['skill_id'], $r['skill_level']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step20">STEP 20</a><br />';
	break;
    case 'step20':
	foreach ($sql['core']->query("SELECT * FROM `armorgrp_h5` WHERE `set` LIKE ?", ['%,%'])->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	
	    $set =str_replace([','], [':'], $r['set']);
	    $qry	 = 'UPDATE `armorgrp_h5` SET `set`=? WHERE `id`=?';
	    $arr	 = [$set, $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step21">STEP 21</a><br />';
	break;
	
    case 'step21':
		foreach ($sql['core']->query("SELECT * FROM `armorgrp_h5` WHERE `extra_ids` IS NOT NULL")->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	
	    $extra=explode(',',$r['extra_ids']);
	    $s='';
	    foreach($extra as $i)
	    {
		if($i=='' || $i==null) continue;
		$s.=':'.$i.':';
	    }
	    if($s=='') $s=null;
	    $qry	 = 'UPDATE `armorgrp_h5` SET `extra_ids`=? WHERE `id`=?';
	    $arr	 = [$s, $r['id']];
	    $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step22">STEP 22</a><br />';
	break;
	case '22':
	

$err=0;
		$qry=$sql['core']->query("SELECT id, `level`, `name`, icon FROM skills_h5");
foreach ($qry->fetchAll(PDO::FETCH_ASSOC) as $r)
{
	//if($err==0) echo 'ok';
    $icon = $r['icon'];

    if(file_exists('icons/not_used/'.$icon.'.png'))
    {
		rename('icons/not_used/'.$icon.'.png', 'icons/used/'.$icon.'.png');
        
    }
	elseif (file_exists('../img/icons/'.$icon.'.png'))
	{
		
	}
	else
	{
		echo 'Item ['.$r['id'].' - '.$r['name'].' - '.$r['level'].'] icon['.$icon.'] doesnt exists<br />';
        $err++;
	}
}
echo '<br />'.$err.'<br />';
	break;
    case '23':
	if ($handle = opendir('icons/')) {
	    $i=0;
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $file = str_replace('.png', '', $file);
	    $query =$sql['core']->query("SELECT id FROM itemname_h5 WHERE icon=? OR icon1=? OR icon2=? OR icon3=? OR icon4=?", [$file, $file, $file, $file, $file]);
            
            if(!$query->rowCount())
            {
                //echo "$file not present<br />";
                $file=stripslashes($file);
                rename("icons/$file.png", "icons/not_used/$file.png");
            }
            else
            {
		//echo "$file is present<br />";
                $file=stripslashes($file);
                rename("icons/$file.png", "icons/present/$file.png");
		$i++;
            }
        }
//	$i++;
//if($i>1000)
//die();
    }
    closedir($handle);
    echo $i.' icons moved<br />';
}
	
	break;
################################################################################################
    default:
	echo '<a href="?a=step1">START STEP 1</a><br />';
	echo '<a href="?a=step2">START STEP 2</a><br />';
	echo '<a href="?a=step3">START STEP 3</a><br />';
	echo '<a href="?a=step4">START STEP 4</a><br />';
	echo '<a href="?a=step5">START STEP 5</a><br />';
	echo '<a href="?a=step6">START STEP 6</a><br />';
	echo '<a href="?a=step7">START STEP 7</a><br />';
	echo '<a href="?a=step8">START STEP 8</a><br />';
	echo '<a href="?a=step9">START STEP 9</a><br />';
	echo '<a href="?a=step10">START STEP 10</a><br />';
	echo '<a href="?a=step11">START STEP 11</a><br />';
	echo '<a href="?a=step12">START STEP 12</a><br />';
	echo '<a href="?a=step13">START STEP 13</a><br />';
	echo '<a href="?a=step14">START STEP 14</a><br />';
	echo '<a href="?a=step15">START STEP 15</a><br />';
	echo '<a href="?a=step16">START STEP 16</a><br />';
	echo '<a href="?a=step17">START STEP 17</a><br />';
	echo '<a href="?a=step18">START STEP 18</a><br />';
	echo '<a href="?a=step19">START STEP 19</a><br />';
	break;
################################################################################################
}