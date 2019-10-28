<?php
define('L2WEB', true);
require_once ('core/core.php');
require_once ('core/class.news.php');
head($Lang['__home_']);

$par['lang']	 = User::getVar('lang');
$par['mod']	 = User::isMod() == true ? 'true' : 'false';
$pars		 = implode(';', $par);
$page		 = 'index';
$content ='';
if (html::check($page, $pars))
{

    $parse['gsrows'] = '';
    if (Conf::get('server', 'info_in_index'))
    {
	foreach ($GS as $gsrow)
	{
	    $parse['gsrows'] .= tpl::parse('index_gsrow', $gsrow);
	}
	$content .= tpl::parse('index2', $parse);
    }
    
    if (Conf::get('news', 'enabled'))
    {
	$content .= news::viewAll();
    }
    
    html::update($page, $pars, $content);

    echo $content;
}
else
{
    echo html::get($page, $pars);
}
foot();
