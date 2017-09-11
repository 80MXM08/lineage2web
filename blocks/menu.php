<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	exit();
}

$par['lang'] = User::getVar('lang');
$cachefile = 'bMenu';
if(Cache::check($cachefile, implode(';', $par)))
{
	$parse = $Lang;
	$parse['home'] = menuButton('home');
	$parse['reg'] = menuButton('reg');
	$parse['connect'] = menuButton('connect');
	$parse['market'] = menuButton('market');
	$parse['forum'] = menuButton('forum');
	$parse['statistic'] = menuButton('statistic');
	$parse['rules'] = menuButton('rules');
	$parse['donate'] = menuButton('donate');
	$parse['theme'] = User::themeSelector(true);
        $parse['lang_list'] = User::langSelector(true);
	$content = TplParser::parse('blocks/menu', $parse, true);
	Cache::update($content);

	global $content;
}
else
{
	$content = Cache::get();
	global $content;
}
?>