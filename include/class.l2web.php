<?php

class L2Web {

    static $l2web = array(
        'body' => array(
            0 => 'Bracelet', // (aga)     weapon - pet weapon
            1 => 'Earring',
            3 => 'Necklace',
            4 => 'Ring',
            6 => 'Headgear',
            7 => 'Two-Handed',
            8 => 'Upper and lower body',
            9 => 'Dress',
            10 => 'Hair accessory',
            19 => 'Belt',
            20 => 'Gloves',
            21 => 'Upper body',
            22 => 'Lower body',
            23 => 'Boots',
            24 => 'Cloak',
            25 => 'Hair accessory',
            26 => 'Hair accessory',
            27 => 'One-Handed',
            28 => 'Shield, Sigil',
            29 => 'Bracelet',
        ),
        'a' => array(
            0 => 'None',
            1 => 'Light',
            2 => 'Heavy',
            3 => 'Robe',
            4 => 'Sigil',
        ),
        'e' => array(
            0 => 'None',
            1 => 'Scroll', //Soul Crystal
            2 => 'Arrow, Bolt', //(Arrow)
            3 => 'Potion',
            5 => 'Recipe',
            6 => 'Material',
            7 => 'Pet',
            8 => 'Mercenary Ticket',
            9 => 'Dye',
            10 => 'Seed',
            11 => 'Seed', // (Alternative)
            12 => 'Other', // (Harvester)
            13 => 'Other', // (Lottery Ticket)
            14 => 'Other', // (Monster Race Ticket)
            15 => 'Other', // (Certificate of Approval)
            16 => 'Lure',
            17 => 'Seed',
            18 => 'Seed', // (Alternative)
            19 => 'Scroll', // (pc cafe enchants??????weapon)
            20 => 'Scroll', // (pc cafe enchants??????armor)
            21 => 'Event', // (bleesed weapon)
            22 => 'Scroll', // (blessed armor)
            23 => 'Other', // (Weapon Exchange Coupon NO/C-Grade)
            24 => 'Potion', // (Elixirs)
            25 => 'Scroll', // (Elemental)
            26 => 'Arrow, Bolt', // (Bolt)
            27 => 'Scroll', // (weapon backup stone)
            28 => 'Scroll', // (armor backup stone)
            31 => 'Scroll', // (divine armor enchant)
            32 => 'Scroll', // (divine weapon enchant)
            33 => 'Rune',
            34 => 'Rune',
            35 => 'Scroll', // (my teleport)
        ),
        'w' => array(
            0 => 'Shield',
            1 => 'Sword',
            2 => 'Blunt',
            3 => 'Dagger',
            4 => 'Polearm',
            5 => 'Fist',
            6 => 'Bow',
            7 => 'Etc',
            8 => 'Dual Sword',
            9 => '',
            10 => 'Rod',
            11 => 'Rapier',
            12 => 'Crossbow',
            13 => 'Ancient',
            15 => 'Dual Dagger',
            16 => 'Flag, Ward',
        ),
        'parts' => array(
            0 => 'dress',
            1 => 'helmet',
            2 => 'leftthair',
            3 => 'righthair',
            4 => 'necklace',
            5 => 'weapon',
            6 => 'top',
            7 => 'shield',
            8 => 'rightearring',
            9 => 'leftearring',
            10 => 'gloves',
            11 => 'lower',
            12 => 'bots',
            13 => 'rightring',
            14 => 'leftring',
            15 => 'ring',
            16 => 'braslet',
            17 => 'deco1',
            18 => 'deco2',
            19 => 'deco3',
            20 => 'deco4',
            21 => 'deco5',
            22 => 'deco6',
            23 => 'cloak',
            24 => 'belt',
            25 => 'total',
        ),
    );
    static $elements = array(0 => 'Fire', 1 => 'Water', 2 => 'Wind', 3 => 'Earth', 4 => 'Holy', 5 => 'Dark');
    static $FIRST_WEAPON_BONUS = 20;
    static $WEAPON_BONUS = 5;
    static $ARMOR_BONUS = 6;
    static $WEAPON_VALUES = array(
        0, // Level 1
        25, // Level 2
        75, // Level 3
        150, // Level 4
        175, // Level 5
        225, // Level 6
        300, // Level 7
        325, // Level 8
        375, // Level 9
        450
    );
    static $ARMOR_VALUES = array(
        0, // Level 1
        12, // Level 2
        30, // Level 3
        60, // Level 4
        72, // Level 5
        90, // Level 6
        120, // Level 7
        132, // Level 8
        150, // Level 9
        450
    );
    static $colors = array(
        'white' => '#FFFFFF',
        'grey' => '#A0A0A0',
        'brown' => '#AE9978',
        'yellow' => '#FFD969',
        'clay' => '#B2BECF',
        'red' => '#F75959',
        'purple' => '#CC23B3',
        'blue' => '#5ACBED',
    );

