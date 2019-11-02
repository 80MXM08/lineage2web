<?php
if (!defined('CORE'))
{
    die();
}

class User
{
    private static $cookie = 'l2web';

    public static function init()
    {
	if (isset($_SESSION['logged']) && $_SESSION['logged'])
	{
	    User::setSession(User::checkSession(), false, false);
	}
	elseif (isset($_COOKIE[User::$cookie]))
	{
	    User::setSession(User::checkCookie(), false, false);
	}
	else
	{
	    User::initSession();
	}
    }

    private static function setSession($data, $remember = false, $save = true)
    {
	if (!$data)
	{
	    return false;
	}
	$_SESSION['account']	 = $data['login']; //strtolower($data['login']);
	$_SESSION['logged']	 = true;
	$_SESSION['access']	 = $data['accessLevel'];
	$_SESSION['new_pm']	 = DAO::get()::Messages()::getUnreadCount();
	$_SESSION['sent_pm']	 = DAO::get()::Messages()::getSentCount();
	$_SESSION['rec_pm']	 = DAO::get()::Messages()::getReceivedCount();
	$_SESSION['web_points']	 = 0;
	$_SESSION['vote_time']	 = 0;
	$_SESSION['lang']	 = 'en';
	$_SESSION['theme']	 = 'default';
	User::getVars();
	if ($remember)
	{
	    User::updateCookie($data['password'], true);
	}
	if ($save)
	{
	    $cookie = (isset($_SESSION['cookie'])) ? $_SESSION['cookie'] : '';
	    DAO::get()::Account()::updateSessionCookie(User::getUser(), session_id(), $cookie, USER_IP);
	}
	return true;
    }

    private static function checkSession()
    {
	return DAO::get()::Account()::checkBySession(session_id(), USER_IP);
    }

    private static function checkCookie()
    {
	list($login, $cookie) = unserialize(getCookie(User::$cookie));
	if (!$login || !$cookie)
	{
	    return false;
	}

	return DAO::get()::Account()::checkByCookie($login, $cookie, USER_IP);
    }

    private static function initSession()
    {
	$_SESSION['account']	 = null;
	$_SESSION['vote_time']	 = 0;
	$_SESSION['web_points']	 = 0;
	$_SESSION['logged']	 = false;
	$_SESSION['access']	 = -1;
    }

    static function checkLogin($username, $password, $remember)
    {
	return User::setSession(DAO::get()::Account()::check($username, User::encryptPass($password)), $remember, true);
	;
    }

    private static function setVars($vars = [])
    {
	foreach ($vars as $var => $val)
	{
	    User::setVar($var, $val, true);
	}
    }

    private static function updateCookie($pass)
    {
	$_SESSION['cookie']	 = User::encryptPass($pass . rand(15124, 15636235));
	$cookie			 = serialize([User::getUser(), $_SESSION['cookie']]);
	setcookie(User::$cookie, $cookie, time() + 31104000, '', '');
    }

    public static function isAdmin()
    {
	return User::isLogged() && $_SESSION['access'] > 1;
    }

    public static function isMod()
    {
	return User::isLogged() && $_SESSION['access'] > 0;
    }

    public static function isLogged()
    {
	return isset($_SESSION['logged']) && $_SESSION['logged'] === true && $_SESSION['account'] != '';
    }

    public static function doLogout()
    {
	$_SESSION['account']	 = null;
	$_SESSION['vote_time']	 = 0;
	$_SESSION['web_points']	 = 0;
	$_SESSION['access']	 = -1;
	$_SESSION['logged']	 = false;
	$_SESSION['cookie']	 = null;
	setcookie('l2web', '', 0, '', '');
	return !isset($_SESSION['account']);
    }

    public static function printDebug()
    {
	return print_r($_SESSION, true);
    }

    private static function encryptPass($password)
    {
	return base64_encode(pack('H*', sha1(fString($password))));
    }

    public static function regUser($acc, $pass)
    {
	$login = fString($acc);
	DAO::get()::Account()::insert($login, User::encryptPass($pass), USER_IP);
	return User::checkLogin($login, $pass, 0);
    }

    public static function changePass($acc, $old, $pass, $pass2)
    {
	global $Lang;

	if (ereg("^([a-zA-Z0-9_-])*$", $old) && ereg("^([a-zA-Z0-9_-])*$", $pass) && ereg("^([a-zA-Z0-9_-])*$", $pass2))
	{

	    if ($pass == $pass2)
	    {
		return DAO::get()::Account()::changePass($acc, $old, User::encryptPass($pass));
	    }
	    else
	    {
		return msg($Lang['__error_'], $Lang['__passwords-no-match_'], 'error');
	    }
	}
	else
	{
	    return msg($Lang['__error_'], $Lang['__incorrect-chars_'], 'error');
	}
    }

    public static function setUser($acc)
    {
	$_SESSION['account'] = $acc;
    }

