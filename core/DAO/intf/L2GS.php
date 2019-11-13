<?php

if (!defined('DAO')) {
    header('Location: index.php');
    die();
}

interface iAugment {

    static function get($srv, $id);
}

interface iCastle {

    static function get($id);

    static function getClanAlly($id);

    static function getClanAllyTerritory($id);
}

interface iCastleSiege {

    static function get($id, $castle, $type);
}

interface iChar {

    static function getCharAndClanData($sId, $id);

    static function getOtherChars($sId, $id, $name);

    static function getCount($id);

    static function getCountByRace($id, $race);

    static function getCountBySex($id, $sex);

    static function getOnlineTradeCount($id);

    static function getOnlineCount($id, $online);

    static function getOnlineLimited($id, $online, $start, $count);

    static function getOnlineGMCount($id);

    static function getTOPChars($id);

    static function getSubclassesNotCurrent($id, $cId, $classid);

    static function getSubclasses($id, $cId);
}

interface iClan {

    static function getCount($id);
}

interface iSevenSigns {
    
}

interface iTerritoryWar {
    
}

interface iFort {
    
}

interface iFortSiege {
    
}

interface iItem {
    
}

interface iSkills {
    
}

interface iElement {

    static function get($srv, $id);
}

interface iHenna {
    
}
