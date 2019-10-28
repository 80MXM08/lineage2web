<?php
if (!defined('CORE'))
{
    header('Location: ../index.php');
    exit();
}
$parse = null;
if (User::isLogged())
{
    $parse['welcome_acc'] = sprintf($Lang['__welcome_'], $_SESSION['account']);
    if (User::isAdmin())
    {
	$parse['admin_link'] = '<li><a href="admin.php">' . $Lang['__admin_'] . '</a></li>';
    }
    else
    {
	$parse['admin_link'] = '';
    }
    if (User::isMod())
    {
	$parse['ban_link']	 = '<li><a href="bans.php">' . $Lang['__ban-list_'] . '</a></li>';
	$parse['news_link']	 = '<li><a href="news.php">' . $Lang['__news_'] . '</a></li>';
    }
    else
    {
	$parse['ban_link']	 = '';
	$parse['news_link']	 = '';
    }
    $parse['time'] = $_SESSION['vote_time'] + 60 * 60 * 12;
    if ($parse['time'] > time())
    {
	$parse['vote_after_msg'] = $Lang['__vote-after_'] . '<br />';
    }
    else
    {
	$parse['vote_after_msg'] = '';
    }
    $parse['unread']	 = $_SESSION['new_pm'];
    $parse['sent']		 = $_SESSION['sent_pm'];
    $parse['rec']		 = $_SESSION['rec_pm'];
    $parse['new']		 = $_SESSION['new_pm'] > 0 ? 'new' : '';
    $parse['in_mes']	 = sprintf($Lang['__in-mes_'], $parse['rec'], $parse['unread']);
    $parse['out_mes']	 = sprintf($Lang['__out-mes_'], $parse['sent']);
    $parse['wp_link']	 = sprintf($Lang['__webpoints_'], $_SESSION['web_points']);
    $content		 = tpl::parse('blocks/login_logged', $parse);
}
else
{
    $parse['button'] = button('login');
    $content	 = tpl::parse('blocks/login', $parse);
}
global $content;