    public static function buildArmor($inv, $item, $srv) {
        global $sql;
        $aug=null;
        if ($srv == 'ws') {
            if($inv['augment'])
            {
            $ids = explode(',', $inv['augment']);
            $aug = L2Web::getWSAugment($ids[0], $ids[1]);
            }
        } else {
            $aug = L2Web::getAugment($inv['object_id'], $srv);
        }
        if ($aug != null) {
            $name = 'Augmented ' . $item['name'];
        } else {
            $name = $item['name'];
        }
        $loc = $inv['loc'];
        $name = str_replace("'", "\\'", $name);
        $addname = L2Web::formatAddName(str_replace("'", "\\'", $item["add_name"]));
        $grade = L2Web::getGradeImg($item['grade']);
        $enchant = L2Web::getEnchant($inv['enchant_level']);
        $item_type = ($item['item_type'] != 0) ? L2Web::$l2web['a'][$item['item_type']] . ' / ' : '';
        $sql[0]->query('ARMOR_DATA', array('id' => $item['id']));
        $grp = SQL::fetchArray();
        $hands = L2Web::$l2web['body'][$grp['body_part']];
        $desc = ($item['desc'] != '') ? str_replace(array("'", "<"), array("\\'", "&lt;"), $item['desc']) : '';
        $set = $item['set_ids'];
        $bonus = $item['bonus_desc'];
        $extraI = $item['extra_ids'];
        $extra = $item['extra_desc'];
        $enchA = $item['enchant_amount'];
        $ench = $item['enchant_desc'];
        $ret = '<font color="' . L2Web::$colors['brown'] . '">' . $enchant . '</font> ' . $name . ' <font color="' . L2Web::$colors['yellow'] . '">' . $addname . '</font> ' . $grade . ' ' . //$count.
                '<br /><br /><font color="' . L2Web::$colors['brown'] . '">' . $item_type . $hands . '</font>';
        if ($grp['pdef']) {
            $pdef = $grp['pdef'] + ($inv['enchant_level']);
            if ($inv['enchant_level'] > 3) {
                $pdef+=($inv['enchant_level'] - 3) * 3 - (($inv['enchant_level'] - 3));
            }
            $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">P. Def. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $pdef . '</font>';
        }
        if ($grp['mdef']) {
            $mdef = $grp['mdef'] + ($inv['enchant_level']);
            if ($inv['enchant_level'] > 3) {
                $mdef+=($inv['enchant_level'] - 3) * 3 - (($inv['enchant_level'] - 3));
            }
            $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">M. Def. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $mdef . '</font>';
        }
        if ($grp['mpbonus']) {
            $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">MP Bonus. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $grp['mpbonus'] . '</font>';
        }
        $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">Weight :</font> <font color="' . L2Web::$colors['brown'] . '"> ' . $item['weight'] . '</font><br />';
        if ($aug != '') {
            $ret.='<br /><b>&lt;Augmentation Effects&gt;</b><br />' . $aug;
        }
        if ($desc != '') {
            $ret.= '<br /><font color="' . L2Web::$colors['clay'] . '">' . $desc . '</font>';
        }
        $enchS = 0;
        $setS = 0;
        $full = false;
        if ($bonus != '' && $set != '') {

            $parts = explode(';', $set);
            foreach ($parts as $part) {
                if ($part == $inv['item_id']) {
                    $setS++;
                    if ($inv['enchant_level'] >= $enchA) {
                        $enchS++;
                    }
                    continue;
                }
                $a = $sql[0]->query("SELECT `name` FROM `itemname` WHERE `id`='{id}';", array('id' => $part));
                if (!SQL::numRows($a)) {
                    die('UNKNOWN ID');
                }
                $it = SQL::fetchArray($a);
                $part_name = $it['name'];
                if ($loc == 'PAPERDOLL') {
                    $b = $sql[SQL_NEXT_ID + $srv]->query("SELECT `enchant_level` FROM `items` WHERE `owner_id`='{oId}' AND `item_id`='{iId}' AND `loc`='{loc}';", array('oId' => $inv['owner_id'], 'iId' => $part, 'loc' => 'PAPERDOLL'));
                    if (SQL::numRows($b)) {
                        $p = SQL::fetchArray($b);
                        $color = L2Web::$colors['white'];
                        $setS++;
                        if ($p['enchant_level'] >= $enchA) {
                            $enchS++;
                        }
                    } else {
                        $color = L2Web::$colors['grey'];
                    }
                } else {
                    $color = L2Web::$colors['grey'];
                }

                $ret.= '<br /><font color="' . $color . '">' . $part_name . '</font>';
            }
            if ($setS == count($parts) && $loc == 'PAPERDOLL') {
                $full = true;
                $color = L2Web::$colors['yellow'];
            } else {
                $color = L2Web::$colors['brown'];
            }
            $ret.= '<br /><font color="' . $color . '">' . $bonus . '</font><br />';
        }
        if ($extra != '' && $extraI != '') {
            $parts = explode(';', $extraI);
            $part_name = '';
            $extra_part = false;
            $color = '';
            foreach ($parts as $part) {
                $a = $sql[0]->query("SELECT `name` FROM `itemname` WHERE `id`='{id}';", array('id' => $part));
                if (!SQL::numRows($a)) {
                    die('UNKNOWN ID');
                }
                $it = SQL::fetchArray($a);
                $part_name = $it['name'];
                if ($srv != 'ws' || $loc != 'PAPERDOLL') {
                    $b = $sql[SQL_NEXT_ID + $srv]->query("SELECT `enchant_level` FROM `items` WHERE `owner_id`='{oId}' AND `item_id`='{iId}' AND `loc`='{loc}';", array('oId' => $inv['owner_id'], 'iId' => $part, 'loc' => 'PAPERDOLL'));
                    if (!SQL::numRows($b)) {
                        $p = SQL::fetchArray($b);
                        $color = L2Web::$colors['white'];
                        $extra_part = true;
                        break;
                    } else {
                        $color = L2Web::$colors['grey'];
                    }
                } else {
                    $color = L2Web::$colors['grey'];
                }
            }
            $ret.= '<br /><font color="' . $color . '">' . $part_name . '</font>';
            $color2 = $full && $extra_part ? L2Web::$colors['yellow'] : L2Web::$colors['brown'];
            $ret.= '<br /><font color="' . $color2 . '">' . $extra . '</font><br />';
        }
        if ($ench != '') {
            $color = ($full && $loc == 'PAPERDOLL') ? L2Web::$colors['white'] : L2Web::$colors['clay'];
            $ret.= '<br /><font color="' . $color . '">' . $ench . '</font><br />';
        }
        $element = '';
                if ($srv == 'ws') {
            $elements = explode(';', $inv['elementals']);
            foreach ($elements as $elem) {
                if($elem)
                {
                $ele = explode(',', $elem);
                $element .= L2Web::drawAElement($ele[0], $ele[1]) . '';
                }
            }
        } else {
            $sql[SQL_NEXT_ID + $srv]->query('GET_ELEMENTS', array('id' => $inv['object_id']));
            while ($ele = SQL::fetchArray()) {
                $element .= L2Web::drawAElement($ele['elemType'], $ele['elemValue']) . '';
            }
        }
        if ($element != '') {
            $ret.= '<br />' . $element;
        }
        if($srv=='ws')
        {
            $ret.='<br /><a href="webshop.php?a=buy&id=5&srv=ws">'.button('buy','', true).'</a>';
        }
        return '<div style="border: 1px solid #434034; background: #000000; width:300px; margin: auto;  padding: 5px;">' . $ret . '</div>';
    }

