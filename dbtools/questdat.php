<?php
ini_set('max_execution_time', '3600');
define('L2WEB', true);
require_once ("./../include/core.php");

$a	 = filter_input(INPUT_GET, 'a');
$s	 = array("\\\\n", "\\\\n1", "\\n");
$re	 = array("", "", "");
if ($a)
{
    echo '<a href="?a=' . $a . '">try again</a><br />';
}
switch ($a)
{
    case '1':
	$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['name'], 2, strlen($r['name']) - 4))));
	    $prog	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['sub_name'], 2, strlen($r['sub_name']) - 4))));
	    $desc	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['desc'], 2, strlen($r['desc']) - 4))));
	    $qry	 = 'UPDATE questname_h5 SET `name`=?, `sub_name`=?, `desc`=? WHERE id=? AND progress=?';
	    $arr	 = [$name, $prog, $desc, $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '2': //merge items
	$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $items = '';
	    for ($i = 0; $i < 14; $i++)
	    {
		if ($r['items[' . $i . ']'] != "")
		{
		    $items .= ':' . $r['items[' . $i . ']'] . ',' . $r['num_items[' . $i . ']'] . ':';
		}
	    }
	    $qry	 = 'UPDATE questname_h5 SET `items`=? WHERE id=? AND progress=?';
	    $arr	 = [$items, $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '3':

	for ($i = 0; $i < 14; $i++)
	{
	    $sql['core']->query('ALTER TABLE `questname_h5` DROP COLUMN `items[' . $i . ']`', []);
	    $sql['core']->query('ALTER TABLE `questname_h5` DROP COLUMN `num_items[' . $i . ']`', []);
	}


	break;

    case '4':
	$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['npc_name'], 2, strlen($r['npc_name']) - 4))));
	    $rest	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['restrictions'], 2, strlen($r['restrictions']) - 4))));
	    $desc	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['short_desc'], 2, strlen($r['short_desc']) - 4))));
	    $qry	 = 'UPDATE questname_h5 SET `npc_name`=?, `restrictions`=?, `short_desc`=? WHERE id=? AND progress=?';
	    $arr	 = [$name, $rest, $desc, $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
	    case '5': //merge items
	$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $items = '';
	    for ($i = 0; $i < 69; $i++)
	    {
		if ($r['req_class[' . $i . ']'] != "")
		{
		    $items .= ':' . $r['req_class[' . $i . ']'];
		}
	    }
	    if ($items != '')
	    {
		$items .= ':';
	    }
	    $qry	 = 'UPDATE questname_h5 SET `req_class`=? WHERE id=? AND progress=?';
	    $arr	 = [$items, $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '6':

	for ($i = 0; $i < 69; $i++)
	{
	    $sql['core']->query('ALTER TABLE `questname_h5` DROP COLUMN `req_class[' . $i . ']`', []);
	}


	break;
		    case '7': //merge items
	$query = $sql['core']->query("SELECT * FROM `questname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $items = '';
	    for ($i = 0; $i < 5; $i++)
	    {
		if ($r['req_item[' . $i . ']'] != "")
		{
		    $items .= ':' . $r['req_item[' . $i . ']'];
		}
	    }
	   if ($items != '')
	    {
		$items .= ':';
	    }
	    else 
	    {
		$items = null;
	    }
	    $qry	 = 'UPDATE questname_h5 SET `req_items`=? WHERE id=? AND progress=?';
	    $arr	 = [$items, $r['id'], $r['progress']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '8':

	for ($i = 0; $i < 5; $i++)
	{
	    $sql['core']->query('ALTER TABLE `questname_h5` DROP COLUMN `req_item[' . $i . ']`', []);
	}


	break;
################################################################################################
    default:
	for ($i = 1; $i < 11; $i++)
	{
	    echo '<a href="?a=' . $i . '">START STEP ' . $i . '</a><br />';
	}
	break;
################################################################################################
}
if ($a)
{
    echo "done<br />";
    echo '<a href="?a=' . ++$a . '">STEP ' . $a . '</a><br />';
}