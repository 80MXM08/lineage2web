<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	exit();
}
$cachefile = 'blocks/donate';
if(Cache::check($cachefile))
{
	$content = TplParser::parse('blocks/donate', $Lang, true);
	Cache::update($content);
	global $content;
}
else
{
	$content = Cache::get();
	global $content;
}
?>