    /*
     * $inv - GS items data
     * $item - L2Web itemname data
     * $srv - Server id
     */

    public static function buildWeapon($inv, $item, $srv) {
        global $sql;
        //$type = L2Web::$l2web['parts'][$inv["loc_data"]];
        $enchant = L2Web::getEnchant($inv['enchant_level']);
        if ($srv == 'ws') {
            if($inv['augment'])
            {
            $ids = explode(',', $inv['augment']);
            $aug = L2Web::getWSAugment($ids[0], $ids[1]);
            }
            else
            {
                $aug='';
            }
        } else {
            $aug = L2Web::getAugment($inv['object_id'], $srv);
        }
        if ($aug != null) {
            $name = 'Augmented ' . $item['name'];
        } else {
            $name = $item['name'];
        }
        $name = str_replace("'", "\\'", $name);
        $addname = L2Web::formatAddName(str_replace("'", "\\'", $item['add_name']));
        $grade = L2Web::getGradeImg($item['grade']);
        $item_type = L2Web::$l2web['w'][$item['item_type']];
        $sql[0]->query('WEAPON_DATA', array('id' => $inv['item_id']));
        $grp = SQL::fetchArray();
        $hands = L2Web::$l2web['body'][$grp['body_part']];
        //$enc=0;
        //$oenc=0;
        switch ($item['item_type']) {
            case 5: //fist
            case 8: //dual sword
            case 9:
            case 13: //ancient sword
            case 15: //dual dagger
                $enc = 6;
                $oenc = 12;
                break;
            case 6: //Bow
            case 12: //Crossbow
                $enc = 10;
                $oenc = 20;
                break;
            default:
                $enc = 5;
                $oenc = 10;
                break;
        }
        $desc = $item['desc'];
        $ret = '<font color="' . L2Web::$colors['brown'] . '">' . $enchant . '</font> ' . $name . ' <font color="' . L2Web::$colors['yellow'] . '">' . $addname . '</font> ' . $grade . //$count.
                '<br /><br /><font color="' . L2Web::$colors['brown'] . '">' . $item_type;
        $ret.=($item['item_type'] != '0') ? ' / ' . $hands : '';
        $ret.='</font><br />';
        if ($item['item_type'] != '0') {
            $patk = $grp['patt'] + ($inv['enchant_level'] * $enc);
            $matk = $grp['matt'] + ($inv['enchant_level'] * 4);
            if ($inv['enchant_level'] > 3) {
                $patk+=($inv['enchant_level'] - 3) * $oenc - (($inv['enchant_level'] - 3) * $enc);
                $matk+=($inv['enchant_level'] - 3) * 8 - (($inv['enchant_level'] - 3) * 4);
            }
            $ret.=
                    '<br /><b>&lt;Weapon Specifications&gt;</b>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">P. Atk. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $patk . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">M. Atk. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $matk . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Atk. Spd. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $grp['speed'] . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Soulshot Used :</font> <font color="' . L2Web::$colors['brown'] . '">X ' . $grp['SS_count'] . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Spiritshot Used :</font> <font color="' . L2Web::$colors['brown'] . '">X ' . $grp['SPS_count'] . '</font>';
        } else {
            $pdef = $grp['shield_pdef'] + ($inv['enchant_level']);
            if ($inv['enchant_level'] > 3) {
                $pdef+=($inv['enchant_level'] - 3) * 3 - (($inv['enchant_level'] - 3));
            }
            $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">P. Def. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $pdef . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">DEF Rate :</font> <font color="' . L2Web::$colors['brown'] . '">' . $grp['shield_rate'] . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Evasion :</font> <font color="' . L2Web::$colors['brown'] . '">' . $grp['avoid_mod'] . '</font>';
        }
        $ret.='<br /><font color="' . L2Web::$colors['grey'] . '">Weight :</font> <font color="' . L2Web::$colors['brown'] . '"> ' . $item['weight'] . '</font><br />';
        if ($aug != '') {
            $ret.='<br /><b>&lt;Augmentation Effects&gt;</b><br />' . $aug;
        }
        if ($desc != '') {
            $ret.= '<br /><font color="' . L2Web::$colors['clay'] . '">' . $desc . '</font>';
        }
        $element = '';
        if ($srv == 'ws') {
            $elements = explode(';', $inv['elementals']);
            foreach ($elements as $elem) {
                if($elem)
                {
                $ele = explode(',', $elem);
                $element .= L2Web::drawWElement($ele[0], $ele[1]) . '';
                }
            }
        } else {
            $sql[SQL_NEXT_ID + $srv]->query('GET_ELEMENTS', array('id' => $inv['object_id']));
            while ($ele = SQL::fetchArray()) {
                $element .= L2Web::drawWElement($ele['elemType'], $ele['elemValue']) . '';
            }
        }
        if ($element != '') {
            $ret.= '<br />' . $element;
        }
        return '<div style="border: 1px solid #434034; background: #000000; width:300px; margin: auto;  padding: 5px;">' . $ret . '</div>';
    }

