<?php

define('L2WEB', true);
require_once ('include/core.php');

if (User::logged()) {
    head();
    msg($Lang['error'], $Lang['already_reg'], 'error');
    foot();
    die();
}
$ref = getString('ref');
if ($_POST && isset($_POST['account']) && isset($_POST['password'])) {
    if (strtolower($_SESSION['captcha']) != strtolower(postString('captcha'))) {
        head('', 0, 'index.php', 3);
        msg($Lang['error'], $Lang['code_incorrect'], 'error');
        foot(0);
    }

    $account = postString('account');
    $password = postString('password');
    $password2 = postString('password2');
    $ip = $_SERVER['REMOTE_ADDR'];
    if (preg_match("/^([a-zA-Z0-9_-])*$/", $account) && preg_match("/^([a-zA-Z0-9_-])*$/", $password) && preg_match("/^([a-zA-Z0-9_-])*$/", $password2)) {
        if (strlen($account) < 16 && strlen($account) > 4 && strlen($password) < 16 && strlen($password) > 4 && $password == $password2) {
            $check = $sql['ls']->query('CHECK_EXISTS', [$account]);
            if ($check->rowCount()) {
                head('', 0, 'index.php', 3);
                msg($Lang['error'], $Lang['already_exists'], 'error');
                foot(0);
            } else {
                head('', 0, 'index.php', 3);
                if (User::regUser($account, $password, $ref)) {
                    msg($Lang['success'], $Lang['success_logged']);
                } else {
                    msg($Lang['success'], $Lang['success_failed']);
                }
                foot(0);
            }
        } else {
            head('', 0, 'index.php', 3);
            msg($Lang['error'], $Lang['too_short'], 'error');
            foot(0);
        }
    } else {
        head('', 0, 'index.php', 3);
        msg($Lang['error'], $Lang['invalid_chars'], 'error');
        foot(0);
    }
} else {
    head($Lang['registration']);
    $par['lang'] = User::getVar('lang');

    $params = implode(';', $par);
    if (html::check('reg', $params)) {

        $parse = null;
        $parse['ref'] = $ref;
        $parse['button'] = button('reg_me');
        $content = tpl::parse('reg', $parse, 1);
        html::update('reg', $params, $content);

        echo $content;
    } else {
        echo html::get('reg', $params);
    }
    foot();
}
       