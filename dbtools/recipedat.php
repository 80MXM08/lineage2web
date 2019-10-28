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
	$query = $sql['core']->query("SELECT * FROM `recipe_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name	 = trim(preg_replace('!\s+!', ' ', str_replace($s, $re, substr($r['name'], 2, strlen($r['name']) - 4))));
	    
	    $qry	 = 'UPDATE recipe_h5 SET `name`=? WHERE id=?';
	    $arr	 = [$name, $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '2': //merge items
	$query = $sql['core']->query("SELECT * FROM `recipe_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $items = '';
	    for ($i = 1; $i < 12; $i++)
	    {
		if ($r['materials' . $i . '_id'] != "")
		{
		    $items .= ':' . $r['materials' . $i . '_id'] . ',' . $r['materials' . $i . '_cnt'] . ':';
		}
	    }
	    $qry	 = 'UPDATE recipe_h5 SET `materials`=? WHERE id=?';
	    $arr	 = [$items, $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
    case '3':

	for ($i = 1; $i < 12; $i++)
	{
	    $sql['core']->query('ALTER TABLE `recipe_h5` DROP COLUMN `materials' . $i . '_id`', []);
	    $sql['core']->query('ALTER TABLE `recipe_h5` DROP COLUMN `materials' . $i . '_cnt`', []);
	}


	break;
################################################################################################
    default:
	for ($i = 1; $i < 4; $i++)
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