    public static function getUser()
    {
	return isset($_SESSION['account']) ? $_SESSION['account'] : null;
    }

    public static function getAccess()
    {
	return isset($_SESSION['access']) ? $_SESSION['access'] : -1;
    }

    public static function setVar($var, $val, $update = false)
    {
	//global $sql;
	switch ($var)
	{
	    case 'lang':
		return User::setLang($val, $update);
	    case 'theme':
		//echo die('theme - '.$val);
		return User::setTheme($val, $update);
	    default:
		$_SESSION[$var] = $val;
		if ($update)
		{
		    DAO::get()::AccountData()::set($var, $val);
		    //$sql[ls]->query('UPDATE_ACC_VAR', [$var, $val, User::getUser()]);
		}
		//echo $var . ' - ' . $val . '<br />';
		//print_r($_SESSION);
		return true;
	}
    }

    public static function getVar($var)
    {
	if (isset($_SESSION[$var]))
	{
	    return $_SESSION[$var];
	}
	else
	{
	    User::setVar($var, '', true);
	    return User::getVar($var);
	}
    }

    private static function setTheme($theme)
    {
	if (!User::isTheme($theme))
	{
	    $theme = Conf::get('web', 'default_theme');
	}
	$_SESSION['theme'] = $theme;
	return $_SESSION['theme'];
    }
    public static function getTheme()
    {
	if (!User::isTheme($_SESSION['theme']))
	{
	    $_SESSION['theme'] = Conf::get('web', 'default_theme');
	}
	return $_SESSION['theme'];
    }
    private static function setLang($lang)
    {
	if (!User::isLang($lang))
	{
	    $lang = Conf::get('web', 'default_lang');
	}
	$_SESSION['lang'] = $lang;
	return $_SESSION['lang'];
    }

    private static function getVars()
    {
	DAO::get()::AccountData()::get();
    }

    public static function isLang($lng)
    {
	return file_exists('core/lang/' . $lng . '.php') && file_exists('lang/' . $lng . '.png');
    }

    public static function getLangs()
    {
	$handle		 = opendir('core/lang');
	$langlist	 = array();
	while ($file		 = readdir($handle))
	{
	    $f = explode('.', $file);
	    if ($f[0] != '.' && $f[0] != '..' && User::isLang($f[0]) && !in_array($f[0], $langlist))
	    {
		array_push($langlist, $f[0]);
	    }
	}
	closedir($handle);
	sort($langlist);
	return $langlist;
    }

    private static function langImgSelector($langs, $cur_lang)
    {
	$c = '';
	foreach ($langs as $lng)
	{
	    //TODO make tpl?
	    $c .= '<a href="actions.php?a=vars&var=lang&val=' . $lng . '"><img src="lang/' . $lng . '.png" alt="' . $lng . '" class="' . ($cur_lang == $lng ? 'img_border' : '') . '" width="32" height="32" /></a>';
	}
	return $c;
    }

    private static function langSelect($langs, $cur_lang)
    {
	$c = '<select name="lang" onchange="window.location=\'actions.php?a=vars&var=lang&val=\'+this.options[this.selectedIndex].value">';
	foreach ($langs as $lng)
	{
	    //TODO make tpl?
	    $c .= '<option value="' . $lng . '"' . ($lng == $cur_lang ? ' selected="selected"' : '') . '>' . $lng . '</option>';
	}
	$c .= '</select>';
	return $c;
    }

    public static function langSelector($img = false)
    {
	$langs = User::getLangs();
	if (count($langs) < 2)
	{
	    return '';
	}
	return $img ? User::langImgSelector($langs, User::getVar('lang')) : User::langSelect($langs, User::getVar('lang'));
    }

    private static function isTheme($theme)
    {
	return file_exists('themes/' . $theme . '/head.php') && file_exists('themes/' . $theme . '/foot.php');
    }

    public static function getThemes()
    {
	$handle		 = opendir('themes');
	$themelist	 = array();
	while ($file		 = readdir($handle))
	{
	    if ($file != '.' && $file != '..' && User::isTheme($file))
	    {
		$themelist[] = $file;
	    }
	}
	closedir($handle);
	sort($themelist);
	return $themelist;
    }

    public static function themeSelector($onChange = false)
    {
	$themes = User::getThemes();
	if (count($themes) < 2)
	{
	    return;
	}

	$sel_theme	 = User::getVar('theme');
	$c		 = '<select name="theme"' . ($onChange ? ' onchange="window.location=\'actions.php?a=vars&var=theme&val=\'+this.options[this.selectedIndex].value"' : '') . '>\n';
	foreach ($themes as $theme)
	{
	    $c .= '<option value="' . $theme . '"' . ($theme == $sel_theme ? ' selected="selected"' : '') . '>' . $theme . '</option>\n';
	}
	$c .= '</select>';
	return $c;
    }
}