<?php
if (!defined('DAO')) {
    header('Location: index.php');
    die();
}
class AugmentMySQLImpl implements iAugment {

    private static $GET = 'SELECT * FROM item_attributes WHERE itemId=?';

    static function get($srv, $id) {
        global $sql;
        $r = $sql[$srv]->query(ItemAugmentMySQLImpl::$GET, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}
class CastleMySQLImpl implements iCastle {

    private static $GET = 'SELECT id, name, taxPercent, siegeDate, charId, char_name, clan_id, clan_name FROM castle LEFT OUTER JOIN clan_data ON clan_data.hasCastle=castle.id LEFT OUTER JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC;';
    private static $GET_CLAN_ALLY = 'SELECT id, taxPercent, siegeDate, clan_clan.clan_id, clan_clan.clan_name, clan_clan.leader_id AS clan_leader_id, clan_char.char_name AS clan_leader_name, ally_clan.clan_id AS ally_id, clan_clan.ally_name, ally_clan.leader_id AS ally_leader_id, ally_char.char_name AS ally_leader_name FROM castle LEFT JOIN clan_data clan_clan ON clan_clan.hasCastle = castle.id LEFT JOIN clan_data ally_clan ON ally_clan.clan_id=clan_clan.ally_id LEFT JOIN characters clan_char ON clan_char.charId=clan_clan.leader_id LEFT JOIN characters ally_char ON ally_clan.leader_id=ally_char.charId ORDER BY castle.id ASC;';
    private static $GET_CLAN_ALLY_TERRITORY = 'SELECT id, taxPercent, siegeDate, clan_clan.clan_id, clan_clan.clan_name, clan_clan.leader_id AS clan_leader_id, clan_char.char_name AS clan_leader_name, ally_clan.clan_id AS ally_id, clan_clan.ally_name, ally_clan.leader_id AS ally_leader_id, ally_char.char_name AS ally_leader_name, ownedWardIds AS wards FROM castle LEFT JOIN clan_data clan_clan ON clan_clan.hasCastle = castle.id LEFT JOIN clan_data ally_clan ON ally_clan.clan_id=clan_clan.ally_id LEFT JOIN characters clan_char ON clan_char.charId=clan_clan.leader_id LEFT JOIN characters ally_char ON ally_clan.leader_id=ally_char.charId JOIN territories ON castle.id=territories.castleId ORDER BY castle.id ASC;';

    static function get($id) {
        global $sql;
        $r = $sql[$id]->query(CastleMySQLImpl::$GET, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getClanAlly($id) {
        global $sql;
        $r = $sql[$id]->query(CastleMySQLImpl::$GET_CLAN_ALLY, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getClanAllyTerritory($id) {
        global $sql;
        $r = $sql[$id]->query(CastleMySQLImpl::$GET_CLAN_ALLY_TERRITORY, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}
class CastleSiegeMySQLImpl implements iCastleSiege {

    private static $GET = 'SELECT clan_id, clan_name, castle_owner FROM siege_clans JOIN clan_data USING (clan_id)  WHERE castle_id=? AND type=?';

    static function get($id, $castle, $type) {
        global $sql;
        $r = $sql[$id]->query(CastleSiegeMySQLImpl::$GET, [$castle, $type], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}
class CharMySQLImpl implements iChar {

    private static $CHAR_COUNT_BY_ACCESS = 'SELECT count(*) as count FROM characters WHERE accessLevel=?';
    private static $CHAR_COUNT_BY_RACE = 'SELECT count(*) as count FROM characters WHERE accessLevel=? AND race=?';
    private static $CHAR_COUNT_BY_SEX = 'SELECT count(*) as count FROM characters WHERE accessLevel=? AND sex=?';
    private static $CHAR_ONLINE_TRADE = 'SELECT count(*) as count FROM characters WHERE online != 0 AND accesslevel=?';
    private static $CHAR_ONLINE_COUNT = 'SELECT count(*) as count FROM characters WHERE online = ? AND accesslevel=?';
    private static $CHAR_ONLINE_LIMITED = "SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE online=:online AND accesslevel='0' ORDER BY exp DESC LIMIT :rows, :limit";
    private static $GM_ONLINE = 'SELECT count(*) as count FROM characters WHERE online != 0 AND accesslevel>0';
    private static $TOP_CHARS = 'SELECT charId, char_name, sex FROM characters WHERE accesslevel=0  ORDER BY level DESC, pvpkills DESC, fame DESC LIMIT :limit';
    private static $GET_CHAR_AND_CLAN = 'SELECT * FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE characters.charId = ?';
    private static $GET_OTHER_CHARS = 'SELECT * FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE account_name = ? AND characters.charId != ?  ORDER by characters.level ASC';
    private static $GET_SUBCLASSES_NOT_CUR = 'SELECT * FROM character_subclasses WHERE charId=? AND class_id!=? ORDER BY class_id ASC';
    private static $GET_SUBCLASSES = 'SELECT * FROM character_subclasses WHERE charId=? ORDER BY class_id ASC';

    static function getCharAndClanData($sId, $id) {
        global $sql;
        return $sql[$sId]->query(CharMySQLImpl::$GET_CHAR_AND_CLAN, [$id], __METHOD__)->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    static function getOtherChars($sId, $id, $name) {
        global $sql;
        return $sql[$sId]->query(CharMySQLImpl::$GET_OTHER_CHARS, [$name, $id], __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getCount($id) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$CHAR_COUNT_BY_ACCESS, ['0'], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getCountByRace($id, $race) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$CHAR_COUNT_BY_RACE, ['0', $race], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getCountBySex($id, $sex) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$CHAR_COUNT_BY_SEX, ['0', $sex], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getOnlineTradeCount($id) { // including offline trade
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$CHAR_ONLINE_TRADE, ['0'], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getOnlineCount($id, $online) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$CHAR_ONLINE_COUNT, [$online, '0'], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getOnlineLimited($id, $online, $start, $count) {
        global $sql;
        $r = $sql[$id]->query(CharMySQLImpl::$CHAR_ONLINE_LIMITED, [[':online', (int) $online, PDO::PARAM_INT], [':rows', (int) $start, PDO::PARAM_INT], [':limit', (int) $count, PDO::PARAM_INT]], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getOnlineGMCount($id) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$GM_ONLINE, [], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

    static function getTOPChars($id) {
        global $sql;
        return $sql[$id]->query(CharMySQLImpl::$TOP_CHARS, [[':limit', (int) Conf::get('web', 'top'), PDO::PARAM_INT]], __METHOD__)->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getSubclassesNotCurrent($id, $cId, $classid) {
        global $sql;
        $r = $sql[$id]->query(CharMySQLImpl::$GET_SUBCLASSES_NOT_CUR, [$cId, $classid], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getSubclasses($id, $cId) {
        global $sql;
        $r = $sql[$id]->query(CharMySQLImpl::$GET_SUBCLASSES, [$cId], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}
class FortMySQLImpl implements iFort {

    private static $GET = 'SELECT id, name, lastOwnedTime, clan_id, clan_name, charId, char_name FROM fort LEFT OUTER JOIN clan_data ON clan_data.clan_id=fort.owner LEFT JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC;';
    //private static $GET = 'SELECT id, name, taxPercent, siegeDate, charId, char_name, clan_id, clan_name FROM castle LEFT OUTER JOIN clan_data ON clan_data.hasCastle=castle.id LEFT OUTER JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC;';
    private static $GET_CLAN_ALLY = 'SELECT id, taxPercent, siegeDate, clan_clan.clan_id, clan_clan.clan_name, clan_clan.leader_id AS clan_leader_id, clan_char.char_name AS clan_leader_name, ally_clan.clan_id AS ally_id, clan_clan.ally_name, ally_clan.leader_id AS ally_leader_id, ally_char.char_name AS ally_leader_name FROM castle LEFT JOIN clan_data clan_clan ON clan_clan.hasCastle = castle.id LEFT JOIN clan_data ally_clan ON ally_clan.clan_id=clan_clan.ally_id LEFT JOIN characters clan_char ON clan_char.charId=clan_clan.leader_id LEFT JOIN characters ally_char ON ally_clan.leader_id=ally_char.charId ORDER BY castle.id ASC;';
    private static $GET_CLAN_ALLY_TERRITORY = 'SELECT id, taxPercent, siegeDate, clan_clan.clan_id, clan_clan.clan_name, clan_clan.leader_id AS clan_leader_id, clan_char.char_name AS clan_leader_name, ally_clan.clan_id AS ally_id, clan_clan.ally_name, ally_clan.leader_id AS ally_leader_id, ally_char.char_name AS ally_leader_name, ownedWardIds AS wards FROM castle LEFT JOIN clan_data clan_clan ON clan_clan.hasCastle = castle.id LEFT JOIN clan_data ally_clan ON ally_clan.clan_id=clan_clan.ally_id LEFT JOIN characters clan_char ON clan_char.charId=clan_clan.leader_id LEFT JOIN characters ally_char ON ally_clan.leader_id=ally_char.charId JOIN territories ON castle.id=territories.castleId ORDER BY castle.id ASC;';

    static function get($id) {
        global $sql;
        $r = $sql[$id]->query(FortMySQLImpl::$GET, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getClanAlly($id) {
        global $sql;
        $r = $sql[$id]->query(FortMySQLImpl::$GET_CLAN_ALLY, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getClanAllyTerritory($id) {
        global $sql;
        $r = $sql[$id]->query(FortMySQLImpl::$GET_CLAN_ALLY_TERRITORY, [], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }
}


class FortSiegeMySQLImpl implements iFortSiege {

    private static $GET = 'SELECT clan_id, clan_name FROM fortsiege_clans INNER JOIN clan_data USING (clan_id)  WHERE fort_id=?';
    
        //private static $GET = 'SELECT clan_id, clan_name, castle_owner FROM siege_clans JOIN clan_data USING (clan_id)  WHERE castle_id=? AND type=?';

    static function get($id, $castle, $type) {
        global $sql;
        $r = $sql[$id]->query(FortSiegeMySQLImpl::$GET, [$castle, $type], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}

class TerritoryMySQLImpl implements iTerritory {

    private static $FORT_WARDS = 'SELECT ownedWardIds FROM territories WHERE fortId=?';
    private static $CASTLE_WARDS = 'SELECT ownedWardIds FROM territories WHERE castleId=?';

}






class SevenSignsMySQLImpl implements iSevenSigns {

    private static $GET = 'SELECT * FROM seven_signs_status';

    static function get($id) {
        global $sql;
        $r = $sql[$id]->query(SevenSignsMySQLImpl::$GET, [], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

}



class HennaMySQLImpl implements iHenna {

    private static $GET_ALL = 'SELECT * FROM character_hennas WHERE charId=? AND class_index=?';

    static function getAll($sId, $cId, $clId) {
        global $sql;

        $r = $sql[$sId]->query(HennaMySQLImpl::$GET_ALL, [$cId, $clId], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}


class ClanMySQLImpl implements iClan {

    private static $TOTAL = 'SELECT count(*) as count FROM clan_data';

    static function getCount($id) {
        global $sql;
        return $sql[$id]->query(ClanMySQLImpl::$TOTAL, [], __METHOD__)->fetch(PDO::FETCH_OBJ)->count;
    }

}


class ItemMySQLImpl implements iItem {

    private static $GET_BY_CHAR_LOC = 'SELECT * FROM items WHERE items.owner_id=? AND items.loc=? ORDER BY items.loc_data';
    private static $GET_ENCHANT = 'SELECT enchant_level FROM items WHERE owner_id=? AND item_id=? AND loc=?';
    private static $GET = 'SELECT * FROM items WHERE object_id=?';
    private static $GET_AUGMENT = 'SELECT * FROM item_attributes WHERE itemId=?';

    static function get($srv, $id) {
        global $sql;
        $r = $sql[$srv]->query(ItemMySQLImpl::$GET, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getByLoc($srv, $charId, $loc) {
        global $sql;
        $r = $sql[$srv]->query(ItemMySQLImpl::$GET_BY_CHAR_LOC, [$charId, $loc], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    static function getEnchant($srv, $owner, $item, $loc) {
        global $sql;
        $r = $sql[$srv]->query(ItemMySQLImpl::$GET_ENCHANT, [$owner, $item, $loc], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

    static function getAugment($srv, $id) {
        global $sql;
        $r = $sql[$srv]->query(ItemMySQLImpl::$GET_AUGMENT, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetch(PDO::FETCH_ASSOC) : false;
    }

}


class ItemElementMySQLImpl implements iItemElement {

    private static $GET = 'SELECT * FROM item_elementals WHERE itemId=?';

    static function get($srv, $id) {
        global $sql;
        $r = $sql[$srv]->query(ItemElementMySQLImpl::$GET, [$id], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}



class SkillsMySQLImpl implements iSkills {

    private static $GET = 'SELECT * FROM `character_skills` WHERE `charId`=? AND `class_index`=?';

    static function get($srv, $id, $class) {
        global $sql;
        $r = $sql[$srv]->query(SkillsMySQLImpl::$GET, [$id, $class], __METHOD__);
        return $r->rowCount() ? $r->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}


