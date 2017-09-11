<?php
if (! defined('CORE'))
{
	header("Location: ../index.php");
    exit();
}
#TODO: move html to template?
$par['lang']=User::getVar('lang');
$par['mod']=User::isMod()==true?'true':'false';
$content = '';
$cachefile='bStats';
if(Cache::check($cachefile, implode(';', $par)))
{
    $parse = $Lang;
    $imgoffline = '<img src="img/status/offline.png" alt="' .$Lang['offline'] . '" title="' .$Lang['offline'] . '" />';
    $imgonline = '<img src="img/status/online.png" alt="' . $Lang['online'] . '" title="' .$Lang['online'] . '" />';
    if(Config::get('server', 'show_ls', '1'))
    {
	   $fp = @fsockopen(Config::get('server', 'ls_ip', '127.0.0.1'), Config::get('server', 'ls_port', '2106'), $errno, $errstr, 0.1);
           if ($fp) { $loginonline = $imgonline; }
           else { $loginonline = $imgoffline; }

	   $parse['login_server_status'] = '<tr><td>' . $Lang['login_server'] . ':</td><td>' . $loginonline . '</td></tr>';
    }

    if(Config::get('server', 'show_cs', '1'))
    {
	   $fp = @fsockopen(Config::get('server', 'cs_ip', '127.0.0.1'), Config::get('server', 'cs_port', ''), $errno, $errstr, 0.1);
           if ($fp) { $comunityonline = $imgonline; }
           else { $comunityonline = $imgoffline; }

	   $parse['community_server_status'] = '<tr><td>' . $Lang['community_server'] . ':</td><td>' . $comunityonline . '</td></tr>';
    }

    #Total accounts
    $parse['acc_count'] = $sql[1]->result($sql[1]->query('GET_ACC_COUNT'));
    $parse['gs_rows']='';

    foreach($GS as $server)
    {
	   $parse1 = $Lang;
	   $parse1['clan_count'] = $sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('CLAN_COUNT'));
	   $parse1['char_count'] = $sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('CHAR_COUNT'));
	   $parse1['online_count'] = $sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('ONLINE_COUNT'));
    
        if(User::isMod())
        {
            $real=$sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('ONLINE_COUNT1'));
            $offline=$sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('OFFLINE_TRADE_COUNT'));
            //FIX HERE
            $parse1['on_off'] = "Tip('$real / $offline', FONTCOLOR, '#FFFFFF',BGCOLOR, '#AAAA00', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold', WIDTH, 50, ABOVE, true)";
        }

        #GM Online
        $parse1['online_gm_count'] = $sql[SQL_NEXT_ID+$server['id']]->result($sql[SQL_NEXT_ID+$server['id']]->query('ONLINE_GM_COUNT'));

        $fp = @fsockopen($server['gs_ip'], $server['gs_port'], $errno, $errstr, 0.1);
        if ($fp) { $gameonline = $imgonline; }
        else { $gameonline = $imgoffline; }

        $parse1['game_server_status'] = '<tr><td>' . $server['name'] . ':</td><td>' . $gameonline . '</td></tr>';
        $parse1['br'] = '<br />';
        $parse1['ID'] = $server['id'];
        $parse['gs_rows'] .=TplParser::parse('blocks/stats_serverlist', $parse1, 1);
    }
    $content.=TplParser::parse('blocks/stats', $parse, 1);
    Cache::update($content);
    global $content;
}
else
{
    $content= Cache::get();
    global $content;
}
?>