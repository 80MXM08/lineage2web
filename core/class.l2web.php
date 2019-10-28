<?php

class L2WebH5old {

    static $l2web = [
        'body' => [
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
        ],
        'a' => [
            0 => 'None',
            1 => 'Light',
            2 => 'Heavy',
            3 => 'Robe',
            4 => 'Sigil',
        ],
        'e' => [
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
        ],
        'w' => [
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
        ],
        'parts' => [
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
        ],
    ];
    static $elements = [0 => 'Fire', 1 => 'Water', 2 => 'Wind', 3 => 'Earth', 4 => 'Holy', 5 => 'Dark'];
    static $FIRST_WEAPON_BONUS = 20;
    static $WEAPON_BONUS = 5;
    static $ARMOR_BONUS = 6;
    static $WEAPON_VALUES = [
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
    ];
    static $ARMOR_VALUES = [
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
    ];
    static $colors = [
        'white' => '#FFFFFF',
        'grey' => '#A0A0A0',
        'brown' => '#AE9978',
        'yellow' => '#FFD969',
        'clay' => '#B2BECF',
        'red' => '#F75959',
        'purple' => '#CC23B3',
        'blue' => '#5ACBED',
    ];

    /*
     * $inv - GS items data
     * $item - L2Web itemname data
     * $srv - Server id
     */
    static function buildArmor($inv, $item, $srv) {
        $aug = null;
        if ($srv == 'ws') {
            if (!$inv['augment']) {
		return;
            }
	    $aug = L2Web::getWSAugment($inv['augment']);
        } else {
            $aug = L2Web::getAugment($inv['object_id'], $srv);
        }
        if ($aug != null) {
            $name = 'Augmented ' . $item['name'];
        } else {
            $name = $item['name'];
        }
        $loc = $inv['loc'];
        $name = L2Web::formatName($name);
        //$addname = L2Web::formatAddName(str_replace("'", "\\'", $item['add_name']));
	$addname = L2Web::formatAddName($item['add_name']);
        $grade = L2Web::getGradeImg($item['grade']);
        $enchant = L2Web::getEnchant($inv['enchant_level']);
        $item_type = L2Web::getItemType('a', $item['item_type']);

        $grp = L2Web::getArmorInfo($item['id']);
        $hands = L2Web::getBodyPart($grp['body_part']);
        $desc = L2Web::formatDesc($item['desc']);

        $ench = $item['enchant_desc'];
        $ret = '<table border="0"><tr><td><img src="img/icons/'.$item['icon'].'.png" /></td><td><font color="' . L2Web::$colors['purple'] . '">' . $enchant . '</font> <font color="'.L2Web::$colors['white'].'">' . $name . '</font> <font color="' . L2Web::$colors['yellow'] . '">' . $addname . '</font> ' . $grade . ' ' . //$count.
                '<br /><font color="' . L2Web::$colors['brown'] . '">' . $item_type . $hands . '</font></td></tr></table>';
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
        $bnDsc = L2Web::getBonusDsc($inv, $item['bonus_desc'], $item['set_ids'], $item['enchant_amount'], $loc, $srv);
        $full = $bnDsc[0];
        $ret.=$bnDsc[1];
        $ret.=L2Web::getExtraDsc($inv, $item['extra_desc'], $item['extra_ids'], $srv, $loc, $full);

        if ($ench != '') {
            $color = ($full && $loc == 'PAPERDOLL') ? L2Web::$colors['white'] : L2Web::$colors['clay'];
            $ret.= '<br /><font color="' . $color . '">' . $ench . '</font><br />';
        }
        $element = '';
        if ($srv == 'ws') {
            foreach (explode(';', $inv['elementals']) as $elem) {
                if ($elem) {
                    $ele = explode(',', $elem);
                    $element .= L2Web::drawAElement($ele[0], $ele[1]) . '';
                }
            }
        } else {
            foreach (DAO::getInstance()::getElement($srv, $item['id']) as $ele) {
                $element .= L2Web::drawAElement($ele['elemType'], $ele['elemValue']) . '';
            }
        }
        if ($element != '') {
            $ret.= '<br />' . $element;
        }
        if ($srv == 'ws') {
            $ret.='<br /><a href="webshop.php?a=buy&id=' . $inv['id'] . '&srv=ws">' . button('buy', '', true) . '</a>';
        }
        return '<div style="border: 1px solid #434034; background: #000000; width:300px; margin: auto;  padding: 5px;">' . $ret . '</div>';
    }

