<?php
if (!defined('CORE'))
{
    header("Location: ../index.php");
    exit();
}
$page	 = 'bTop10';
$pars	 = null;
if (html::check($page, $pars))
{
    $parse = null;
    foreach ($GS as $slist)
    {
	$parse['server_name']	 = $slist['name'];
	$parse['rows']		 = '';
	$n			 = 1;

	foreach (DAO::get()::Char()::getTOPChars($slist['id']) as $r)
	{
	    $parse1=null;
	    $parse1['nr']		 = $n++;
	    $parse1['charId']		 = $r['charId'];
	    $parse1['sex']		 = ($r['sex'] == 0) ? 'male' : 'female';
	    $parse1['char_name']	 = $r['char_name'];
	    $parse1['serv_id']		 = $slist['id'];
	    $parse['rows']		 .= tpl::parse('blocks/top10_row', $parse1);
	}
    }
    $content = tpl::parse('blocks/top10', $parse);
    html::update($page, $pars, $content);
}
else
{
    $content = html::get($page, $pars);
}
global $content;
