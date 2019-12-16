<?php
if (!defined('CORE')) {
    header("Location: index.php");
    die();
}

$q = [
    'core' => [
        /*'GET_CONFIG_TYPES' => 'SELECT * FROM config_type;',
        'GET_CONFIG' => 'SELECT name, config_type.type, value, config.type as tid FROM config , config_type WHERE config.type = id;',
        'INSERT_CONFIG' => "INSERT INTO config (name, type, value) VALUES (?, ?, ?)",
        'UPDATE_CONFIG' => "UPDATE config SET value=? WHERE name=? AND type=? LIMIT 1",
        'CHECK_CONFIG' => "SELECT * FROM config WHERE name=? AND type=?",*/
        //Servers
        'GET_GS_LIST' => "SELECT * FROM gameservers WHERE active = 'true';",
        'GET_TELNET' => "SELECT * FROM telnet WHERE server=?",
        //News
        //'GET_NEWS_LIMITED' => 'SELECT * FROM news ORDER BY date DESC LIMIT :limit',
        //'GET_NEW_BY_ID' => "SELECT * FROM news WHERE id=?",
        //'DELETE_NEW_BY_ID' => "DELETE FROM news WHERE id=?",
        //'UPDATE_NEW_BY_ID' => "UPDATE news SET name=':name:', desc=':desc', editTime=?, editBy=? WHERE id=?",
        //'ADD_NEW' => "INSERT INTO news (name, date, author, desc, image) VALUES (?, ?, ?, ?, ?);",
        //Cache
        //'GET_CACHE'=>"SELECT * FROM cache",
        //'ADD_CACHE' => "INSERT INTO cache (id, page) VALUES (?, ?)",
        //'UPDATE_CACHE_BY_ID' => "UPDATE cache SET time=?, recache='0' WHERE id=?",
        //'RECACHE_CACHE_BY_PAGE' => "UPDATE cache SET recache='1' WHERE page=?",
        //Messages
        //'NEW_MESSAGES' => "SELECT * FROM messages WHERE receiver=? AND unread='yes'",
        //'SENT_MESSAGES' => "SELECT * FROM messages WHERE sender=?",
        //'RECEIVED_MESSAGES' => "SELECT * FROM messages WHERE receiver=?",
        //WebShop
        //'WEBSHOP_ITEM' => "SELECT * FROM webshop WHERE objectId=:id;",
        //Item Data
        //'ITEM_INFO' => 'SELECT * FROM itemname WHERE id=:id;',
        //'GET_ITEM_NAME' => 'SELECT name FROM itemname WHERE id=:id;',
        //'ARMOR_DATA' => 'SELECT * FROM armorgrp WHERE id=:id;',
        //'WEAPON_DATA' => 'SELECT * FROM weapongrp WHERE id=:id;',
        //'AUGMENT_DATA' => 'SELECT * FROM optiondata WHERE id=:id;',
        //Blocks
        //'GET_BLOCKS' => 'SELECT * FROM blocks ORDER BY align ASC, position ASC;',
        //PM
        30 => 'SELECT * FROM messages WHERE receiver=\'{account}\' AND location=\'{loc}\' ORDER BY id DESC;',
        31 => 'SELECT * FROM messages WHERE sender=\'{account}\' AND saved=\'yes\' ORDER BY id DESC;',
        32 => 'SELECT * FROM messages WHERE id=\'{pm_id}\' AND (receiver=\'{account}\' OR (sender=\'{account}\' AND saved=\'yes\')) LIMIT 1;',
        33 => 'UPDATE messages SET unread=\'no\' WHERE id=\'{pm_id}\' AND receiver=\'{account}\' LIMIT 1;',
        34 => 'SELECT * FROM messages WHERE id=\'{pm_id}\';',
        35 => 'DELETE FROM messages WHERE id=\'{pm_id}\';',
        36 => 'UPDATE messages SET location=\'0\' WHERE id=\'{pm_id}\';',
        37 => 'UPDATE messages SET saved=\'no\' WHERE id=\'{pm_id}\';',
        38 => 'UPDATE messages SET unread = \'no\', location = \'0\' WHERE id=\'{pm_id}\';',
        'SHOW_TABLES'=>'SHOW TABLES FROM :db',
        'SHOW_STATUS'=>'SHOW TABLE STATUS FROM :db',
        'OPTIMIZE_TABLE'=>'OPTIMIZE TABLE :table',
        'REPAIR_TABLE'=>'REPAIR TABLE :table',
        'INSERT_LOG'=>'INSERT INTO log (account, type, subType, comment) VALUES (?, ?, ?, ?);',
       ],

    'gs' => [
        //'TOP_CHAR_LIST' => 'SELECT charId, char_name, sex FROM characters WHERE accesslevel=\'0\'  ORDER BY level DESC, pvpkills DESC, fame DESC LIMIT :limit',
        //'CLAN_COUNT' => 'SELECT count(*) as count FROM clan_data;',
        'CHAR_COUNT' => "SELECT count(*) as count FROM characters WHERE accessLevel='0';",
        'ONLINE_COUNT' => "SELECT count(*) as count FROM characters WHERE online != '0' AND accesslevel='0';",
        'ONLINE_COUNT1' => "SELECT count(*) as count FROM characters WHERE online = '1' AND accesslevel='0';",
        'OFFLINE_TRADE_COUNT' => "SELECT count(*) as count FROM characters WHERE online = '2' AND accesslevel='0';",
        'ONLINE_GM_COUNT' => "SELECT count(*) as count FROM characters WHERE online != '0' AND accesslevel>'0';",
        'CHAR_LIST_ONLINE' => "SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE online!='0' AND accesslevel='0' ORDER BY exp DESC LIMIT {limit}, {rows};",
        //'CLAN_TOP' => "SELECT clan_id, clan_name, clan_level, reputation_score, hasCastle, ally_id, ally_name, charId, char_name, ccount, name FROM clan_data INNER JOIN characters ON clan_data.leader_id=characters.charId LEFT JOIN (SELECT clanid, count(level) AS ccount FROM characters WHERE clanid GROUP BY clanid) AS levels ON clan_data.clan_id=levels.clanid LEFT OUTER JOIN castle ON clan_data.hasCastle=castle.id WHERE characters.accessLevel='0' ORDER BY clan_level DESC, reputation_score DESC LIMIT {limit}, {top};",
        //'CLAN_COUNT_NON_GM' => "SELECT count(clan_id) FROM clan_data, characters WHERE clan_data.leader_id=characters.charId AND characters.accessLevel='0';",
        'FORT_INFO' => 'SELECT id, name, lastOwnedTime, clan_id, clan_name, charId, char_name FROM fort LEFT OUTER JOIN clan_data ON clan_data.clan_id=fort.owner LEFT OUTER JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC;',
        'CASTLE_INFO' => 'SELECT id, name, taxPercent, siegeDate, charId, char_name, clan_id, clan_name FROM castle LEFT OUTER JOIN clan_data ON clan_data.hasCastle=castle.id LEFT OUTER JOIN characters ON clan_data.leader_id=characters.charId ORDER by id ASC;',
        'CASTLE_WARDS' => "SELECT ownedWardIds FROM territories WHERE castleId='{id}';",
        'FORT_WARDS' => "SELECT ownedWardIds FROM territories WHERE fortId='{id}';",
        'CASTLE_SIEGE' => "SELECT clan_id, clan_name FROM siege_clans INNER JOIN clan_data USING (clan_id)  WHERE castle_id='{id}' AND type='{type}';",
        'FORT_SIEGE' => "SELECT clan_id, clan_name FROM fortsiege_clans INNER JOIN clan_data USING (clan_id)  WHERE fort_id='{id}';",
        //'GS_ITEM' => 'SELECT * FROM items WHERE object_id=:id;',
        'GET_AUGMENT' => "SELECT * FROM item_attributes WHERE itemId='{id}';",
        'GET_ELEMENTS' => "SELECT * FROM item_elementals WHERE itemId='{id}';",
        'GET_ENCHANT' => 'SELECT enchant_level FROM items WHERE owner_id=:oId AND item_id=:iId AND loc=:loc;',
        'CHAR_INFO' => "SELECT account_name, charId, char_name, level, maxHp, maxCp, maxMp, sex, pvpkills, pkkills, race, characters.classid, base_class, online, onlinetime, clan_id, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE characters.charId = :id;",
        'OTHER_ACC_CHARS' => "SELECT account_name, charId, char_name, level, maxHp, maxCp, maxMp, sex, pvpkills, pkkills, clanid, race, characters.classid, base_class, online, clan_id, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE characters.charId != :id AND account_name = :acc ORDER by characters.level ASC;",
        'CHAR_COUNT_BY_SEX' => 'SELECT count(*) FROM characters WHERE sex = \'{sex}\'',
        //206 => 'SELECT count(*) FROM seven_signs WHERE cabal LIKE \'{cabal}\'',
        'SEVEN_SIGNS' => 'SELECT * FROM seven_signs_status',
        'CHAR_COUNT_BY_RACE' => 'SELECT count(0) FROM characters WHERE race = \'{race}\'',
        'CHAR_TOP_BY_RACE' => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel=\'0\' AND race=\'{race}\' ORDER BY exp DESC LIMIT {limit}, {rows}',
        'CHAR_TOP_BY_ADD_STAT' => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, :order, base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel=\'0\' ORDER BY :order DESC LIMIT :start, :limit',
        'CHAR_TOP_BY_STAT' =>     'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online,  base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel=\'0\' AND {order}>\'0\' ORDER BY {order} DESC LIMIT {limit}, {rows}',
        'GM_COUNT' => 'SELECT count(0) FROM characters WHERE accesslevel>\'0\';',
        'CHAR_COUNT_BY_STAT' => 'SELECT count(0) FROM characters WHERE accesslevel=\'0\' AND {order}>\'0\'',
        //'CHAR_COUNT_BY_ITEM_COUNT' => 'SELECT count(0) FROM characters, items  WHERE accesslevel=\'0\' AND characters.charId=items.owner_id AND items.item_id=\'{item}\'',
        //'CHAR_TOP_BY_ITEM_COUNT' => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online,  count, base_class, clanid, clan_name FROM characters INNER JOIN items ON characters.charId=items.owner_id LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE items.item_id=\'{item}\' AND accesslevel=\'0\' ORDER BY count DESC LIMIT {limit}, {rows}',
        'GM_LIST' => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, clanid, clan_name, base_class FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel>\'0\' LIMIT :limit, :rows',
        217 => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE online!=\'0\' AND accesslevel=\'0\' ORDER BY exp DESC LIMIT {limit}, {rows}',
        //'CHAR_TOP_BY_EXP' => 'SELECT charId, char_name, level, sex, pvpkills, pkkills, race, online, base_class, clanid, clan_name FROM characters LEFT OUTER JOIN clan_data ON characters.clanid=clan_data.clan_id WHERE accesslevel=\'0\' ORDER BY exp DESC LIMIT {limit}, {rows}',
        //'SEARCH_CHARS' => "SELECT charId,char_name,account_name,level FROM characters WHERE char_name LIKE :name LIMIT 0, :limit",
        'CHAR_ITEMS_BY_LOC' => "SELECT items.item_id, items.object_id, items.count, items.enchant_level, items.loc_data FROM items WHERE items.owner_id=:id AND items.loc=:loc ORDER BY items.loc_data",
        //'GET_ACC_CHARS' => 'SELECT charId, char_name FROM characters WHERE account_name=:login;',
       ],
   ];


