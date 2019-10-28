<?php
ini_set('max_execution_time', '3600');
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=0");
header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
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
		    $search=array('BranchSys.Icon.','BranchSys.Icon2.','BranchSys2.Icon.','br_cashtex.item.','branchsys2.icon2.','BranchSys2.','BranchSys.','Icon.', 'icon.','Branchsys2.','branchsys2.','icon2.','etc_i.');
    $replace=array('');

	$query = $sql['core']->query("SELECT * FROM `itemname_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

        $icon=str_replace($search, $replace, $r['icon']);
        $icon1=str_replace($search, $replace, $r['icon1']);
        $icon2=str_replace($search, $replace, $r['icon2']);
        $icon3=str_replace($search, $replace, $r['icon3']);
        $icon4=str_replace($search, $replace, $r['icon4']);

	    $qry	 = 'UPDATE itemname_h5 SET `icon`=?, `icon1`=?, `icon2`=?, `icon3`=?, `icon4`=? WHERE id=?';
	    $arr	 = [$icon, $icon1, $icon2, $icon3, $icon4, $r['id']];
	    $sql['core']->query($qry, $arr);
	}

	break;
    case '2':
	
	$query = $sql['core']->query("SELECT id, name, icon, icon1, icon2, icon3, icon4 FROM itemname_h5 WHERE icon != ''");
$i=0;
$err=0;
foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
{
    $icon = $r['icon'];
    $icon1 = $r['icon1'];
    $icon2 = $r['icon2'];
    $icon3 = $r['icon3'];
    $icon4 = $r['icon4'];
    if(!file_exists('../img/icon/'.$icon.'.png'))
    {
        echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon.'] doesnt exists<br />';
        $err++;
    }
    if($icon1!='')
    {
       if(!file_exists('../img/icon/'.$icon1.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon1.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon2!='')
    {
       if(!file_exists('../img/icon/'.$icon2.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon2.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon3!='')
    {
       if(!file_exists('../img/icon/'.$icon3.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon3.'] doesnt exists<br />';
            $err++;
        } 
    }
    if($icon4!='')
    {
       if(!file_exists('../img/icon/'.$icon4.'.png'))
        {
            echo 'Item ['.$r['id'].' - '.$r['name'].'] icon['.$icon4.'] doesnt exists<br />';
            $err++;
        } 
    }
$i++;

}
	break;
    case '3':
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
    case '4':
		    $search=array('BranchSys.Icon.','BranchSys.Icon2.','BranchSys2.Icon.','br_cashtex.item.','branchsys2.icon2.','BranchSys2.','BranchSys.','Icon.', 'icon.','Branchsys2.','branchsys2.','icon2.','etc_i.');
    $replace=array('');
	$i=0;
	$query = $sql['core']->query("SELECT id, level, icon, bg FROM `skills_h5`");
	foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
	{

        $icon=str_replace($search, $replace, $r['icon']);
        $bg=str_replace($search, $replace, $r['bg']);


	    $qry	 = 'UPDATE skills_h5 SET `icon`=?, `bg`=? WHERE id=? AND level=?';
	    $arr	 = [$icon, $bg, $r['id'], $r['level']];
	    $sql['core']->query($qry, $arr);
	    if($i++%999==0)
	    {
		echo $i.' icons fixed<br />';
	    }
	}

	
	break;
    case '5':
	if ($handle = opendir('icons/not_used/')) {
	    $i=0;
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {
            $file = str_replace('.png', '', $file);
	    $query =$sql['core']->query("SELECT id FROM skills_h5 WHERE icon=? OR bg=?", [$file, $file]);
            
            if($query->rowCount())
            {
                //echo "$file is present<br />";
                $file=stripslashes($file);
                rename("icons/not_used/$file.png", "icons/present/$file.png");
		if($i++%999==0)
	    {
		echo $i.' icons moved<br />';
	    }
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
    case '6':

	$query = $sql['core']->query("SELECT id, level, name, icon, bg FROM skills_h5");
$i=0;
$err=0;
foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $r)
{
    $icon = $r['icon'];
    $bg = $r['bg'];

    if(!file_exists('icons/present/'.$icon.'.png'))
    {
        echo 'Skill ['.$r['id'].'['.$r['level'].'] - '.$r['name'].'] icon['.$icon.'] doesnt exists<br />';
        $err++;
    }
    if($bg!='')
    {
       if(!file_exists('icons/present/'.$bg.'.png'))
        {
            echo 'Item ['.$r['id'].'['.$r['level'].'] - '.$r['name'].'] bg['.$bg.'] doesnt exists<br />';
            $err++;
        } 
    }

$i++;

}
	break;
	    case '7':

	//$query = $sql['core']->query("SELECT id, frame FROM itemname_h5 WHERE frame IS NOT NULL");
$i=0;
$err=0;
foreach ($sql['core']->query("SELECT id, frame FROM itemname_h5 WHERE frame IS NOT NULL AND frame LIKE ?", array('%.%'))->fetchAll(PDO::FETCH_ASSOC) as $r)
{
    $frames=explode('.', $r['frame']);
    switch(count($frames))
    {
	case 2:
	    $frame=$frames[1];
	    break;
	case 3:
	    $frame=$frames[2];
	    break;
	default:
	    die(print_r($frames));
	    break;
    }

    
    
    $sql['core']->query("UPDATE itemname_h5 SET frame=? WHERE id=?", array($frame, $r['id']));
}
	break;
################################################################################################
    default:
	for ($i = 1; $i < 10; $i++)
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