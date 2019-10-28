<?php
if (!defined('DAO')) {
    header('Location: index.php');
    die();
}
require ('core/DAO/impl/MySQL/L2LS.php');
require ('core/DAO/impl/MySQL/L2GS.php');
require ('core/DAO/impl/MySQL/L2Web.php');
class MySQL implements iFactory {

    static $ACC, $ACC_DATA;
    static $BAN, $BLOCK, $CACHE, $CONFIG, $CONFIG_TYPES, $LANG, $LOG, $L2WGAMESERVER, $L2WHENNA, $L2WITEM, $L2WSKILLS, $MESSAGES, $NEWS;
    static $AUGMENT, $CASTLE, $CASTLE_SIEGE, $CHAR, $CLAN, $FORT, $FORT_SIEGE, $ELEMENT, $HENNA, $ITEM, $SEVENSIGNS, $SKILLS, $TERRITORY;

    //region LS Tables
    static function Account() {
        if (MySQL::$ACC == null) {
            MySQL::$ACC = new AccountMySQLImpl();
        }
        return MySQL::$ACC;
    }

    static function AccountData() {
        if (MySQL::$ACC_DATA == null) {
            MySQL::$ACC_DATA = new AccountDataMySQLImpl();
        }
        return MySQL::$ACC_DATA;
    }

    //endregion
    //region L2W Tables
    static function Ban() {
        if (MySQL::$BAN == null) {
            MySQL::$BAN = new BanMySQLImpl();
        }
        return MySQL::$BAN;
    }

    static function Block() {
        if (MySQL::$BLOCK == null) {
            MySQL::$BLOCK = new BlockMySQLImpl();
        }
        return MySQL::$BLOCK;
    }

    static function Cache() {
        if (MySQL::$CACHE == null) {
            MySQL::$CACHE = new CacheMySQLImpl();
        }
        return MySQL::$CACHE;
    }

    static function Config() {
        if (MySQL::$CONFIG == null) {
            MySQL::$CONFIG = new ConfigMySQLImpl();
        }
        return MySQL::$CONFIG;
    }

    /* static function ConfigTypes() {
      if (MySQL::$CONFIG_TYPES == null) {
      MySQL::$CONFIG_TYPES = new ConfigTypesMySQLImpl();
      }
      return MySQL::$CONFIG_TYPES;
      } */

    static function Lang() {
        if (MySQL::$LANG == null) {
            MySQL::$LANG = new LangMySQLImpl();
        }
        return MySQL::$LANG;
    }

    static function Log() {
        if (MySQL::$LOG == null) {
            MySQL::$LOG = new LogMySQLImpl();
        }
        return MySQL::$LOG;
    }

    static function L2WGameServer() {
        if (MySQL::$L2WGAMESERVER == null) {
            MySQL::$L2WGAMESERVER = new L2WGameServerMySQLImpl();
        }
        return MySQL::$L2WGAMESERVER;
    }

    static function L2WHenna() {
        if (MySQL::$L2WHENNA == null) {
            MySQL::$L2WHENNA = new L2WHennaMySQLImpl();
        }
        return MySQL::$L2WHENNA;
    }

    static function L2WItem() {
        if (MySQL::$L2WITEM == null) {
            MySQL::$L2WITEM = new L2WItemMySQLImpl();
        }
        return MySQL::$L2WITEM;
    }

    static function L2WSkills() {
        if (MySQL::$L2WSKILLS == null) {
            MySQL::$L2WSKILLS = new L2WSkillsMySQLImpl();
        }
        return MySQL::$L2WSKILLS;
    }

    static function Messages() {
        if (MySQL::$MESSAGES == null) {
            MySQL::$MESSAGES = new MessagesMySQLImpl();
        }
        return MySQL::$MESSAGES;
    }

    static function News() {
        if (MySQL::$NEWS == null) {
            MySQL::$NEWS = new NewsMySQLImpl();
        }
        return MySQL::$NEWS;
    }

    //endregion
    static function Augment() {
        if (MySQL::$AUGMENT == null) {
            MySQL::$AUGMENT = new AugmentMySQLImpl();
        }
        return MySQL::$AUGMENT;
    }

    static function Castle() {
        if (MySQL::$CASTLE == null) {
            MySQL::$CASTLE = new CastleMySQLImpl();
        }
        return MySQL::$CASTLE;
    }

    static function CastleSiege() {
        if (MySQL::$CASTLE_SIEGE == null) {
            MySQL::$CASTLE_SIEGE = new CastleSiegeMySQLImpl();
        }
        return MySQL::$CASTLE_SIEGE;
    }

    static function Char() {
        if (MySQL::$CHAR == null) {
            MySQL::$CHAR = new CharMySQLImpl();
        }
        return MySQL::$CHAR;
    }

    static function Clan() {
        if (MySQL::$CLAN == null) {
            MySQL::$CLAN = new ClanMySQLImpl();
        }
        return MySQL::$CLAN;
    }

    static function Element() {
        if (MySQL::$ELEMENT == null) {
            MySQL::$ELEMENT = new ElementMySQLImpl();
        }
        return MySQL::$ELEMENT;
    }
    static function Fort() {
        if (MySQL::$FORT == null) {
            MySQL::$FORT = new FortMySQLImpl();
        }
        return MySQL::$FORT;
    }
    static function FortSiege() {
        if (MySQL::$FORT_SIEGE == null) {
            MySQL::$FORT_SIEGE = new FortSiegeMySQLImpl();
        }
        return MySQL::$FORT_SIEGE;
    }



    static function Henna() {
        if (MySQL::$HENNA == null) {
            MySQL::$HENNA = new HennaMySQLImpl();
        }
        return MySQL::$HENNA;
    }

    static function Item() {
        if (MySQL::$ITEM == null) {
            MySQL::$ITEM = new ItemMySQLImpl();
        }
        return MySQL::$ITEM;
    }

    static function SevenSigns() {
        if (MySQL::$SEVENSIGNS == null) {
            MySQL::$SEVENSIGNS = new SevenSignsMySQLImpl();
        }
        return MySQL::$SEVENSIGNS;
    }

    static function Skills() {
        if (MySQL::$SKILLS == null) {
            MySQL::$SKILLS = new SkillsMySQLImpl();
        }
        return MySQL::$SKILLS;
    }

    static function Territory() {
        if (MySQL::$TERRITORY == null) {
            MySQL::$TERRITORY = new TerritoryMySQLImpl();
        }
        return MySQL::$TERRITORY;
    }

}