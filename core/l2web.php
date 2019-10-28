<?php

class L2WEB
{

	static function init($engine)
	{
		switch ($engine)
		{
			case "C1":
			case "C2":
			case "C3":
			case "C4":
			case "C5":
			default:
				{
					exit('Not supported!');
				}

			case "h5":
				{
					return new L2WEBH5();
				}
		}
	}
}

class L2WEBH5 //implements iL2WEB
{
	static $l2web				 = [
		'body'	 => [
			0	 => 'Bracelet', // (aga)     weapon - pet weapon
			1	 => 'Earring',
			3	 => 'Necklace',
			4	 => 'Ring',
			6	 => 'Headgear',
			7	 => 'Two-Handed',
			8	 => 'Upper and lower body',
			9	 => 'Dress',
			10	 => 'Hair accessory',
			19	 => 'Belt',
			20	 => 'Gloves',
			21	 => 'Upper body',
			22	 => 'Lower body',
			23	 => 'Boots',
			24	 => 'Cloak',
			25	 => 'Hair accessory',
			26	 => 'Hair accessory',
			27	 => 'One-Handed',
			28	 => 'Sigil',
			29	 => 'Bracelet',
		],
		'a'		 => [
			0	 => 'None',
			1	 => 'Light',
			2	 => 'Heavy',
			3	 => 'Robe',
			4	 => 'Sigil',
		],
		'e'		 => [
			0	 => 'None',
			1	 => 'Scroll', //Soul Crystal
			2	 => 'Arrow, Bolt', //(Arrow)
			3	 => 'Potion',
			5	 => 'Recipe',
			6	 => 'Material',
			7	 => 'Pet',
			8	 => 'Mercenary Ticket',
			9	 => 'Dye',
			10	 => 'Seed',
			11	 => 'Seed', // (Alternative)
			12	 => 'Other', // (Harvester)
			13	 => 'Other', // (Lottery Ticket)
			14	 => 'Other', // (Monster Race Ticket)
			15	 => 'Other', // (Certificate of Approval)
			16	 => 'Lure',
			17	 => 'Seed',
			18	 => 'Seed', // (Alternative)
			19	 => 'Scroll', // (pc cafe enchants??????weapon)
			20	 => 'Scroll', // (pc cafe enchants??????armor)
			21	 => 'Event', // (bleesed weapon)
			22	 => 'Scroll', // (blessed armor)
			23	 => 'Other', // (Weapon Exchange Coupon NO/C-Grade)
			24	 => 'Potion', // (Elixirs)
			25	 => 'Scroll', // (Elemental)
			26	 => 'Arrow, Bolt', // (Bolt)
			27	 => 'Scroll', // (weapon backup stone)
			28	 => 'Scroll', // (armor backup stone)
			31	 => 'Scroll', // (divine armor enchant)
			32	 => 'Scroll', // (divine weapon enchant)
			33	 => 'Rune',
			34	 => 'Rune',
			35	 => 'Scroll', // (my teleport)
		],
		'w'		 => [
			0	 => 'Shield',
			1	 => 'Sword',
			2	 => 'Blunt',
			3	 => 'Dagger',
			4	 => 'Polearm',
			5	 => 'Fist',
			6	 => 'Bow',
			7	 => 'Etc',
			8	 => 'Dual Sword',
			9	 => '',
			10	 => 'Rod',
			11	 => 'Rapier',
			12	 => 'Crossbow',
			13	 => 'Ancient',
			15	 => 'Dual Dagger',
			16	 => 'Flag, Ward',
		],
		'parts'	 => [
			0	 => 'dress',
			1	 => 'helm',
			2	 => 'leftthair',
			3	 => 'righthair',
			4	 => 'necklace',
			5	 => 'weapon',
			6	 => 'body',
			7	 => 'shield',
			8	 => 'rightear',
			9	 => 'leftear',
			10	 => 'gloves',
			11	 => 'legs',
			12	 => 'boots',
			13	 => 'rightring',
			14	 => 'leftring',
			15	 => 'ring',
			16	 => 'bracelet',
			17	 => 'deco1',
			18	 => 'deco2',
			19	 => 'deco3',
			20	 => 'deco4',
			21	 => 'deco5',
			22	 => 'deco6',
			23	 => 'cloak',
			24	 => 'belt',
			25	 => 'total',
		],
	];
	static $elements			 = [0 => 'Fire', 1 => 'Water', 2 => 'Wind', 3 => 'Earth', 4 => 'Holy', 5 => 'Dark'];
	static $FIRST_WEAPON_BONUS	 = 20;
	static $WEAPON_BONUS		 = 5;
	static $ARMOR_BONUS			 = 6;
	static $WEAPON_VALUES		 = [
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
	static $ARMOR_VALUES		 = [
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
	static $colors				 = [
		'white'	 => '#FFFFFF',
		'grey'	 => '#A0A0A0',
		'brown'	 => '#AE9978',
		'yellow' => '#FFD969',
		'clay'	 => '#B2BECF',
		'red'	 => '#F75959',
		'purple' => '#CC23B3',
		'blue'	 => '#5ACBED',
	];
	static $type_colors			 = [
		0	 => '#A0A0A0', //common
		1	 => '#FFFFFF', //normal
		2	 => '#FCF804', //master
		3	 => '#CC23B3', //boss
		4	 => '#5ACBED' //hero
	];

	/*
	 * $inv - GS items data
	 * $item - L2WEBH5 itemname data
	 * $srv - Server id
	 */

	static function buildWeapon($inv, $item)
	{
		global $Lang;

		$grp		 = DAO::getInstance()::getL2WItem()::getWeapon($inv['item_id']);
		$item_type	 = L2WEBH5::$l2web[$item['type']][$item['type2']];
		$hands		 = $item['type'] == 'w' && $item['type2'] == 0 ? '' : ' / ' . L2WEBH5::$l2web['body'][$item['body_part']];
		$type		 = '<br /><br /><span style="color:' . L2WEBH5::$colors['brown'] . ';">' . $item_type . $hands . '</span><br />';

		$mpconsume = L2WEBH5::formatStat($Lang['__mp-consume_'], $grp['mp_consume']);

		$atkspeed	 = L2WEBH5::formatStat($Lang['__atk-speed_'], $grp['speed']);
		$ss_count	 = L2WEBH5::formatStat($Lang['__ss-count_'], 'X ' . $grp['ss_count']);
		$sps_count	 = L2WEBH5::formatStat($Lang['__sps-count_'], 'X ' . $grp['sps_count']);
		$epatk		 = L2WEBH5::getWEnchant($inv['enchant_level'], L2WEBH5::getPAtk($item['type2'], $item['grade']));
		$ematk		 = L2WEBH5::getWEnchant($inv['enchant_level'], L2WEBH5::getMAtk($item['grade']));

		$patk	 = $grp['patt'] + $epatk;
		$matk	 = $grp['matt'] + $ematk;
		$sepatk	 = $epatk > 0 ? ' (' . $grp['patt'] . ' <span style="color:' . L2WEBH5::$colors['yellow'] . '">+ ' . $epatk . '</span>)' : '';
		$sematk	 = $ematk > 0 ? ' (' . $grp['matt'] . ' <span style="color:' . L2WEBH5::$colors['yellow'] . '">+ ' . $ematk . '</span>)' : '';

		$spatk	 = L2WEBH5::formatStat($Lang['__patk_'], $patk . $sepatk);
		$smatk	 = L2WEBH5::formatStat($Lang['__matk_'], $matk . $sematk);
		$weight	 = L2WEBH5::formatStat($Lang['__weight_'], $item['weight']);
		return '<br /><b><span style="color:' . L2WEBH5::$colors['grey'] . '">'.$Lang['__weapon-specs_'].'</span></b>' .
				$type . $spatk . $smatk . $atkspeed . $ss_count . $sps_count . $weight . $mpconsume . '<br />';
	}

	static function buildShield($inv, $item)
	{
		global $Lang;

		$grp	 = DAO::getInstance()::getL2WItem()::getWeapon($inv['item_id']);
		$epdef	 = L2WEBH5::getAEnchant($inv['enchant_level']);
		$pdef	 = $grp['shield_pdef'] + $epdef;
		$sepdef	 = $epdef > 0 ? ' (' . $grp['shield_pdef'] . ' <span style="color:' . L2WEBH5::$colors['yellow'] . ';">+ ' . $epdef . '</span>)' : '';

		$hands		 = '<br /><br /><span style="color:' . L2WEBH5::$colors['brown'] . ';">' . L2WEBH5::$l2web[$item['type']][$item['type2']] . '</span><br />';
		$spdef		 = L2WEBH5::formatStat($Lang['__sdef_'], $pdef . $sepdef);
		$defrate	 = L2WEBH5::formatStat($Lang['__def-rate_'], $grp['shield_rate']);
		$evasion	 = L2WEBH5::formatStat($Lang['__evasion_'], $grp['avoid_mod']);
		$mpconsume	 = L2WEBH5::formatStat($Lang['__mp-consume_'], $grp['mp_consume']);
		$weight		 = L2WEBH5::formatStat($Lang['__weight_'], $item['weight']);

		return $hands . $spdef . $defrate . $evasion . $mpconsume . $weight . '<br />';
	}

	static function buildArmor($inv, $item, $srv)
	{
		global $Lang;

		$ret		 = '';
		$hands		 = L2WEBH5::$l2web['body'][$item['body_part']];
		$item_type	 = $item['type2'] == 0 || $item['type2'] == 4 ? '' : ' / ' . L2WEBH5::$l2web[$item['type']][$item['type2']];
		$ret		 .= '<br /><br /><span style="color:' . L2WEBH5::$colors['brown'] . ';">' . $hands . $item_type . '</span>';
		$grp		 = DAO::getInstance()::getL2WItem()::getArmor($item['id']);
		$edef		 = L2WEBH5::getAEnchant($inv['enchant_level']);

		if ($grp['pdef'])
		{
			$pdef	 = $grp['pdef'] + $edef;
			$sepdef	 = $edef > 0 ? ' (' . $grp['pdef'] . ' <span style="color:' . L2WEBH5::$colors['yellow'] . ';">+ ' . $edef . '</span>)' : '';
			$spdef	 = L2WEBH5::formatStat($Lang['__pdef_'], $pdef . $sepdef);
			$ret	 .= $spdef;
		}
		if ($grp['mdef'])
		{
			$mdef	 = $grp['mdef'] + $edef;
			$semdef	 = $edef > 0 ? ' (' . $grp['mdef'] . ' <span style="color:' . L2WEBH5::$colors['yellow'] . ';">+ ' . $edef . '</span>)' : '';
			$smdef	 = L2WEBH5::formatStat($Lang['__mdef_'], $mdef . $semdef);
			$ret	 .= $smdef;
		}
		if ($grp['mpbonus'])
		{
			$ret .= L2WEBH5::formatStat($Lang['__mpbonus_'], $grp['mpbonus']);
		}
		$ret	 .= L2WEBH5::formatStat($Lang['__weight_'], $item['weight']) . '<br />';
		$ench6	 = false;
		if ($item['body_part'] == 21 || $item['body_part'] == 8)
		{
			$bnDsc	 = L2WEBH5::getBonusDsc($inv, $grp['bonus_desc'], $grp['set'], $grp['enchant_amount'], $inv['loc'], $srv);
			$full	 = $bnDsc[0];
			$ret	 .= $bnDsc[1];
			$ench6	 = $bnDsc[2];
			$ret	 .= L2WEBH5::getExtraDsc($inv, $grp['extra_desc'], $grp['extra_ids'], $srv, $inv['loc'], $full);
		}
		if ($grp['enchant_desc'] != '')
		{
			$color	 = ($ench6 || ($grp['enchant_amount'] != null && $grp['set'] == null && $inv['enchant_level'] >= $grp['enchant_amount'])) ? L2WEBH5::$colors['white'] : L2WEBH5::$colors['clay'];
			$ret	 .= '<br /><span style="color:' . $color . ';">' . $grp['enchant_desc'] . '</span><br />';
		}

		return $ret;
	}

	static function augColor($lvl)
	{
		switch ($lvl)
		{
			case 1:
				return L2WEBH5::$colors['yellow'];
			case 2:
				return L2WEBH5::$colors['blue'];
			case 3:
				return L2WEBH5::$colors['purple'];
			case 4:
				return L2WEBH5::$colors['red'];
		}
	}

	static function getAugment($id, $srv)
	{
		if ($srv == 'ws')
		{
			$ids = explode(',', $id);
			$id1 = $ids[0];
			$id2 = $ids[1];
		}
		else
		{
			$aug = DAO::getInstance()::getItem()::getAugment($srv, $id);
			if (!$aug)
			{
				return false;
			}
			$id1 = $aug['augAttributes'] % 65536;
			$id2 = floor($aug['augAttributes'] / 65536);
		}
		$aug1	 = DAO::getInstance()::getL2WItem()::getAugment($id1);
		$aug2	 = DAO::getInstance()::getL2WItem()::getAugment($id2);
		return '<span style="color:' . L2WEBH5::augColor($aug2['level']) . ';">' . $aug1['effect'] . '<br />' . $aug2['effect'].'</span>';
	}

	private static function getAEnchant($level)
	{
		return $level > 3 ? ($level - 3) * 2 + $level : $level;
	}

	private static function getWEnchant($level, $enc_val)
	{
		return $level > 3 ? $level * $enc_val + ($level - 3) * $enc_val : $level * $enc_val;
	}

	private static function getMAtk($grade)
	{
		switch ($grade)
		{
			case 0:
			case 1:
				return 2;
			case 2:
			case 3:
			case 4:
				return 3;
			default:
				return 4;
		}
	}

	private static function getPAtk($type, $grade)
	{
		switch ($grade)
		{
			case 0:
			case 1:
				return $type == 6 ? 4 : 2;
			case 2:
			case 3:
				switch ($type)
				{
					case 5: //fist
					case 8: //dual sword
					case 9:
					case 13: //ancient sword
					case 15: //dual dagger
						return 4;
					case 6: //Bow
					case 12: //Crossbow
						return 6;
					default:
						return 3;
				}
			case 4:
				switch ($type)
				{
					case 5: //fist
					case 8: //dual sword
					case 9:
					case 13: //ancient sword
					case 15: //dual dagger
						return 5;
					case 6: //Bow
					case 12: //Crossbow
						return 8;
					default:
						return 4;
				}
			default:
				switch ($type)
				{
					case 5: //fist
					case 8: //dual sword
					case 9:
					case 13: //ancient sword
					case 15: //dual dagger
						return 6;
					case 6: //Bow
					case 12: //Crossbow
						return 10;
					default:
						return 5;
				}
		}
	}

	private static function drawElements($srv, $type, $elements)
	{
		$element = '';
		if ($srv == 'ws')
		{
			foreach (explode(';', $elements) as $elem)
			{
				if (!$elem)
				{
					continue;
				}
				$ele	 = explode(',', $elem);
				$element .= L2WEBH5::drawElement($type, $ele[0], $ele[1]);
			}
		}
		else
		{
			$eleme = DAO::getInstance()::getElement()::get($srv, $elements);
			if ($eleme)
			{
				foreach ($eleme as $ele)
				{
					$element .= L2WEBH5::drawElement($type, $ele['elemType'], $ele['elemValue']);
				}
			}
		}
		return $element;
	}

	private static function drawElement($itype, $e, $val)
	{
		if ($itype == 'w')
		{
			return L2WEBH5::drawWElement($e, $val);
		}
		else
		{
			return L2WEBH5::drawAElement($e, $val);
		}
	}

	public static function drawWElement($type, $value)
	{
		$lvl = 0;
		foreach (L2WEBH5::$WEAPON_VALUES as $v)
		{
			if ($value < $v || $v == 450)
			{
				break;
			}
			$lvl++;
		}
		$name	 = L2WEBH5::$elements[$type];
		$width	 = ($value - L2WEBH5::$WEAPON_VALUES[$lvl - 1]) / (L2WEBH5::$WEAPON_VALUES[$lvl] - L2WEBH5::$WEAPON_VALUES[$lvl - 1]);

		return $name . ' Lv ' . $lvl . ' (' . $name . ' P. Atk. ' . $value . ')<br />' .
				'<div class="element" style="background: url(img/elementals/' . $name . '_bg.png); background-repeat: repeat-x;"> ' .
				'<div style="background: url(img/elementals/' . $name . '.png); background-repeat: repeat-x; width: ' . round($width * 175, 0) . 'px"></div></div>';
	}

	public static function drawAElement($type, $value)
	{
		$lvl = 0;
		foreach (L2WEBH5::$ARMOR_VALUES as $v)
		{
			if ($value < $v || $v == 450)
			{
				break;
			}
			$lvl++;
		}
		$name	 = L2WEBH5::$elements[$type];
		$aname	 = $type % 2 == 0 ? L2WEBH5::$elements[$type + 1] : L2WEBH5::$elements[$type - 1];
		$width	 = ($value - L2WEBH5::$ARMOR_VALUES[$lvl - 1]) / (L2WEBH5::$ARMOR_VALUES[$lvl] - L2WEBH5::$ARMOR_VALUES[$lvl - 1]);

		return $aname . ' Lv ' . $lvl . ' (' . $name . ' P. Def. ' . $value . ')<br />' .
				'<div class="element" style="background: url(img/elementals/' . $name . '_bg.png); background-repeat: repeat-x;"> ' .
				'<div style="background: url(img/elementals/' . $name . '.png); background-repeat: repeat-x; width: ' . round($width * 175, 0) . 'px"></div></div>';
	}

	private static function getGradeImg($g)
	{
		return $g != 0 ? '<img border="0" src="img/grade/' . L2WEBH5::getGrade($g) . '.png" />' : '';
	}

	static function getGrade($g)
	{
		switch ($g)
		{
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

	static function formatCount($c)
	{
		return $c > 1 ? ' (' . number_format($c) . ')' : '';
	}

	static function formatName($s, $type)
	{
		return $s ? '<span style="color:' . L2WEBH5::$type_colors[$type] . ';">' . $s . '</span> ' : '';
	}

	static function formatAddName($n)
	{
		return $n ? '<span style="color:' . L2WEBH5::$colors['yellow'] . ';"> - ' . $n . '</span> ' : '';
	}
static function formatSkillAddName($n)
	{
		return $n ? '<span style="color:' . L2WEBH5::$colors['yellow'] . ';"> ' . $n . '</span> ' : '';
	}
	static function formatEnchant($i)
	{
		return $i > 0 ? '<span style="color:' . L2WEBH5::$colors['brown'] . ';">+ ' . $i . '</span> ' : '';
	}

	static function formatStat($title, $stat)
	{
		return $stat > 0 ? '<br /><span style="color:' . L2WEBH5::$colors['grey'] . ';">' . $title . ' :</span> <span style="color:' . L2WEBH5::$colors['brown'] . ';"> ' . $stat . '</span>' : '';
	}

	static function formatDesc($d)
	{
		return $d;
	}

	private static function getBonusDsc($inv, $bonus, $set, $reqEnch, $loc, $srv)
	{
		$full	 = false;
		$text	 = '';
		if ($bonus == '' || $set == '')
		{
			return;
		}

		$parts	 = explode('::', $set);
		$sParts	 = L2WEBH5::checkSetParts($inv, $parts, $reqEnch, $loc, $srv);
		$text	 .= $sParts[2];
		if ($sParts[0] == count($parts) && $loc == 'PAPERDOLL')
		{
			$full	 = true;
			$color	 = L2WEBH5::$colors['yellow'];
		}
		else
		{
			$color = L2WEBH5::$colors['brown'];
		}
		$text .= '<br /><span style="color:' . $color . ';">' . $bonus . '</span><br />';
		return [$full, $text, count($parts) == $sParts[1]];
	}

	private static function checkSetParts($inv, $parts, $req, $loc, $srv)
	{
		$enchS		 = 0;
		$setS		 = 0;
		$text		 = '';
		$color		 = '';
		$part_name	 = '';
		foreach ($parts as $part)
		{
			//$part	 = str_replace(':', '', $part);
			$part2 = explode(':', $part);

			foreach ($part2 as $p2)
			{
				if ($p2 == '' || $p2 == null)
				{
					continue;
				}
				if ($p2 == $inv['item_id'])
				{
					if ($inv['enchant_level'] >= $req)
					{
						$enchS++;
					}
					$setS++;
					continue;
				}

				$part_name	 = DAO::getInstance()::getL2WItem()::getItemName($p2);
				$color		 = L2WEBH5::$colors['grey'];

				if ($loc != 'PAPERDOLL')
				{
					continue;
				}
				$p = DAO::getInstance()::getItem()::getEnchant($srv, $inv['owner_id'], $p2, $loc);
				if (!$p)
				{
					continue;
				}
				if ($p >= $req)
				{
					$enchS++;
				}
				$color = L2WEBH5::$colors['white'];
				$setS++;
			}
			$text .= '<span style="color:' . $color . ';">' . $part_name . '</span><br />';
		}
		return [$setS, $enchS, $text];
	}

	private static function getExtraDsc($inv, $extra, $extraI, $srv, $loc, $full)
	{
		if ($extra == '' || $extraI == '')
		{
			return;
		}
		$text	 = '';
		$parts	 = explode('::', $extraI);
		$c		 = [false, ''];
		foreach ($parts as $part)
		{
			if ($part == '' || $part == null)
				continue;
			$item	 = str_replace(':', '', $part);
			$c		 = L2WEBH5::checkExtraPart($inv, $item, $srv, $loc);
			if ($c[0] == true)
			{
				break;
			}
		}

		$color	 = $c[0] ? L2WEBH5::$colors['white'] : L2WEBH5::$colors['grey'];
		$text	 .= '<br /><span style="color:' . $color . ';">' . $c[1] . '</span>';
		$color2	 = $full && $c[0] ? L2WEBH5::$colors['yellow'] : L2WEBH5::$colors['brown'];
		$text	 .= '<br /><span style="color:' . $color2 . ';">' . $extra . '</span><br />';
		return $text;
	}

	private static function checkExtraPart($inv, $id, $srv, $loc)
	{
		$extra	 = false;
		$name	 = DAO::getInstance()::getL2WItem()::getItemName($id);
		if (!$name)
		{
			die('UNKNOWN ID - ' . $id);
		}

		if ($srv != 'ws' || $loc != 'PAPERDOLL')
		{
			$b = DAO::getInstance()::getItem()::getEnchant($srv, $inv['owner_id'], $id, $loc);

			if ($b)
			{
				//$color	 = L2WEBH5::$colors['white'];
				$extra = true;
			}
		}
		return [$extra, $name];
	}
	static function drawSkill($sId, $id, $lvl)
	{
		$info = DAO::getInstance()::getL2WSkills()::get($id, $lvl);
		if (!$info)
		{
			echo $id. ' - '.$lvl . ' - no Skill info <br />';
			return;
		}
		$name	 = $info['name'];
		//$addname = L2WEBH5::formatSkillAddName($info['add_name']);
		$addname = $info['add_name'];
		$icon = '<img src="img/icons/' . $info['icon'] . '.png" alt="" />';
		$panel	 = $info['frame'] ? '<div class="panel"><a href="actions.php?a=skill&id=' . $id . '&lvl=' . $lvl . '&srv=' . $sId . '" class="item_info"><img src="img/icons/' . $info['frame'] . '.png" alt=""></a></div>' : '';
		return '<div class="floated" onmouseover="showTip(this, \'S_tip\', \'#FFFFFF\'); return false;" onmouseout="hideTip(\'S_tip\'); return false;" title="'. $name . $addname . '"><div class="item"><a href="actions.php?a=skill&id=' . $id . '&lvl=' . $lvl . '&srv=' . $sId . '" class="item_info">'.$icon.'</a></div>' . $panel . '</div>';
	
	}
	static function getSkillImg($id)
	{
		$icon = $id < 1000 ? '0' . $id : $id;
		return '<img src="img/icons/skill' . $icon . '.png" alt="" />';
	}

	static function drawItem($item, $sId, $type = '')
	{
		//:TODO check augment
		$info = DAO::getInstance()::getL2WItem()::getItem($item['item_id']);
		if (!$info)
		{
			echo $item['item_id'] . ' - no Item info <br />';
			return;
		}
		$name	 = $info['name'];
		$addname = $info['add_name'] != '' ? ' - ' . $info['add_name'] : '';
		$enc	 = $item['enchant_level'] > 0 ? '+ ' . $item['enchant_level'] . ' ' : '';
		if ($type == 'P')
		{
			$class	 = L2WEBH5::$l2web['parts'][$item['loc_data']];
			$count	 = '';
		}
		else
		{
			$class	 = 'floated';
			$count	 = L2WEBH5::formatCount($item['count']);
		}
		$color	 = L2WEBH5::$type_colors[$info['mtype']];
		//$panel	 = $info['frame'] ? '<div class="panel"><img src="img/panels/' . $info['frame'] . '.png" alt=""></div>' : '';
		//return '<div class="item_info" onclick="load_popup(\'actions.php?a=item&id=' . $item['object_id'] . '&srv=' . $sId . '\'); return false;" onmouseover="showTip(this, \'' . $type . '_tip\', \'' . $color . '\'); return false;" onmouseout="hideTip(\'' . $type . '_tip\'); return false;" title="' . $enc . $name . $addname . $count . '"><div class="' . $class . '"><div class="item"><img border="0" src="img/icons/' . $info['icon'] . '.png" alt="" /></div>' . $panel . '</div></div>';
	
		$panel	 = $info['frame'] ? '<div class="panel"><a href="actions.php?a=item&id=' . $item['object_id'] . '&srv=' . $sId . '" class="item_info"><img src="img/icons/' . $info['frame'] . '.png" alt=""></a></div>' : '';
		return '<div class="' . $class . '" onmouseover="showTip(this, \'' . $type . '_tip\', \'' . $color . '\'); return false;" onmouseout="hideTip(\'' . $type . '_tip\'); return false;" title="' . $enc . $name . $addname . $count . '"><div class="item"><a href="actions.php?a=item&id=' . $item['object_id'] . '&srv=' . $sId . '" class="item_info"><img border="0" src="img/icons/' . $info['icon'] . '.png" alt="" /></a></div>' . $panel . '</div>';
	}

	static function drawHenna($id, $loc)
	{
		$info = DAO::getInstance()::getL2WHenna()::get($id);
		if (!$info)
		{
			echo $id . ' - no Henna info <br />';
			return;
		}

		$name	 = $info['name'];
		$desc	 = $info['desc'];
		return '<div class="dye' . $loc . '" onmouseover="showTip(this, \'P_tip\', \'#FFF\');" onmouseout="hideTip(\'P_tip\');" title="' . $name . '<br />' . $desc . '"><div class="item"><a href="actions.php?a=henna&id=' . $id . '" class="item_info"><img border="0" src="img/icons/' . $info['icon'] . '.png" alt="" /></a></div></div>';
	}
	static function drawSimpleHenna($id)
	{
		$info = DAO::getInstance()::getL2WHenna()::get($id);
		if (!$info)
		{
			echo $id . ' - no Henna info <br />';
			return;
		}

		$name	 = $info['name'];
		$desc	 = $info['desc'];
		return '<a href="actions.php?a=henna&id=' . $id . '" class="item_info" aria-label="'.$name .' - '. $desc.'"><img border="0" src="img/icons/' . $info['icon'] . '.png" alt="'.$name .' - '. $desc.'" /></a>';
	}

	static function getItemData($srv, $id)
	{
		global $Lang;
		if ($srv == 'ws')
		{
			$inv = DAO::getInstance()::getL2WItem()::getWebshop($id);
		}
		else
		{
			$inv = DAO::getInstance()::getItem()::get($srv, $id);
		}
		if (!$inv)
		{
			return 'no data';
		}

		$item = DAO::getInstance()::getL2WItem()::getItem($inv['item_id']);


		$aug	 = L2WEBH5::getAugment($srv == 'ws' ? $inv['augment'] : $inv['object_id'], $srv);
		$name	 = L2WEBH5::formatName($aug ? sprintf($Lang['__augmented-s_'], $item['name']) : $item['name'], $item['mtype']);
		$addname = L2WEBH5::formatAddName($item['add_name']);
		$grade	 = L2WEBH5::getGradeImg($item['grade']);
		$enchant = L2WEBH5::formatEnchant($inv['enchant_level']);

		$count = $inv['count'] > 1 ? ' (' . $inv['count'] . ')' : '';

		$desc	 = $item['desc'];
		$ret	 = $enchant . $name . $addname . $grade . $count;
		//if ($item['type'] != 'e')
		//{
			//$item_type	 = L2WEBH5::$l2web[$item['type']][$item['type2']];
			//$hands		 = $item['type'] == 'w' && $item['type2'] == 0 ? '' : ' / ' . L2WEBH5::$l2web['body'][$item['body_part']];
			//$hands		 = L2WEBH5::$l2web['body'][$item['body_part']];
			//$item_type	 = L2WEBH5::$l2web[$item['type']][$item['type2']];
			//$ret		 .= '<br /><br /><font color="' . L2WEBH5::$colors['brown'] . '">' . $hands . ' / ' . $item_type . '</font><br />';
		//}

		switch ($item['type'])
		{
			case 'w':
				if ($item['type2'] == 0)
				{
					$ret .= L2WEBH5::buildShield($inv, $item);
				}
				else
				{
					$ret .= L2WEBH5::buildWeapon($inv, $item);
				}
				break;
			case 'a':
				$ret .= L2WEBH5::buildArmor($inv, $item, $srv);

				break;
		}

		if ($aug)
		{
			$ret .= '<br /><b>&lt;Augmentation Effects&gt;</b><br />' . $aug . '<br />Unable to Trade/Drop';
		}
		if ($desc != '')
		{
			if ($addname != '' && $item['type'] == 'w')
			{
				$ret .= '<br /><br /><span style="color:' . L2WEBH5::$colors['white'] . ';">&lt;Soul Crystal Enhancement&gt;</span>';
			}
			$ret .= '<br /><span style="color:' . L2WEBH5::$colors['white'] . ';">' . $desc . '</span>';
		}
		$element = L2WEBH5::drawElements($srv, $item['type'], $srv == 'ws' ? $inv['elementals'] : $inv['object_id']);

		if ($element != '')
		{
			$ret .= '<br /><br />' . $element;
		}

		if ($srv == 'ws')
		{
			$ret .= '<br /><a href="webshop.php?a=buy&id=' . $inv['id'] . '&srv=ws">' . button('buy', '', true) . '</a>';
		}
		return '<div id="popup">' . $ret . '</div>';
		//return $ret;
	}
	static function getSkillData($id, $lvl)
	{
		//global $Lang;

		$info = DAO::getInstance()::getL2WSkills()::get($id, $lvl);
if (!$info)
		{
			return;
		}

		$name	 = $info['name'];
		$addname = L2WEBH5::formatSkillAddName($info['add_name']);
		
		$desc	 = $info['desc'];
		$ret	 = $name . $addname;


		
		if ($desc != '')
		{
			
			$ret .= '<br /><span style="color:' . L2WEBH5::$colors['white'] . ';">' . $desc . '</span>';
			//if ($addname != '')
			//{
			//	$ret .= '<br /><br /><font color="' . L2WEBH5::$colors['yellow'] . '">'.$info['desc1'].'</font>';
			//}
		}
		return '<div id="popup">' . $ret . '</div>';
	}
	static function getHennaData($id)
	{
		//global $Lang;

		$info = DAO::getInstance()::getL2WHenna()::get($id);
if (!$info)
		{
			return;
		}

		$name	 = $info['name'];
		//$addname = L2WEBH5::formatSkillAddName($info['add_name']);
		
		$desc	 = $info['desc'];
		$ret	 = $name ;//. $addname;


		
		if ($desc != '')
		{
			
			$ret .= '<br /><span style="color:' . L2WEBH5::$colors['white'] . ';">' . $desc . '</span>';
			//if ($addname != '')
			//{
			//	$ret .= '<br /><br /><font color="' . L2WEBH5::$colors['yellow'] . '">'.$info['desc1'].'</font>';
			//}
		}
		return '<div id="popup">' . $ret . '</div>';
	}
}
/*interface iL2WEB
{

    static function buildArmor($inv, $item, $srv);
}*/