    public static function buildEtcItem($inv, $item) {
        $name = str_replace("'", "\\'", $item["name"]);
        $addname = L2Web::formatAddName(str_replace("'", "\\'", $item['add_name']));
        $grade = L2Web::getGradeImg($item['grade']);
        $count = $inv['count'];
        $desc = $item['desc'];
        $ret = $name . ' <font color="' . L2Web::$colors['yellow'] . '">' . $addname . '</font> ' . $grade . ' (' . $count . ')' .
                '<br />' .
                '<br /><font color="' . L2Web::$colors['grey'] . '">Weight :</font> <font color="' . L2Web::$colors['brown'] . '"> ' . $item['weight'] . '</font><br />';
        if ($desc != '') {
            $ret.= '<br /><font color="' . L2Web::$colors['clay'] . '">' . $desc . '</font>';
        }
        return '<div style="border: 1px solid #434034; background: #000000; width:300px; margin: auto;  padding: 5px;">' . $ret . '</div>';
    }

    private static function getWSAugment($id1, $id2) {
        global $sql;
        $a1 = $sql[0]->query('AUGMENT_DATA', array('id' => $id1));
        $aug1 = SQL::fetchArray($a1);

        $a2 = $sql[0]->query('AUGMENT_DATA', array('id' => $id2));
        $aug2 = SQL::fetchArray($a2);

        $color = L2Web::augColor($aug2['level']);
        return '<font color="' . $color . '">' . $aug1['desc'] . '<br />' . $aug2['desc'] . '</font>';
    }

