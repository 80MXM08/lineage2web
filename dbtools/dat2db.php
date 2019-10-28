<?php
ini_set('max_execution_time', '3600');
define('L2WEB', true);
require_once ("./../include/core.php");

$a = filter_input(INPUT_GET, 'a');
$s=array("\\\\n","\\\\n1","\\n");
$re=array("","","");
echo '<a href="?a='.$a.'">try again</a><br />';
switch ($a)
{
    case "step1":
	$query = $sql['core']->query("SELECT * FROM `optiondata_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $s = array('\\\\n','\\n',);
	    $re = array('','');
	    $eff='';
	     $eff .= trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['effect1'], 2, strlen($r['effect1']) - 4))));

	    if ($r['effect2'] != "a,")
	    {
		$eff .= '<br />'.trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['effect2'], 2, strlen($r['effect2']) - 4))));
	    }
	    if ($r['effect3'] != "a,")
	    {
		$eff .= '<br />'.trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['effect3'], 2, strlen($r['effect3']) - 4))));
	    }
	    
	    $qry	 = 'UPDATE optiondata_h5 SET effect=? WHERE id=?';
	    $arr	 = [$eff, $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step2">STEP 2</a><br />';
	break;
    case 'step2':
	$query = $sql['core']->query("SELECT * FROM `skillgrp_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $qry	 = 'UPDATE skillname_h5 SET mp_consume=?, hp_consume=? WHERE id=? AND level=?';
	    $arr	 = [$r['mp_consume'], $r['hp_consume'], $r['id'], $r['level']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step3">STEP 3</a><br />';
	break;
    case 'step3':
	$query = $sql['core']->query("SELECT * FROM `raiddata_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $desc = substr($r['desc'], 2, strlen($r['desc']) - 4);
	     $desc1 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, $desc)));
	    $qry	 = 'UPDATE raiddata_h5 SET `desc`=? WHERE id=?';
	    $arr	 = [$desc1,  $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step4">STEP 4</a><br />';
	break;
    case 'step4':
		$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    
	     $name = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['name'], 2, strlen($r['name']) - 4))));
	     $prog = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['prog_name'], 2, strlen($r['prog_name']) - 4))));
	     $desc = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['desc'], 2, strlen($r['desc']) - 4))));
	    $qry	 = 'UPDATE questname_h5 SET `name`=?, `prog_name`=?, `desc`=? WHERE id=? AND progress=?';
	    $arr	 = [$name, $prog, $desc,  $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}
	echo "done<br />";
	echo '<a href="?a=step5">STEP 5</a><br />';
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