<?php
if (!defined('CORE')) {
    header('Location: ../../index.php');
    die();
}

$expires = Conf::get('cache', 'enabled') ? 60*60*24*14 : 0;
$parse=Conf::getAllFromType('web');
if ($url != '') {
    $parse['refresh'] = '<meta http-equiv="refresh" content="' . $time . ' URL=' . $url . '" />';
}
else
{
    $parse['refresh']='';
}

$parse['lang_confirm_vit'] = sprintf($Lang['__confirm-vit_'], Conf::get('vote', 'vitality_cost'));
$parse['bg_nr'] = date('w');
$parse['time'] = User::isLogged() ? ($_SESSION['vote_time'] + 43200) : 0; //12h = 60 * 60 * 12
$parse['head'] = '';
$parse['theme'] = User::getVar('theme');

if ($head) {
    $parse1 = $parse;
    $parse1['blocks_left'] = Block::show('l');

    $parse1['announcements'] = '';
    $parse1['messages']='';
    if (Conf::get('web', 'show_announcement', '1')) {
        $parse1['announcements'] .= '<h1>' . Conf::get('web', 'announcement') . '</h1>';
    }
    if (Conf::get('web', 'show_announcement2', '1')) {
        $parse1['announcements'] .= '<h2>' . Conf::get('web', 'announcement2') . '</h2>';
    }
    if (User::isLogged() && $_SESSION['new_pm'] > 0) {
        $parse1['messages'] .= msg('', '<a href="msg.php?viewmailbox&amp;box=1">' . sprintf($Lang['__unread-msg_'], $_SESSION['new_pm'], ($_SESSION['new_pm'] == '1' ? '' : $Lang['__s_'])) . '</a>', 'success');
    }
    $parse['head'] = tpl::parse('theme/head_head', $parse1);
}

header('Pragma: public');
header('Cache-control: public');
header('Cache-Control: maxage=' . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
//header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
//header('Content-Type: application/xhtml+xml');
header('Content-Type: text/html; charset: UTF-8');

echo tpl::parse('theme/head', $parse);