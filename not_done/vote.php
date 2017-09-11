<?php
define('INWEB', true);
require_once ("include/config.php");
includeLang('vote');
loggedinOrReturn('vote.php');

head(getLang('vote','vote'));
$action = getVar('action');
$rew = getConfig('voting', 'reward', '5');
$timevoted = $_SESSION['vote_time'];
$now = time();

if($timevoted >= ($now - 60 * 60 * 12))
{
	msg(getLang('vote', 'thank_you'), getLang('vote', 'vote_tommorow'));
}
if($action == "vote" && $timevoted < ($now - 60 * 60 * 12))
{
	if(!$_SESSION['vote_rnd'] < time() && !$_SESSION['vote_rnd'] >= time() - 60 * 5)
		die();
	$_SESSION['vote_time'] = $now;
	$_SESSION['webpoints'] += $rew;
	$sql->query(51, array(
		'voted' => $now,
		'webpoints' => $rew,
		'login' => $_SESSION['account']));
	//$sql->query("INSERT INTO `".$webdb."`.`log` (`account`, `type`, `subType`, `comment`) VALUES ('{$_SESSION['account']}', 'voting', 'success', 'WebPoint Count=\"$rew\"');");
	msg(getLang('vote', 'thank_you'), getLang('vote', 'thank_for_voting'));

}
elseif ($action == "vote" && $timevoted >= ($now - 60 * 60 * 12))
{
	msg(getLang('system', 'error'), getLang('error', 8), 'error');
}

$parse = getLang('vote');
$parse['vote_reward'] = $rew;

$_SESSION['vote_rnd'] = time();
if($timevoted < ($now - 60 * 60 * 12))
	$parse['button'] = button(getLang('vote', 'get_reward'), 'go', true, true, 'go');

$tpl->parseTemplate('vote', $parse);
foot();
?>