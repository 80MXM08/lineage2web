<?php

if (!defined('CORE')) {
    header('Location: ../index.php');
    exit();
}
$page = 'bDonate';
$pars = null;
if (html::check($page, $pars)) {
    $content = tpl::parse('blocks/donate', null, true);
    html::update($page, $pars, $content);
} else {
    $content = html::get($page, $pars);
}
global $content;
