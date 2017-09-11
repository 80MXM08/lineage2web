<?php
if(!defined('CORE'))
{
	header("Location: ../index.php");
	die();
}

class User
{
    public static function init()
    {
        if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['account']) && $_SESSION['account'] != '')
        {
            User::checkSession();
        }
        elseif (isset($_COOKIE['l2web']))
        {
            User::checkRemembered(filter_input(INPUT_COOKIE, 'l2web'));
        }
        else
        {
            User::initSession();
        }
    }
    private static function initSession()
    {
  	$_SESSION['account'] = '';
	$_SESSION['vote_time'] = 0;
	$_SESSION['webpoints'] = 0;
	$_SESSION['access'] = -1;
	$_SESSION['logged'] = false;
        //$_SESSION['lang'] = 'en';
        //$_SESSION['new'] = 0;
        //$_SESSION['debug_menu']=false;
    }
    public static function checkLogin($username, $password, $remember)
    {
        global $sql;
        $sql[1]->query('CHECK_LOGIN', array('name'=>$username, 'pass'=>User::encryptPass($password)));

        if(SQL::numRows())
        {
            User::setSession(SQL::fetchArray(), $remember);
            return true;
        }
        else
        {
            User::logout();
            return false;
        }
    }

    private static function setSession($values, $remember, $init = true)
    {
        global $sql;
        $_SESSION['account'] = strtolower($values['login']);
        $_SESSION['logged'] = true;
        $_SESSION['webpoints'] = $values['webpoints'];
        $_SESSION['vote_time'] = $values['voteTime'];
        //$_SESSION['theme'] = $values['theme'];
        $_SESSION['access'] = $values['accessLevel'];
        //$_SESSION['lang']=$values['lang'];
        if($remember)
        {
                User::updateCookie(User::encryptPass($values['login'] . $values['password'] . rand(15124, 15636235)), true);
        }
        if($init)
        {
            $session = session_id();
            $ip = \filter_input(\INPUT_SERVER, 'REMOTE_ADDR');
            $sql[1]->query('UPDATE_ACC_BY_LOGIN', array('cookie'=>$_SESSION['cookie'], 'session'=>$session, 'ip'=>$ip, 'login'=>$values['login']));
        }
    }

    private static function updateCookie($cookie, $save)
    {
        $_SESSION['cookie'] = $cookie;
        if($save)
        {
            $cookie = serialize(array($_SESSION['account'], $cookie));
            setcookie('l2web', $cookie, \time() + 31104000, '', '');
        }
    }

    private static function checkRemembered($cookie)
    {
        global $sql;
        list($username, $cookie) = unserialize($cookie);
        if(!$username || !$cookie)
        {
                return;
        }
        $result = $sql[1]->query('CHECK_LOGIN_COOKIE', array('login'=>$username, 'cookie'=>$cookie, 'ip'=>filter_input(INPUT_SERVER, 'REMOTE_ADDR')));
        if(SQL::numRows())
        {
            User::setSession(SQL::fetchArray($result), true);
            User::getVars();
        }
    }

    private static function checkSession()
    {
        global $sql;
        $result = $sql[1]->query('CHECK_LOGIN_SESSION', array('login'=>$_SESSION['account'], 'session'=>session_id(), 'ip'=>filter_input(INPUT_SERVER, 'REMOTE_ADDR')));
        if(SQL::numRows())
        {
            User::setSession(SQL::fetchArray($result), false, false);
            User::getVars();
        }
        else
        {
            User::logout();
        }
    }

    public static function isAdmin()
    {
        if(User::logged() && $_SESSION['access'] >= 8)
        {
            return true;
        }
        return false;
    }
    public static function isMod()
    {
        if(User::logged() && $_SESSION['access'] > 0)
        {
            return true;
        }
        return false;
    }
    public static function logged()
    {
        if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && $_SESSION['account'] != '')
        {
            return true;
        }
        return false;
    }
    public static function logout()
    {
        $_SESSION['account'] = '';
        //$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['vote_time'] = 0;
        $_SESSION['webpoints'] = 0;
        $_SESSION['access'] = -1;
        $_SESSION['logged'] = false;
        unset($_SESSION);
        setcookie('l2web', '', 0, '', '');
        if(isset($_SESSION['account']))
        {
            return false;
        }
        return true;
    }
    public static function loggedInOrReturn($url='')
    {
        global $Lang;
        if(!User::logged())
        {
            if($url) { $_SESSION['returnto']=$url; }
            head($Lang['error'], true, 'login.php',5);
            msg($Lang['error'], $Lang['need_to_login'],'error');
            foot();
            die();
        }
    }
    public static function debug()
    {
        return print_r($_SESSION, true);
    }
    private static function encryptPass($password)
    {
        return base64_encode(pack('H*', sha1(fString($password))));
    }

    public static function regUser($acc, $pass, $ref)
    {
            global $sql;

            $pass = User::encpass($pass);
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            if($ref != '')
            {
                    $checkref = $sql[1]->query(46, array('login'=>$ref));
                    if(SQL::numRows() && $sql[1]->result($checkref, 0, 'lastIP') != $ip)
                    {
                            $sql[1]->query(47, array('login'=>$ref, 'webpoints'=>Config::get('features', 'reg_reward', '5')));
                    }
            }
            $sql[1]->query(48, array('login'=>$acc, 'pass'=>$pass,'ip'=>$ip));
            if(User::checkLogin($acc, $pass, 0))
                    return true;
            else
                    return false;
    }

    public static function changePass($acc, $old, $pass, $pass2)
    {
            global $sql, $Lang;

            if(ereg("^([a-zA-Z0-9_-])*$", $old) && ereg("^([a-zA-Z0-9_-])*$", $pass) && ereg("^([a-zA-Z0-9_-])*$", $pass2))
            {

                    if($pass == $pass2)
                    {
                            $result = $sql[1]->query(49, array('login'=>$acc, 'pass'=>encodePass($old)));
                            if(SQL::numRows())
                            {
                                    $sql[1]->query(50, array('login'=>$acc, 'pass'=>encodePass($old)));
                                    msg($Lang['success'], $Lang['password_changed']);
                            }
                            else
                            {
                                    msg($Lang['error'], $Lang['old_password_incorrect'],'error');
                            }
                    }
                    else
                    {
                            msg($Lang['error'], $Lang['passwords_no_match'],'error');
                    }
            }
            else
            {
                    msg($Lang['error'], $Lang['incorrect_chars'], 'error');
            }
    }
    public static function getUser()
    {
        return isset($_SESSION['account'])?$_SESSION['account']:null;
    }
    public static function setVar($var,$val)
    {
        global $sql;
        switch($var)
        {
            case 'lang':
                if($val===null)
                {
                    $val=Config::get('settings', 'dlang', 'en');
                }
                User::setLang($val);
            break;
            case 'theme':
                if($val===null)
                {
                    $val=Config::get('settings', 'dtheme', 'default');
                }
                User::setTheme($val);
            break;
            case 'webpoints':
                $_SESSION[$var]=$val;
                $sql[1]->query("UPDATE accounts SET `$var`='$val' WHERE login='".User::getUser()."';");
            break;
            case 'debug_menu':
                $_SESSION['debug_menu']=false;
                break;
            default:
                $_SESSION[$var]=$val;
                echo $var.' - '. $val.'<br />';
                print_r($_SESSION);
                break;
        }

    }
    public static function getVar($var)
    {
        //if(!User::logged()) { return; }
        if(isset($_SESSION[$var]))
        {
            return $_SESSION[$var];
        }
        else
        {
            User::setVar($var, null);
            return User::getVar($var);
        }
    }

    private static function setTheme($theme)
    {
        if (!User::isTheme($theme)) { $theme=Config::get('settings','dtheme','default'); }
        $_SESSION['theme']=$theme;
        User::updateAccDataVar('theme', $theme);
    }
    private static function setLang($lang)
    {
  	if (!User::isLang($lang)) { $lang=Config::get('settings','dlang','en'); }
        $_SESSION['lang']=$lang;
        User::updateAccDataVar('lang', $lang);
    }
    private static function updateAccDataVar($var,$val)
    {
        if (!User::logged()) { return; }
        global $sql;
        $check=$sql[1]->query('CHECK_ACC_DATA_VAR', array('account' => User::getUser(), 'val' => $val, 'var' =>$var));
        if(SQL::numRows($check))
        {
            $sql[1]->query('UPDATE_ACC_DATA_VAR', array('account' => User::getUser(), 'val' => $val, 'var' =>$var));
        }
        else
        {
            $sql[1]->query('INSERT_ACC_DATA_VAR', array('account' => User::getUser(), 'val' => $val, 'var' =>$var));
        }
    }
    private static function getVars()
    {
        if (!User::logged()) { return; } //or get cookies?
        
        global $sql;
        $res=$sql[1]->query('GET_ACC_DATA_VARS', array('account'=>  User::getUser()));
        while($r=SQL::fetchArray($res))
        {
            $_SESSION[$r['var']]=$r['value'];
        }
    }
    public static function isLang($lng)
    {
	return file_exists('lang/'.$lng.'.php') && file_exists('lang/'.$lng.'.png');
    }
    public static function getLangs()
{
	$handle = opendir('lang');
	$langlist = array();
	while ($file = readdir($handle)) {
	   $f=explode('.', $file);
		if ($f[0] != '.' && $f[0] != '..' && User::isLang($f[0])) {
		  if(!in_array($f[0],$langlist))
                  {
		      array_push($langlist, $f[0]);
                  }
		}
	}
	closedir($handle);
	sort($langlist);
	return $langlist;
}
public static function langSelector($images = false)
{
	$langs = User::getLangs();
    $sel_lang=User::getVar('lang');
    if($images)
    {
        $cnt='';
        foreach($langs as $lng)
        {
            $border=$sel_lang==$lng?'img_border':'';
            $cnt.='<a href="actions.php?a=lng&amp;lang='.$lng.'"><img src="lang/'.$lng.'.png" alt="'.$lng.'" class="'.$border.'" width="32" height="32" /></a>';
        }
    }
    else
    {
    	$cnt = '<select name="lang" onchange="window.location=\'actions.php?a=lng&amp;lang=\'+this.options[this.selectedIndex].value">';
    	foreach ($langs as $lng)
        {
    		$cnt .= '<option value="'.$lng.'"'.($lng == $sel_lang ? ' selected="selected"' : '').'>'.$lng.'</option>';
        }
    	$cnt .= '</select>';
    }
	return $cnt;
}
private static function isTheme($theme) {
	return file_exists("themes/$theme/head.php") && file_exists("themes/$theme/foot.php");
}

