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
	$query = $sql['core']->query("SELECT * FROM `zonename_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name	 = substr($r['name'], 2, strlen($r['name']) - 4);
	    $map = ($map=='a,'?null:substr($r['map'], 2, strlen($r['map']) - 4));
	    $qry	 = 'UPDATE zonename_h5 SET `name`=?, `map`=? WHERE id=?';
	    $arr	 = [$name, $map, $r['id']];
	    $sql['core']->query($qry, $arr);
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