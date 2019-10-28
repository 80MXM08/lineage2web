<?php
define('WEB', true);
require_once ("include/core.php");
head($Lang['registration']);
if ($user->logged())
{
	msg($Lang['error'], $Lang['already_reg'], 'error');
	foot();
	die();
}
$ref = getVar('ref');
if ($_POST && isset($_POST['account']) && isset($_POST['password']))
{
	if (strtolower($_SESSION['captcha']) != strtolower(getVar('captcha')))
	{
		msg($Lang['error'], $Lang['code_incorrect'], 'error');
		foot();
		die();
	}

	$account = getVar('account');
	$password = getVar('password');
	$password2 = getVar('password2');
	$ip = getVar('REMOTE_ADDR');

	if (ereg("^([a-zA-Z0-9_-])*$", $account) && ereg("^([a-zA-Z0-9_-])*$", $password) && ereg("^([a-zA-Z0-9_-])*$", $password2))
	{
		if (strlen($account) < 16 && strlen($account) > 4 && strlen($password) < 16 && strlen($password) > 4 && $password == $password2)
		{
			$check = $sql[1]->query(101, array('login' => $account));
			if (SQL::numRows())
			{
				msg($Lang['error'], $Lang['already_exists'], 'error');
				foot();
				die();
			}
			else
			{
				if ($user->regUser($account, $password, $ref))
				{
					msg($Lang['success'], $Lang['success_logged']);
				}
				else
				{
					msg($Lang['success'], $Lang['success_failed']);
				}
				foot();
				die();
			}
		}
		else
		{
			msg($Lang['error'], $Lang['too_short'], 'error');
			foot();
			die();
		}
	}
	else
	{
		msg($Lang['error'], $Lang['invalid_chars'], 'error');
		foot();
		die();
	}
}

$par['lang'] = selectedLang();

$params = implode(';', $par);
if ($cache->needUpdate('reg', $params))
{

	$parse = null;
	$parse['ref'] = $ref;
	$parse['button'] = button('reg_me', 'Submit', 1);
	$content = $tpl->parsetemplate('reg', $parse, 1);
	$cache->updateCache('reg', $content, $params);

	echo $content;
}
else
{
	echo $cache->getCache('reg', $params);
}
foot();
?>         