    private static function getAugment($item_id, $srv) {
        global $sql;
        $aq = $sql[SQL_NEXT_ID + $srv]->query('GET_AUGMENT', array('id' => $item_id));
        if (!SQL::numRows($aq)) {
            return null;
        }

        $aug = SQL::fetchArray($aq);

        $a1 = $sql[0]->query('AUGMENT_DATA', array('id' => $aug['augAttributes'] % 65536));
        $aug1 = SQL::fetchArray($a1);

        $a2 = $sql[0]->query('AUGMENT_DATA', array('id' => floor($aug['augAttributes'] / 65536)));
        $aug2 = SQL::fetchArray($a2);

        $color = L2Web::augColor($aug2['level']);
        return '<font color="' . $color . '">' . $aug1['desc'] . '<br />' . $aug2['desc'] . '</font>';
    }

    public static function drawWElement($type, $value) {
        $lvl = 0;
        foreach (L2Web::$WEAPON_VALUES as $v) {
            if ($value < $v || $v == 450) {
                break;
            }
            $lvl++;
        }
        $name = L2Web::$elements[$type];
        $rcon = '';
        $width = ($value - L2Web::$WEAPON_VALUES[$lvl - 1]) / (L2Web::$WEAPON_VALUES[$lvl] - L2Web::$WEAPON_VALUES[$lvl - 1]);

        $rcon .= $name . ' Lv ' . $lvl . ' (' . $name . ' P. Atk. ' . $value . ')<br />';
        $rcon .= '<div class="element" style="background: url(img/elementals/' . $name . '_bg.png); background-repeat: repeat-x;"> ';
        $rcon .= '<div style="background: url(img/elementals/' . $name . '.png); background-repeat: repeat-x; width: ' . round($width * 175, 0) . 'px"></div>';
        $rcon .= '</div>';
        return $rcon;
    }