/*$qo = array(
    300 => "SELECT items.object_id,items.item_id,items.count,items.enchant_level,items.loc, 
			CASE WHEN armor.name != '' THEN armor.name 
			WHEN weapon.name != '' THEN weapon.name 
			WHEN etcitem.name != '' THEN etcitem.name 
			END AS name, 
			CASE WHEN armor.crystal_type != '' THEN 'armor' 
			WHEN weapon.crystal_type != '' THEN 'weapon' 
			WHEN etcitem.crystal_type != '' THEN 'etc' 
			END AS type 
		FROM {db}.items 
		LEFT JOIN armor ON armor.item_id = items.item_id 
		LEFT JOIN weapon ON weapon.item_id = items .item_id 
		LEFT JOIN etcitem ON etcitem.item_id = items.item_id 
		WHERE items.owner_id='{charID}' 
		ORDER BY {order}",
    301 => "SELECT items.object_id,items.item_id,items.count,items.enchant_level,items.loc,items.loc_data,armorName,weaponName,etcName,armorType,weaponType,etcType
		FROM {db}.items 
		LEFT JOIN (
			SELECT item_id, name AS armorName, crystal_type AS armorType 
			FROM armor
			) AS aa ON aa.item_id = items.item_id 
		LEFT JOIN (
			SELECT item_id, name AS weaponName, crystal_type AS weaponType 
			FROM weapon
			) AS ww ON ww.item_id = items.item_id
		LEFT JOIN (
			SELECT item_id, name AS etcName, crystal_type AS etcType 
			FROM etcitem
			) AS ee ON ee.item_id = items.item_id
		WHERE items.owner_id='{charID}' AND items.loc='{loc}' 
		ORDER BY items.loc_data",
        
        
        
            302 => "SELECT items.item_id, items.count, items.enchant_level, items.loc, items.loc_data, all.name, all.addname, all.grade, all.desc, all.set_bonus, all.set_extra_desc, all.icon
		FROM {db}.items 
		LEFT JOIN (
			SELECT all_items.id, all_items.name, all_items.addname, all_items.grade,all_items.icon1, all_items.desc, all_items.set_bonus, all_items.set_extra_desc FROM {webdb}.all_items
			) AS all ON all.id = items.item_id  
		WHERE items.owner_id='{charID}' AND items.loc='{loc}' 
		ORDER BY items.loc_data",
        

    667 => "SELECT items.item_id, items.object_id, items.count, items.enchant_level, items.loc_data FROM items WHERE items.owner_id='{charID}' AND items.loc='{loc}' ORDER BY items.loc_data",
    668 => "SELECT * FROM itemname WHERE id='{itemid}'",
    
);*/
global $q;