<?php
if (!defined('DAO')) {
    header('Location: index.php');
    die();
}
class L2WGameServerMySQLImpl implements iL2WGameServer {

    private static $GET = 'SELECT * FROM gameservers';

    static function get() {
        global $sql, $GS;
        foreach ($sql['core']->query(L2WGameServerMySQLImpl::$GET, [], __METHOD__) as $G) {
            array_push($GS, $G);
        }
    }

}

class L2WHennaMySQLImpl implements iL2WHenna {

    private static $GET = 'SELECT * FROM henna_h5 WHERE id=?';
    private static $GET_ALL = 'SELECT * FROM henna_h5';

    static function get($id) {
        global $sql;
        $r = $sql['core']->query(L2WHennaMySQLImpl::$GET, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getAll() {
        global $sql;
        $r = $sql['core']->query(L2WHennaMySQLImpl::$GET_ALL, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}

class L2WItemMySQLImpl implements iL2WItem {

    private static $GET_ITEM = 'SELECT * FROM itemname_h5 WHERE id=?';
    private static $GET_ITEM_NAME = 'SELECT name FROM itemname_h5 WHERE id=?';
    private static $GET_ARMOR = 'SELECT * FROM armorgrp_h5 WHERE id=?';
    private static $GET_WEAPON = 'SELECT * FROM weapongrp_h5 WHERE id=?';
    private static $GET_AUGMENT = 'SELECT * FROM optiondata_h5 WHERE id=?';
    private static $GET_WEBSHOP = 'SELECT * FROM webshop WHERE objectId=?';

    static function getItem($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_ITEM, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getItemName($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_ITEM_NAME, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC)['name'] : false;
    }

    static function getArmor($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_ARMOR, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getWeapon($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_WEAPON, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getAugment($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_AUGMENT, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getWebshop($id) {
        global $sql;
        $r = $sql['core']->query(L2WItemMySQLImpl::$GET_WEBSHOP, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

}
class L2WSkillsMySQLImpl implements iL2WSkills {

    private static $GET = 'SELECT * FROM skills_h5 WHERE id=? AND level=?';

    static function get($id, $lvl) {
        global $sql;
        $r = $sql['core']->query(L2WSkillsMySQLImpl::$GET, [$id, $lvl], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

}

class LogMySQLImpl implements iLog {

    private static $GET_ALL = 'SELECT * FROM logs';
    private static $GET = 'SELECT * FROM logs WHERE account=?';
    private static $ADD = 'INSERT INTO logs (account, type, subType, comment) VALUES (?, ?, ?, ?)';
    private static $DELETE_BY_ID = 'DELETE FROM logs WHERE id=?';
    private static $DELETE_BY_IP_AND_TYPE = 'DELETE FROM logs WHERE account=? AND type=?';

    static function getAll() {
        global $sql;
        $r = $sql['core']->query(LogMySQLImpl::$GET_ALL, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function get($acc) {
        global $sql;
        $r = $sql['core']->query(LogMySQLImpl::$GET, [$acc], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function add($acc, $type, $subType, $comment) {
        global $sql;
        return $sql['core']->query(LogMySQLImpl::$ADD, [$acc, $type, $subType, $comment], __METHOD__);
    }

    static function delete($id) {
        global $sql;
        return $sql['core']->query(LogMySQLImpl::$DELETE_BY_ID, [$id], __METHOD__);
    }

    static function deleteByIPAndType($ip, $type) {
        global $sql;
        return $sql['core']->query(LogMySQLImpl::$DELETE_BY_IP_AND_TYPE, [$ip, $type], __METHOD__);
    }

}

class BanMySQLImpl implements iBan {

    private static $GET_ALL = 'SELECT * FROM bans';
    private static $GET = 'SELECT *, UNIX_TIMESTAMP(`time_from`) as `from`, UNIX_TIMESTAMP(`time_to`) as `to` FROM bans WHERE ip=?';
    private static $ADD = 'INSERT INTO bans (ip, added_by, comment, time_to) VALUES (?, ?, ?, FROM_UNIXTIME(?))';
    private static $UPDATE = 'UPDATE bans SET comment=?, time_to=FROM_UNIX_TIME(?) WHERE ip=?';
    private static $DELETE = 'DELETE FROM bans WHERE ip=?';

    static function getAll() {
        global $sql;
        $r = $sql['core']->query(BanMySQLImpl::$GET_ALL, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function get($ip) {
        global $sql;
        $r = $sql['core']->query(BanMySQLImpl::$GET, [$ip], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function add($ip, $added_by, $comment, $time) {
        global $sql;
        return $sql['core']->query(BanMySQLImpl::$ADD, [$ip, $added_by, $comment, $time], __METHOD__);
    }

    static function update($ip, $time, $comment) {
        global $sql;
        return $sql['core']->query(BanMySQLImpl::$UPDATE, [$comment, $time, $ip], __METHOD__);
    }

    static function delete($ip) {
        global $sql;
        return $sql['core']->query(BanMySQLImpl::$DELETE, [$ip], __METHOD__);
    }

}

class BlockMySQLImpl implements iBlock {

    private static $GET = 'SELECT * FROM blocks ORDER BY align ASC, position ASC';

    static function get() {
        global $sql;
        foreach ($sql['core']->query(BlockMySQLImpl::$GET, [], __METHOD__) as $r) {
            Block::add($r);
        }
    }

}

class CacheMySQLImpl implements iCache {

    private static $GET = 'SELECT * FROM cache';
    private static $ADD = 'INSERT INTO cache (id, page) VALUES (?, ?)';
    private static $UPDATE = 'UPDATE cache SET time=?, recache=? WHERE id=?';
    private static $RECACHE = 'UPDATE cache SET recache=1 WHERE page=?';

    static function reCache($page) {
        global $sql;

        return $sql['core']->query(CacheMySQLImpl::$RECACHE, [$page], __METHOD__) ? true : false;
    }

    static function get() {
        global $sql;
        foreach ($sql['core']->query(CacheMySQLImpl::$GET, [], __METHOD__) as $r) {
            html::add($r['id'], $r['time'], $r['recache']);
        }
    }

    static function add($id, $page) {
        global $sql;
        return $sql['core']->query(CacheMySQLImpl::$ADD, [$id, $page], __METHOD__);
    }

    static function update($id, $time) {
        global $sql;
        return $sql['core']->query(CacheMySQLImpl::$UPDATE, [$time, 0, $id], __METHOD__);
    }

}

class ConfigMySQLImpl implements iConfig {

    static private $GET = 'SELECT * FROM config WHERE name=? AND type=?';
    static private $GET_ALL = 'SELECT name, config_type.type, value, config.type as tid FROM config , config_type WHERE config.type = id';
    static private $GET_TYPES = 'SELECT * FROM config_type';
    static private $ADD = 'INSERT INTO config (name, type, value) VALUES (?, ?, ?)';
    static private $UPDATE = 'UPDATE config SET value=? WHERE name=? AND type=? LIMIT 1';

    static function getTypes() {
        global $sql;
        /* foreach ($sql['core']->query(ConfigMySQLImpl::$GET_TYPES, [], __METHOD__) as $r) {
          Conf::addType($r['id'], $r['type']);
          } */

        $r = $sql['core']->query(ConfigMySQLImpl::$GET_TYPES, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getAll() {
        global $sql;
        /* foreach ($sql['core']->query(ConfigMySQLImpl::$GET_ALL, [], __METHOD__) as $r) {
          Conf::add($r['type'], $r['name'], $r['value']);
          } */
        $r = $sql['core']->query(ConfigMySQLImpl::$GET_ALL, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function get($typeId, $name) {
        global $sql;
        return $sql['core']->query(ConfigMySQLImpl::$GET, [$name, $typeId], __METHOD__);
    }

    static function update($typeId, $name, $value) {
        global $sql;
        return $sql['core']->query(ConfigMySQLImpl::$UPDATE, [$value, $name, $typeId], __METHOD__);
    }

    static function add($typeId, $name, $value) {
        global $sql;
        return $sql['core']->query(ConfigMySQLImpl::$ADD, [$name, $typeId, $value], __METHOD__);
    }

    static function set($type, $name, $val) {
        $r = DAO::getInstance()::getConfig()::get($type, $name);
        if ($r->rowCount()) {
            DAO::getInstance()::getConfig()::update($type, $name, $val);
        } else {
            DAO::getInstance()::getConfig()::add($type, $name, $val);
        }
    }

}
class MessagesMySQLImpl implements iMessages {

    static $GET_UNREAD = 'SELECT * FROM messages WHERE receiver=? AND unread=?';
    static $GET_UNREAD_COUNT = 'SELECT count(*) as count FROM messages WHERE receiver=? AND unread=?';
    static $GET_SENT = 'SELECT * FROM messages WHERE sender=?';
    static $GET_SENT_COUNT = 'SELECT count(*) as count FROM messages WHERE sender=?';
    static $GET_RECEIVED = 'SELECT * FROM messages WHERE receiver=?';
    static $GET_RECEIVED_COUNT = 'SELECT count(*) as count FROM messages WHERE receiver=?';

    static function getUnread() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_UNREAD, [User::getUser(), 1], __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getUnreadCount() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_UNREAD_COUNT, [User::getUser(), 1], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getSent() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_SENT, [User::getUser()], __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getSentCount() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_SENT_COUNT, [User::getUser()], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getReceived() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_RECEIVED, [User::getUser()], __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getReceivedCount() {
        global $sql;
        return $sql['core']->query(MessagesMySQLImpl::$GET_RECEIVED_COUNT, [User::getUser()], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

}


class NewsMySQLImpl implements iNews {

    static $GET_ALL = 'SELECT * FROM news ORDER BY date DESC LIMIT :limit';
    static $GET = 'SELECT * FROM news WHERE id=?';
    static $DELETE = 'DELETE FROM news WHERE id=?';
    static $UPDATE = 'UPDATE news SET name=:name:, desc=:desc, editTime=?, editBy=? WHERE id=?';
    static $ADD = 'INSERT INTO news (name, date, author, desc, image) VALUES (?, ?, ?, ?, ?)';

    static function getAll() {
        global $sql;
        $r = $sql['core']->query(NewsMySQLImpl::$GET_ALL, [[':limit', (int) Conf::get('news', 'news_in_index'), PDO::PARAM_INT]], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function get($id) {
        global $sql;
        $r = $sql['core']->query(NewsMySQLImpl::$GET, $id, __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}



class LangMySQLImpl implements iLang {

    private static $INSERT = 'INSERT INTO lang  VALUES (?, ?, ?)';
    private static $GET_ALL = 'SELECT * FROM lang WHERE lang=?';
    private static $GET = 'SELECT * FROM lang WHERE lang=? AND `key`=?';
    private static $UPDATE = 'UPDATE lang SET `value`=? WHERE lang=? AND `key`=?';
    private static $UPDATE_KEY = 'UPDATE lang SET `key`=?, `value`=? WHERE lang=? AND `key`=?';

    static function getAll($lng) {
        global $sql;
        return $sql['core']->query(LangMySQLImpl::$GET_ALL, $lng, __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function get($lng, $id) {
        global $sql;
        return $sql['core']->query(LangMySQLImpl::$GET, [$lng, $id], __METHOD__)->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    static function insert($lng, $key, $value) {
        global $sql;
        return $sql['core']->query(LangMySQLImpl::$INSERT, [$lng, $key, $value], __METHOD__)->rowCount();
    }

    static function update($lng, $key, $value) {
        global $sql;
        return $sql['core']->query(LangMySQLImpl::$UPDATE, [$value, $lng, $key], __METHOD__)->rowCount();
    }

    static function updateKey($lng, $key, $newKey, $value) {
        global $sql;
        return $sql['core']->query(LangMySQLImpl::$UPDATE_KEY, [$newKey, $value, $lng, $key], __METHOD__)->rowCount();
    }

}