    public static function drawAElement($type, $value) {
        $lvl = 0;
        foreach (L2Web::$ARMOR_VALUES as $v) {
            if ($value < $v || $v == 450) {
                break;
            }
            $lvl++;
        }
        $name = L2Web::$elements[$type];
        $rcon = '';
        $aname = $type % 2 == 0 ? L2Web::$elements[$type + 1] : L2Web::$elements[$type - 1];
        $width = ($value - L2Web::$ARMOR_VALUES[$lvl - 1]) / (L2Web::$ARMOR_VALUES[$lvl] - L2Web::$ARMOR_VALUES[$lvl - 1]);

        $rcon .= $aname . ' Lv ' . $lvl . ' (' . $name . ' P. Def. ' . $value . ')<br />';
        $rcon .= '<div class="element" style="background: url(img/elementals/' . $name . '_bg.png); background-repeat: repeat-x;"> ';
        $rcon .= '<div style="background: url(img/elementals/' . $name . '.png); background-repeat: repeat-x; width: ' . round($width * 175, 0) . 'px"></div>';
        $rcon .= '</div>';
        return $rcon;
    }

    private static function getGradeImg($g) {
        if ($g == 0) {
            return;
        }
        return '<img border="0" src="img/grade/' . L2Web::getGrade($g) . '.png" />';
    }

    public static function getEnchant($i) {
        return $i > 0 ? '+' . $i . ' ' : '';
    }

    public static function getGrade($g) {
        switch ($g) {
            case 0:
                return 'no';
            case 1:
                return 'd';
            case 2:
                return 'c';
            case 3:
                return 'b';
            case 4:
                return 'a';
            case 5:
                return 's';
            case 6:
                return 's80';
            case 7:
                return 's84';
        }
    }

    public static function augColor($lvl) {
        switch ($lvl) {
            case 1:
                return L2Web::$colors['yellow'];
            case 2:
                return L2Web::$colors['blue'];
            case 3:
                return L2Web::$colors['purple'];
            case 4:
                return L2Web::$colors['red'];
        }
    }

    public static function formatCount($c) {
        return $c > 1 ? ' (' . number_format($c) . ')' : '';
    }

    public static function formatAddName($n) {
        return $n != '' ? ' - ' . $n : '';
    }

}
