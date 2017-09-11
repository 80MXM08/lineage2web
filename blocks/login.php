<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	exit();
}

$parse = $Lang;
if(User::logged())
{
	$parse['welcome_acc'] = sprintf($Lang['welcome'], $_SESSION['account']);
	if(User::isAdmin())
	{
		//$parse['admin_link'] = '<tr><td><a href="admin.php">' . $Lang['admin'] . '</a></td></tr>';
        $parse['admin_link'] = '<li><a href="admin.php">' . $Lang['admin'] . '</a></li>';
	}
    if(User::isMod())
    {
        //$parse['ban_link']  = '<tr><td><a href="bans.php">' . $Lang['ban_list'] . '</a></td></tr>';
        //$parse['news_link'] = '<tr><td><a href="news.php">' . $Lang['news'] . '</a></td></tr>';
        $parse['ban_link']  = '<li><a href="bans.php">' . $Lang['ban_list'] . '</a></li>';
        $parse['news_link'] = '<li><a href="news.php">' . $Lang['news'] . '</a></li>';
    }
	$parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;
	if($parse['time'] > time())
	{
		$parse['vote_after_msg'] = $Lang['vote_after'] . '<br />';
	}
	$sql[0]->query('NEW_MESSAGES', array('acc'=>User::getUser()));
	$msg = SQL::fetchArray();
	$parse['unread'] = $_SESSION['new'] = $msg['new'];
	$sql[0]->query('SENT_MESSAGES', array('sender' => User::getUser()));
	$msg = SQL::fetchArray();
	$parse['sent'] = $msg['sent'];
	$sql[0]->query('RECEIVED_MESSAGES', array('receiver' => User::getUser()));
	$msg = SQL::fetchArray();
	$parse['rec'] = $msg['rec'];
	$parse['new'] = (User::getVar('new')> 0) ? "new" : "";
	$parse['in_mes'] = sprintf($Lang['in_mes'], $parse['rec'], $parse['unread']);
	$parse['out_mes'] = sprintf($Lang['out_mes'], $parse['sent']);
	$parse['wp_link'] = sprintf($Lang['webpoints'], $_SESSION['webpoints']);
	$content = TplParser::parse('blocks/login_logged', $parse, true);
	global $content;
}
else
{
	$parse['button'] = button('login', '', true);
	$content = TplParser::parse('blocks/login', $parse, true);
	global $content;
}
?>