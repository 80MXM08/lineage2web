<?php

if (!defined('CORE')) {
    header("Location: ../index.php");
    exit();
}

$par['lang'] = User::getVar('lang');
$par['theme']= User::getVar('theme');
$pars = implode(';', $par);
$page = 'bMenu';
if (html::check($page, $pars)) {
    $parse = null;
    $parse['home'] = menuButton('home');
    $parse['reg']=User::isLogged()?'': menuButton('reg');
    $parse['connect'] = menuButton('connect');
    $parse['market'] = menuButton('market');
    $parse['forum'] = menuButton('forum');
    $parse['statistic'] = menuButton('statistic');
    $parse['rules'] = menuButton('rules');
    $parse['donate'] = menuButton('donate');
    $parse['theme'] = User::themeSelector(true);
    $parse['lang_list'] = User::langSelector(true);
    $content = tpl::parse('blocks/menu', $parse);
    html::update($page, $pars, $content);
} else {
    $content = html::get($page, $pars);
}
global $content;
