<?php

if (!defined('DAO')) {
    die();
}

interface iFactory {

    static function Account();

    static function AccountData();

    static function Ban();

    static function Block();

    static function Cache();

    static function Config();

    //static function ConfigTypes();

    static function Lang();

    static function Log();

    static function L2WGameServer();

    static function L2WHenna();

    static function L2WItem();

    static function L2WSkills();

    static function Messages();

    static function News();

    static function Augment();

    static function Castle();

    static function CastleSiege();

    static function Char();

    static function Clan();

    static function Fort();

    static function FortSiege();

    static function Element();

    static function Henna();

    static function Item();

    static function SevenSigns();

    static function Skills();

    static function Territory();
}
