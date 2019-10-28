<?php

if (!defined('CORE')) {
    header("Location: ../../index.php");
    die();
}

//$expires = 60*60*24*14;
$expires = 0;
$parse = null;
if ($url != '') {
    $parse['refresh'] = '<meta http-equiv="refresh" content="' . $time . ' URL=' . $url . '" />';
}
$parse['metad'] = Conf::get('head', 'MetaD', 'Fantasy World x50');
$parse['metak'] = Conf::get('head', 'MetaK', 'Lineage, freya, high, five, mid-rate, pvp');
$parse['copy'] = '2009 - ' . date('Y') . ' © Lineage II Fantasy World. All rights reserved.';
$parse['gsv'] = Conf::get('head', 'google_site_ver', 'OWsTYVKqBaP8O9ZFmiRR489Qj5PasFkQNwiv8-ornuM');
$parse['title'] = Conf::get('head', 'title', 'Lineage II Fantasy World') . " :: " . $title;
$parse['page_tracker'] = Conf::get('head', 'page_tracker', 'UA-11986252-1');
$parse['lang_confirm_vit'] = sprintf($Lang['confirm_vit'], Conf::get('voting', 'vitality_cost', '1'));
$parse['title_desc'] = 'LineAge II Fantasy World High Five';
$parse['bg_nr'] = isset($_GET['bg']) ? $_GET['bg'] : date('w');
$parse['time'] = User::logged() ? ($_SESSION['vote_time'] + 60 * 60 * 12) : 0;
$parse['head'] = '';
$parse['theme'] = User::getVar('theme');

if ($head) {
    $parse1 = $parse;
    $parse1['blocks_left'] = Block::show('l', true, true);

    $parse1['announcements'] = '';
    if (Conf::get('news', 'show_announcement', '1')) {
        $parse1['announcements'] .= '<h1>' . Conf::get('news', 'announcement', 'Welcome to Fantasy World Freya x50') . '</h1>';
    }
    if (Conf::get('head', 'show_announcement', '1')) {
        $parse1['announcements'] .= '<h2>' . Conf::get('head', 'announcement', 'Sub announcement') . '</h2>';
    }
    if (User::logged() && $_SESSION['new'] > 0) {
        $parse1['messages'] = msg('', '<a href="msg.php?viewmailbox&amp;box=1">' . sprintf($Lang['unread_msg'], $_SESSION['new'], ($_SESSION['new'] == '1' ? '' : $Lang['s'])) . '</a>', 'success', true);
    }
    $parse['head'] = tpl::parse('theme/head_head', $parse1, true);
}

header('Pragma: public');
header('Cache-control: public');
header('Cache-Control: maxage=' . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
//header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
//header('Content-Type: application/xhtml+xml');
header('Content-Type: text/html; charset: UTF-8');

echo tpl::parse('theme/head', $parse, true);