    /*
     * $inv - GS items data
     * $item - L2Web itemname data
     * $srv - Server id
     */

    public static function buildWeapon($inv, $item, $srv) {
        //$type = L2Web::$l2web['parts'][$inv["loc_data"]];
        $enchant = L2Web::formatEnchant($inv['enchant_level']);
        if ($srv == 'ws') {
            if ($inv['augment']) {
                $ids = explode(',', $inv['augment']);
                $aug = L2Web::getWSAugment($ids[0], $ids[1]);
            } else {
                $aug = '';
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
        $addname = L2Web::formatAddName($item['add_name']);
        $grade = L2Web::getGradeImg($item['grade']);
        $item_type = L2Web::$l2web['w'][$item['item_type']];
        //$qry = $sql['core']->query('WEAPON_DATA', [':id' => $inv['item_id']]);
        //$grp = $qry->fetch(PDO::FETCH_ASSOC);
	$grp = DAO::getInstance()::getL2WItem()::getWeapon($inv['item_id']);
        $hands = L2Web::$l2web['body'][$grp['body_part']];

        $desc = $item['desc'];
        $ret = '<font color="' . L2Web::$colors['brown'] . '">' . $enchant . '</font> ' . $name . ' <font color="' . L2Web::$colors['yellow'] . '">' . $addname . '</font> ' . $grade . //$count.
                '<br /><br /><font color="' . L2Web::$colors['brown'] . '">' . $item_type;
        $ret.=($item['item_type'] != '0') ? ' / ' . $hands : '';
        $ret.='</font><br />';
        if ($item['item_type'] != '0') { // not shield
	    //TODO: find enchant type2 = blessed/R-grade/normal
            $patk = $grp['patt'] + L2Web::getAddAttack($inv['enchant_level'], L2Web::getPEnchant($item['item_type'], ''));
            $matk = $grp['matt'] + L2Web::getAddAttack($inv['enchant_level'], L2Web::getMEnchant($item['item_type'], ''));

            $ret.=
                    '<br /><b><font color="' . L2Web::$colors['grey'] . '">&lt;Weapon Specifications&gt;</font></b>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">P. Atk. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $patk . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">M. Atk. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $matk . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Atk. Spd. :</font> <font color="' . L2Web::$colors['brown'] . '">' . $grp['speed'] . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Soulshot Used :</font> <font color="' . L2Web::$colors['brown'] . '">X ' . $grp['SS_count'] . '</font>' .
                    '<br /><font color="' . L2Web::$colors['grey'] . '">Spiritshot Used :</font> <font color="' . L2Web::$colors['brown'] . '">X ' . $grp['SPS_count'] . '</font>';
        } else {
            $pdef = $grp['shield_pdef'] + L2Web::getAttack($inv['enchant_level'], L2Web::getSEnchant($item['item_type']));

            //$pdef = $grp['shield_pdef'] + ($inv['enchant_level']);
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
                if ($elem) {
                    $ele = explode(',', $elem);
                    $element .= L2Web::drawWElement($ele[0], $ele[1]) . '';
                }
            }
        } else {
            //$sql[$srv]->query('GET_ELEMENTS', array('id' => $inv['object_id']));
            foreach(DAO::getInstance()::getElement($srv, $inv['object_id']) as $ele) {
                $element .= L2Web::drawWElement($ele['elemType'], $ele['elemValue']) . '';
            }
        }
        if ($element != '') {
            $ret.= '<br />' . $element;
        }
        return '<div style="border: 1px solid #434034; background: #000000; width:300px; margin: auto;  padding: 5px;">' . $ret . '</div>';
    }

    private static function getMEnchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 8;
            case 'R-GRADE':
                return 5;
            default:
                return 4;
        }
    }
    private static function getMO3Enchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 16;
            case 'R-GRADE':
                return 10;
            default:
                return 8;
        }
    }
    private static function getMO6Enchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 24;
            case 'R-GRADE':
                return 15;
            default:
                return 8;
        }
    }
    private static function getAEnchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 3;
            case 'R-GRADE':
                return 2;
            default:
                return 1;
        }
    }

    private static function getAO3Enchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 6;
            case 'R-GRADE':
                return 4;
            default:
                return 3;
        }
    }

    private static function getAO6Enchant($type) {
        switch ($type) {
            case 'BLESSED':
                return 9;
            case 'R-GRADE':
                return 6;
            default:
                return 3;
        }
    }

    private static function getPEnchant($type, $type2) {
        switch ($type) {
            case 5: //fist
            case 8: //dual sword
            case 9:
            case 13: //ancient sword
            case 15: //dual dagger
                switch ($type2) {
                    case 'BLESSED':
                        return 7;
                    case 'R-GRADE':
                        return 7;
                    default:
                        return 6;
                }
            case 6: //Bow
            case 12: //Crossbow
                switch ($type2) {
                    case 'BLESSED':
                        return 12;
                    case 'R-GRADE':
                        return 12;
                    default:
                        return 10;
                }
            default:
                switch ($type2) {
                    case 'BLESSED':
                        return 9;
                    case 'R-GRADE':
                        return 6;
                    default:
                        return 5;
                }
        }
    }
    public static function getEnchant($i) {
        return $i > 0 ? '+' . $i . ' ' : '';
    }
    /*private static function getWSAugment($id1, $id2) {
        global $sql;
        $a1 = $sql[0]->query('AUGMENT_DATA', array('id' => $id1));
        $aug1 = SQL::fetchArray($a1);

        $a2 = $sql[0]->query('AUGMENT_DATA', array('id' => $id2));
        $aug2 = SQL::fetchArray($a2);

        $color = L2Web::augColor($aug2['level']);
        return '<font color="' . $color . '">' . $aug1['desc'] . '<br />' . $aug2['desc'] . '</font>';
    }*/
    private static function getPO3Enchant($type, $type2) {
        switch ($type) {
            case 5: //fist
            case 8: //dual sword
            case 9:
            case 13: //ancient sword
            case 15: //dual dagger
                switch ($type2) {
                    case 'BLESSED':
                        return 7;
                    case 'R-GRADE':
                        return 7;
                    default:
                        return 12;
                }
            case 6: //Bow
            case 12: //Crossbow
                switch ($type2) {
                    case 'BLESSED':
                        return 12;
                    case 'R-GRADE':
                        return 12;
                    default:
                        return 20;
                }
            default:
                switch ($type2) {
                    case 'BLESSED':
                        return 18;
                    case 'R-GRADE':
                        return 12;
                    default:
                        return 10;
                }
        }
    }
        private static function getPO6Enchant($type, $type2) {
        switch ($type) {
            case 5: //fist
            case 8: //dual sword
            case 9:
            case 13: //ancient sword
            case 15: //dual dagger
                switch ($type2) {
                    case 'BLESSED':
                        return 7;
                    case 'R-GRADE':
                        return 7;
                    default:
                        return 6;
                }
            case 6: //Bow
            case 12: //Crossbow
                switch ($type2) {
                    case 'BLESSED':
                        return 12;
                    case 'R-GRADE':
                        return 12;
                    default:
                        return 10;
                }
            default:
                switch ($type2) {
                    case 'BLESSED':
                        return 27;
                    case 'R-GRADE':
                        return 18;
                    default:
                        return 10;
                }
        }
    }
    private static function getAddDefense($level, $type) {
        $enc = L2Web::getAEnchant($type);
        $o3enc = L2Web::getAO3Enchant($type);
        $o6enc = L2Web::getAO6Enchant($type);

        if ($level > 6) {
            return ($level - 6) * $o6enc + ($level - 3) * $o3enc + (3 * $enc);
        } else if ($level > 3) {
            return ($level - 3) * $o3enc + (3 * $enc);
        } else {
            return $level * $enc;
        }
    }

    private static function getAddDefenseRGrade($level) {
        $enc = L2Web::getRGradeAEnchant();
        $oenc = L2Web::getRGradeAOEnchant();
        if ($level > 3) {
            $atk = ($level - 3) * $oenc + (3 * $enc);
        } else {
            $atk = ($level * $enc);
        }
        return $atk;
    }

    private static function getAddDefenseBlessed($level) {
        $enc = L2Web::getBlessedAEnchant();
        $oenc = L2Web::getBlessedAOEnchant();
        if ($level > 3) {
            $atk = ($level - 3) * $oenc + (3 * $enc);
        } else {
            $atk = ($level * $enc);
        }
        return $atk;
    }

    private static function getAddAttack($level, $enc) {
        if ($level > 3) {
            $atk = ($level - 3) * $enc * 2 + (3 * $enc);
        } else {
            $atk = ($level * $enc);
        }
        return $atk;
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

    static function getArmorInfo($id) {
	return DAO::getInstance()::getL2WItem()::getArmor($id);
    }
    /*static function getWSAugment($id, $srv) {
        global $sql;
        if ($srv == 'ws') {
            $ids = explode(',', $id);
            $id1 = $ids[0];
            $id2 = $ids[1];
        } else {
            $aq = $sql[$srv]->query('GET_AUGMENT', [':id' => $id]);
            if (!$aq->rowCount()) {
                return null;
            }
            $aug = $aq->fetch(PDO::FETCH_ASSOC);
            $id1 = $aug['augAttributes'] % 65536;
            $id2 = floor($aug['augAttributes'] / 65536);
        }
        $a1 = $sql['core']->query('AUGMENT_DATA', [':id' => $id1]);
        $aug1 = $a1->fetch(PDO::FETCH_ASSOC);

        $a2 = $sql['core']->query('AUGMENT_DATA', [':id' => $id2]);
        $aug2 = $a2->fetch(PDO::FETCH_ASSOC);

        $color = L2Web::augColor($aug2['level']);
        return '<font color="' . $color . '">' . $aug1['desc'] . '<br />' . $aug2['desc'] . '</font>';
    }*/
    static function getAugment($id, $srv) {
        global $sql;
        if ($srv == 'ws') {
            $ids = explode(',', $id);
            $id1 = $ids[0];
            $id2 = $ids[1];
        } else {
            $aq = $sql[$srv]->query('GET_AUGMENT', [':id' => $id]);
            if (!$aq->rowCount()) {
                return null;
            }
            $aug = $aq->fetch(PDO::FETCH_ASSOC);
            $id1 = $aug['augAttributes'] % 65536;
            $id2 = floor($aug['augAttributes'] / 65536);
        }
        //$a1 = $sql['core']->query('AUGMENT_DATA', [':id' => $id1]);
        //$aug1 = $a1->fetch(PDO::FETCH_ASSOC);
	$aug1 = DAO::getInstance()::getL2WItem()::getAugment($id1);
        //$a2 = $sql['core']->query('AUGMENT_DATA', [':id' => $id2]);
        //$aug2 = $a2->fetch(PDO::FETCH_ASSOC);
	$aug2 = DAO::getInstance()::getL2WItem()::getAugment($id2);
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

    static function formatEnchant($i) {
        return $i > 0 ? '+' . $i . ' ' : '';
    }

    static function getItemType($part, $type) {
        return ($type != 0) ? L2Web::$l2web[$part][$type] . ' / ' : '';
    }

    static function getGrade($g) {
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
            case 8:
                return 'r85';
            case 9:
                return 'r95';
            case 10:
                return 'r99';
        }
    }

    static function augColor($lvl) {
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

    static function formatCount($c) {
        return $c > 1 ? ' (' . number_format($c) . ')' : '';
    }

    static function formatName($n) {
	return $n;
        //return str_replace("'", "\\'", $n);
    }

    static function formatAddName($n) {
        return $n != '' ? ' - ' . str_replace("'", "\\'", $n) : '';
    }

    static function formatDesc($d) {
        return ($d != '') ? str_replace(array("'", "<"), array("\\'", "&lt;"), $d) : '';
    }

    static function getBodyPart($p) {
        return L2Web::$l2web['body'][$p];
    }

    static function getBonusDsc($inv, $bonus, $set, $reqEnch, $loc, $srv) {
        $full = false;
        $text = '';
        if ($bonus == '' || $set == '') {
            return;
        }

        $parts = explode(';', $set);
        $sParts = L2Web::checkSetParts($inv, $parts, $reqEnch, $loc, $srv);
        $text.=$sParts[1];
        if ($sParts[0] == count($parts) && $loc == 'PAPERDOLL') {
            $full = true;
            $color = L2Web::$colors['yellow'];
        } else {
            $color = L2Web::$colors['brown'];
        }
        $text.= '<br /><font color="' . $color . '">' . $bonus . '</font><br />';
        return [$full, $text];
    }

    static function checkSetParts($inv, $parts, $req, $loc, $srv) {
        //global $sql;
        $enchS = 0;
        $setS = 0;
        $text = '';
        foreach ($parts as $part) {
            if ($part == $inv['item_id']) {
                $setS++;
                if ($inv['enchant_level'] >= $req) {
                    $enchS++;
                }
                continue;
            }
            //$a = $sql['core']->query('GET_ITEM_NAME', [':id' => $part]);
            //if (!$a->rowCount()) {
            //    die('UNKNOWN ID - '.$part);
            //}
            //$it = $a->fetch(PDO::FETCH_ASSOC);
	    $it = DAO::getInstance()::getL2WItem()::getItemName($part);
            $part_name = $it['name'];
            if ($loc == 'PAPERDOLL') {
                //$b = $sql[$srv]->query('GET_ENCHANT', [':oId' => $inv['owner_id'], ':iId' => $part, ':loc' => 'PAPERDOLL']);
		$p = DAO::getInstance()::getItem()::getEnchant($srv, $inv['owner_id'], $part, $loc);
                //if ($b->rowCount()) {
		if ($p) {
                    //$p = $b->fetch(PDO::FETCH_ASSOC);
                    $color = L2Web::$colors['white'];
                    $setS++;
                    if ($p['enchant_level'] >= $req) {
                        $enchS++;
                    }
                } else {
                    $color = L2Web::$colors['grey'];
                }
            } else {
                $color = L2Web::$colors['grey'];
            }

            $text.= '<br /><font color="' . $color . '">' . $part_name . '</font>';
        }
        return [$setS, $text];
    }

    static function getExtraDsc($inv, $extra, $extraI, $srv, $loc, $full) {

        if ($extra == '' || $extraI == '') {
            return;
        }
	$text = '';
	$parts = explode(';', $extraI);
	$c = [false, L2Web::$colors['grey'], ''];
	foreach ($parts as $part) {
	    $c = L2Web::checkExtraPart($inv, $part, $srv, $loc);
	    if ($c[0] == true) {
		break;
	    }
	}
	if ($c[1] == '') {
	    $c[1] = L2Web::$colors['grey'];
	}
	$text.= '<br /><font color="' . $c[1] . '">' . $c[2] . '</font>';
	$color2 = $full && $c[0] ? L2Web::$colors['yellow'] : L2Web::$colors['brown'];
	$text.= '<br /><font color="' . $color2 . '">' . $extra . '</font><br />';
	return $text;
    }

    static function checkExtraPart($inv, $id, $srv, $loc) {
        global $sql;
        $color = '';
        $extra = false;
        //$a = $sql['core']->query('GET_ITEM_NAME', [':id' => $id]);
	$a = DAO::getInstance()::getL2WItem()::getItemName($id);
	//$it = $a->fetch(PDO::FETCH_ASSOC);
        $name = $a['name'];
        if (!$name) {
            die('UNKNOWN ID - '. $id);
        }
        
        if ($srv != 'ws' || $loc != 'PAPERDOLL') {
            $b = $sql[$srv]->query('GET_ENCHANT', [':oId' => $inv['owner_id'], ':iId' => $id, ':loc' => 'PAPERDOLL']);
	    //TODO enchant +6????
            if ($b->rowCount()) {
                $color = L2Web::$colors['white'];
                $extra = true;
            }
        }
        return [$extra, $color, $name];
    }

    static function drawItem($item, $sId, $type = '') {
	$info = DAO::getInstance()::getL2WItem()::getItem($item['item_id']);
        $name = $info['name'];
        $addname = L2Web::formatAddName($info['add_name']);
        $enc = L2Web::formatEnchant($item['enchant_level']);
        if ($type == 'P') {
            $class = L2Web::$l2web['parts'][$item['loc_data']];
            $count = '';
            $style = 'position: absolute; width: 32px; height: 32px; padding: 0px;';
        } else {
            $class = 'floated';
            $count = L2Web::formatCount($item['count']);
            $style = '';
        }
        return '<div style="' . $style . '" class="' . $class . '"><a href="actions.php?a=item_data&id=' . $item['object_id'] . '&srv=' . $sId . '" class="item_info"><img border="0" src="img/icons/' . $info['icon'] . '.png" alt="' . $name . '" title="' . $enc . $name . $addname . $count . '" /></a></div>';
    }
    static function getItemData($srv, $id)
{
    if ($srv == 'ws') {
            $inv = DAO::getInstance()::getL2WItem()::getWebshop($id);
        } else {
            $inv = DAO::getInstance()::getItem()::get($srv, $id);
        }
        if (!$inv) {
            return;
        }
 
        $item = DAO::getInstance()::getL2WItem()::getItem($inv['item_id']);
        switch ($item['type']) {
            case 'w':
                echo L2Web::buildWeapon($inv, $item, $srv);
                break;
            case 'a':
                echo L2Web::buildArmor($inv, $item, $srv);
                break;
            case 'e':
                echo L2Web::buildEtcItem($inv, $item);
                break;
        }
}
}
