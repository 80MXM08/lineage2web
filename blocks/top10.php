<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	exit();
}
$cachefile = 'blocks/top10';
if(Cache::check($cachefile))
{
	$content = '';
	foreach($GS as $slist)
	{
		$parse['server_name'] = $slist['name'];

		$topchar = $sql[SQL_NEXT_ID+$slist['id']]->query('TOP_CHAR_LIST', array("limit" => Config::get('settings', 'TOP', '10')));
		$n = 1;
		$parse['rows'] = '';
		while ($top = SQL::fetchArray())
		{
			$row_parse['nr'] = $n;
			$row_parse['charId'] = $top['charId'];
			$row_parse['sex'] = ($top['sex'] == 0) ? 'male' : 'female';
			$row_parse['char_name'] = $top['char_name'];
			$row_parse['serv_id'] = $slist['id'];
			$parse['rows'] .= TplParser::parse($cachefile . '_row', $row_parse, true);
			$n++;
		}

		$content .= TplParser::parse($cachefile, $parse, true);

	}
	Cache::update($content);
	global $content;
}
else
{
	$content = Cache::get();
	global $content;
}
?>