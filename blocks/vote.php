<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	exit();
}
$cachefile = 'blocks/vote';
if(Cache::check($cachefile))
{
	$content = TplParser::parse('blocks/vote', $Lang, true);
	Cache::update($content);
	global $content;
}
else
{
	$content = Cache::get();
	global $content;
}
?>