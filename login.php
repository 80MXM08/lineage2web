<?php
define('L2WEB', True);
require_once("include/core.php");

if ($_POST && isset($_POST['account']) && isset($_POST['password']))
{
    $account	 = filter_input(INPUT_POST, 'account');
    $pass		 = filter_input(INPUT_POST, 'password');
    $remember	 = filter_input(INPUT_POST, 'remember');
    $rmb		 = ($remember === true || $remember === 'true' || $remember === 'on' || $remember === '1' );
    if (User::checkLogin($account, $pass, $rmb))
    {
	head($Lang['__login_'], 1, isset($_SESSION['returnto']) ? $_SESSION['returnto'] : 'index.php', 3);
	echo msg($Lang['__success_'], $Lang['__success-login_']);
	foot();
    }
    else
    {
	head($Lang['__login_'], 1, 'login.php', 3);
	echo msg($Lang['__error_'], $Lang['__failed-login_'], 'error');
	foot();
    }
}
else if (!User::isLogged())
{
    head($Lang['__login_']);
    $parse			 = $Lang;
    $parse['login_b']	 = button('login');
    echo tpl::parse('login', $parse);
    foot();
}
else
{
    header("Refresh: 3; url=index.php");
}