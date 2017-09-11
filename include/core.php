<?php
if(!defined('L2WEB'))
{
	header("Location: ../index.php");
	die();
}
$timeParts = explode(" ", microtime());
$startTime = $timeParts[1] . substr($timeParts[0], 1);

define('SQL_NEXT_ID', 2); //Next connection id;
define('CORE', true);

session_start();

if(isset($_SESSION['lang']) && $_SESSION['lang']!='')
{
    require_once('lang/'.$_SESSION['lang'].'.php');
}
else
{
    require_once ("lang/en.php");
}

require_once ('./include/config.php');
require_once ('queries.php');
require_once ('class.tplParser.php');
require_once ('class.mysql.php');
require_once ('functions.php');
require_once ('class.user.php');
require_once ('class.cache.php');
require_once ('class.config.php');
require_once('class.l2web.php');


$sql=array();
$sql[0] = new SQL($DB[0], 0, true); //web
$sql[1] = new SQL($DB[1], 1, true); //acc
//$sql[2] = new SQL($DB[2], 2, true); //cs
//$sql[3] = new SQL($DB[3], 3, true); //char
unset($DB);

User::init();
Config::init();
TplParser::setDir(isset($_SESSION['theme'])?$_SESSION['theme']:Config::get('settings','dtheme','default'));

$sql[0]->query('GET_GS_LIST');
$GS=array();
while($G=SQL::fetchArray())
{
    array_push($GS, $G);
}
foreach($GS as $g)
{
    if(!$g['active']) { continue; }
    $dbi=array(
  		"host" => $g['db_host'],    //MySQL Host
        "port" => $g['db_port'],         //MySQL Port
		"user" => $g['db_user'],         //MySQL User
		"password" => $g['db_pass'],         //MySQL Password
		"database" => $g['database']     //L2J Character DataBase (default - l2jdb)
    );
    $sql[SQL_NEXT_ID+$g['id']]= new SQL($dbi,'gs', true);
}
for($i=0; $i<count($GS); $i++)
{
    unset($GS[$i]['db_host'], $GS[$i]['db_port'], $GS[$i]['db_user'], $GS[$i]['db_pass']);
}

if(Config::get('features', 'cracktracker', '0'))
{
    //require_once ('include/cracktracker.php');
}

if(Config::get('features', 'bancontrol', '0'))
{
    //require_once ('include/bancontrol.php');
}

Cache::init(Config::get('cache','enabled','1'));
if(!Config::get('debug', 'web', '0'))
{
    error_reporting(0);
}
//require_once('include/func_l2web.php');
?>