public static function getThemes() {
	$handle = opendir("themes");
	$themelist = array();
	while ($file = readdir($handle)) {
		if ($file != "." && $file != ".." && User::isTheme($file)) {
			$themelist[] = $file;
		}
	}
	closedir($handle);
	sort($themelist);
	return $themelist;
}

public static function themeSelector($use_fsw = false) {
	$themes = User::getThemes();
        $sel_theme=User::getVar('theme');
	$content = "<select name=\"theme\"".($use_fsw ? " onchange=\"window.location='actions.php?a=theme%amp;theme='+this.options[this.selectedIndex].value\"" : "").">\n";
	foreach ($themes as $theme)
		$content .= "<option value=\"$theme\"".($theme == $sel_theme ? " selected=\"selected\"" : "").">$theme</option>\n";
	$content .= "</select>";
	return $content;
}
    /*
    public function hasAccess($s)
    {
        if($s==null || $s=='') return 1;
        else if(isset($this->access[$s]))
            return $this->access[$s];
        else
            return $this->createAccess($s);
    }
    public function getGroupName()
    {
        return $$this->array['name'];
    }
    public function getGroupId()
    {
        return $$this->array['id'];
    }
    public function createAccess($s)
    {
        global $sql;
        $s=$sql->escape($s);
        $this->access[$s]=0;
        
        $sql->query("ALTER TABLE `groups` ADD COLUMN `$s`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0;");
        msg('Warning', 'Access '.$s.' not defined. Creating now with default 0 value for all groups!', 'warning');
        return 0;
    }
*/
}
?>