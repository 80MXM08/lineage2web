<?php

if (!defined('CORE')) {
    header("Location: ../index.php");
    exit();
}
$page = 'bVote';
$pars = null;
if (html::check($page, $pars)) {
    $content = tpl::parse('blocks/vote');
    html::update($page, $pars, $content);
} else {
    $content = html::get($page, $pars);
}
global $content;
