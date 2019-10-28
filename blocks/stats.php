<?php
if (!defined('CORE')) {
    header("Location: ../index.php");
    exit();
}

//TODO: move html to template?
$par['lang'] = User::getVar('lang');
$par['mod'] = User::isMod() == true ? 'true' : 'false';
$pars = implode(';', $par);
$content = '';
$page = 'bStats';
if (html::check($page, $pars)) {
    $parse = null;
    $imgoffline = htmlImg('img/status/offline.png', $Lang['__offline_']);
    $imgonline = htmlImg('img/status/online.png', $Lang['__online_']);
    $parse['login_server_status'] = '';
    if ($sql['ls']->showOnStats()) {
        $fp = @fsockopen($sql['ls']->getServerIp(), $sql['ls']->getServerPort(), $errno, $errstr, 0.1);
        if ($fp) {
            $loginonline = $imgonline;
        } else {
            $loginonline = $imgoffline;
        }

        $parse['login_server_status'] .= '<tr><td>' . $Lang['__login-server_'] . ':</td><td>' . $loginonline . '</td></tr>';
    }

    $parse['acc_count'] = DAO::get()::Account()::getTotal();
    $parse['gs_rows'] = '';

    foreach ($GS as $server) {
	$parse1 = null;
        $parse1['clan_count'] = DAO::get()::Clan()::getCount($server['id']);
        $parse1['char_count'] = DAO::get()::Char()::getCount($server['id']);
        $parse1['online_count'] = DAO::get()::Char()::getOnlineTradeCount($server['id']);
        if (User::isMod()) {
            $real = DAO::get()::Char()::getOnlineCount($server['id'], 1);
            $offline = DAO::get()::Char()::getOnlineCount($server['id'], 2);
            $parse1['on_off'] = sprintf($Lang['__real-online-s_'], $real) .' / '. sprintf($Lang['__ofline-trade-s_'], $offline);
        }

        $parse1['online_gm_count'] = DAO::get()::Char()::getOnlineGMCount($server['id']);

        $fp = @fsockopen($server['gs_ip'], $server['gs_port'], $errno, $errstr, 0.1);
        if ($fp) {
            $gameonline = $imgonline;
        } else {
            $gameonline = $imgoffline;
        }

        $parse1['game_server_status'] = '<tr><td>' . $server['name'] . ':</td><td>' . $gameonline . '</td></tr>';
        $parse1['br'] = '<br />';
        $parse1['ID'] = $server['id'];
        $parse['gs_rows'] .=tpl::parse('blocks/stats_serverlist', $parse1);
    }
    $content.=tpl::parse('blocks/stats', $parse);
    html::update($page, $pars, $content);
} else {
    $content = html::get($page, $pars);
}
global $content;
