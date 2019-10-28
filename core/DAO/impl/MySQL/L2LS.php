<?php
if (!defined('DAO')) {
    die();
}
class AccountMySQLImpl implements iAccount {

    private static $TOTAL = 'SELECT count(*) as count FROM accounts';
    private static $CHECK = 'SELECT * FROM accounts WHERE login=? AND password=?';
    private static $CHECK_COOKIE = 'SELECT * FROM accounts WHERE login = ? AND cookie = ? AND lastIP = ?';
    private static $CHECK_SESSION = 'SELECT * FROM accounts WHERE login = ? AND session = ? AND lastIP = ?';
    private static $CHECK_NAME = 'SELECT * FROM accounts WHERE login=?';
    private static $GET = 'SELECT * FROM accounts WHERE login=?';
    private static $CHANGE_PASS = 'UPDATE accounts SET password=? WHERE login=?';
    private static $INSERT = 'INSERT INTO accounts (login, password, accessLevel, lastIP) VALUES (?, ?, 0, ?)';
    private static $UPDATE = 'UPDATE accounts SET cookie = ?, session = ?, lastIP = ? WHERE login = ?';
    private static $UPDATE_WP = 'UPDATE accounts SET webpoints=webpoints+? WHERE login=?';
    private static $UPDATE_WB_VOTE = 'UPDATE accounts SET voteTime=?, webpoints=webpoints+? WHERE login = ?';

    static function getTotal() {
        global $sql;
        return $sql['ls']->query(AccountMySQLImpl::$TOTAL, [], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function get($acc) {
        global $sql;
        $r = $sql['ls']->query(AccountMySQLImpl::$GET, [$acc], __METHOD__);

        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function check($name, $pass) {
        global $sql;
        $r = $sql['ls']->query(AccountMySQLImpl::$CHECK, [$name, $pass], __METHOD__);

        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function checkByCookie($login, $cookie, $ip) {
        global $sql;

        $r = $sql['ls']->query(AccountMySQLImpl::$CHECK_COOKIE, [$login, $cookie, $ip], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function checkBySession($session, $ip) {
        global $sql;

        $r = $sql['ls']->query(AccountMySQLImpl::$CHECK_SESSION, [User::getUser(), $session, $ip], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function checkNameExists($name) {
        global $sql;

        $r = $sql['ls']->query(AccountMySQLImpl::$CHECK_NAME, [$name], __METHOD__);
        return $r->rowCount();
    }

    static function updateSessionCookie($login, $session, $cookie, $ip) {
        global $sql;

        $r = $sql['ls']->query(AccountMySQLImpl::$UPDATE, [$cookie, $session, $ip, $login], __METHOD__);
        return $r->rowCount();
    }

    static function changePass($acc, $old, $pass) {
        global $sql, $Lang;
        $r = $sql['ls']->query(AccountMySQLImpl::$CHECK, [$acc, $old], __METHOD__);
        if ($r->rowCount()) {
            $sql['ls']->query(AccountMySQLImpl::$CHANGE_PASS, [$pass, $acc], __METHOD__);
            return msg($Lang['_success'], $Lang['_password_changed']);
            // TODO:: return true/ false move lang
        } else {
            return msg($Lang['_error'], $Lang['_old_password_incorrect'], 'error');
        }
    }

    static function insert($acc, $pass, $ip) {
        global $sql;
        $sql['ls']->query(AccountMySQLImpl::$INSERT, [$acc, $pass, $ip], __METHOD__);
    }

}

class AccountDataMySQLImpl implements iAccountData {

    private static $UPDATE = 'UPDATE account_data SET value = ? WHERE account_name = ? AND var=?';
    private static $GET = 'SELECT var, value FROM account_data WHERE account_name=?';
    private static $CHECK = 'SELECT * FROM account_data WHERE account_name=? AND var=?';
    private static $INSERT = 'INSERT INTO account_data VALUES (?, ?, ?)';

    static function get() {
        global $sql;
        foreach ($sql['ls']->query(AccountDataMySQLImpl::$GET, [User::getUser()], __METHOD__) as $r) {
            User::setVar($r['var'], $r['value']);
        }
    }

    static function check($var) {
        global $sql;

        return $sql['ls']->query(AccountDataMySQLImpl::$CHECK, [User::getUser(), $var], __METHOD__);
    }

    static function set($var, $val) {
        if (AccountDataMySQLImpl::check($var)->rowCount()) {
            AccountDataMySQLImpl::update($var, $val);
        } else {
            AccountDataMySQLImpl::insert($var, $val);
        }
    }

    static function update($var, $val) {
        global $sql;
        $sql['ls']->query(AccountDataMySQLImpl::$UPDATE, [$val, User::getUser(), $var], __METHOD__);
    }

    static function insert($var, $val) {
        global $sql;
        $sql['ls']->query(AccountDataMySQLImpl::$INSERT, [User::getUser(), $var, $val], __METHOD__);
    }

}

