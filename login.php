<?php
//пароль
define('L2WEB', True);
require_once("include/core.php");

if ($_POST && !$user->logged()) {
    if (isset($_POST['account']) && isset($_POST['password'])) {
        $account= filter_input(INPUT_POST, 'account');
        $pass=filter_input(INPUT_POST, 'password');
        $remember = filter_input(INPUT_POST, 'remember');
        ($remember === true || $remember==='true' || $remember==='on' || $remember==='1' ) ? $remember=true : $remember=false;
        if($user->checkLogin($account, $pass, $remember))
        {
            //head();
            head($Lang['login'],1,isset($_SESSION['returnto'])?$_SESSION['returnto']:'index.php',3);
            msg($Lang['success'], $Lang['success_login']);
            foot();

        }else{
            head($Lang['login'],1,'login.php',3);
            msg($Lang['error'], $Lang['failed_login'], 'error');
            foot();
        }
    }
}else{
    if(!$user->logged()){
        head($Lang['login']);
        $parse=$Lang;
        $parse['login_b']=button('login');
        TplParser::parse('login',$parse);
        
    }else{
        header ("Refresh: 3; url=index.php");
    }
foot();
}
?>