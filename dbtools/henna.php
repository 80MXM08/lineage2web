<?php
ini_set('max_execution_time', '3600');
define('L2WEB', true);
require_once ("./../include/core.php");
$steps=4;
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
	$query = $sql['core']->query("SELECT * FROM `henna_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

	    $name	 = trim(substr($r['name'], 2, strlen($r['name']) - 4));
	    $icon	 = trim(substr($r['icon'], 2, strlen($r['icon']) - 4));
	    //$addname	 = trim(substr($r['add_name'], 2, strlen($r['add_name']) - 4));
	    $desc	 = trim(substr($r['desc'], 2, strlen($r['desc']) - 4));
	    
	    $qry	 = 'UPDATE henna_h5 SET `name`=?, `icon`=?, `desc`=? WHERE id=?';
	    $arr	 = [$name, $icon, $desc, $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
	case '2':
	$query = $sql['core']->query("SELECT * FROM `henna_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    $icons=explode('.',$r['icon']);
	    if(count($icons)!=2) die(print_r($icons));
	    $icon	 = $icons[1];
	    
	    $qry	 = 'UPDATE henna_h5 SET `icon`=? WHERE id=?';
	    $arr	 = [$icon, $r['id']];
	    $q2	 = $sql['core']->query($qry, $arr);
	}

	break;
		case '3':
	$query = $sql['core']->query("SELECT * FROM `henna_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    if(file_exists('icons/not_used/'.$r['icon'].'.png'))
	    {
		rename('icons/not_used/'.$r['icon'].'.png', 'icons/'.$r['icon'].'.png');
	    }
	}

	break;
			case '4':
	$query = $sql['core']->query("SELECT * FROM `henna_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{
	    if(file_exists('icons/tga/'.$r['icon'].'.tga'))
	    {
		rename('icons/tga/'.$r['icon'].'.tga', 'icons/'.$r['icon'].'.tga');
	    }
	}

	break;
################################################################################################
    default:
	for ($i = 1; $i < $steps+1; $i++)
	{
	    echo '<a href="?a=' . $i . '">START STEP ' . $i . '</a><br />';
	}
	break;
################################################################################################
}
if ($a)
{
    echo "done<br />";
    if($a<$steps)
    echo '<a href="?a=' . ++$a . '">STEP ' . $a . '</a><br />';
}