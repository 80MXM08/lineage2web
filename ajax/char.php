<?php
define('INWEB', true);
chdir('..');
require_once ("include/config.php");
loggedInOrReturn();
$q = getVar('q');
$server = getVar('server');
$limit = getVar('limit');

if(!empty($q) && !empty($limit) && !empty($server))
{
	$query = '%' . strtr($q, ' ', '%') . '%';
	$db = getDBInfo($server);
	$sql->query(221, array(
		'db' => $db['database'],
		'name' => $query,
		'limit' => $limit));
	$data = $sql->fetchArray();
}

echo json_encode($data);
?>