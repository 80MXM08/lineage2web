<?php

function RandomGenerator($length = 5)
{
	$chars = "ABCDEFGHJKLMNPRSTWXYZ123456789";
	if (!is_int($length) || $length < 1)
	{
		$length = 5;
	}
	$rndstr		 = '';
	$maxvalue	 = strlen($chars) - 1;
	for ($i = 0; $i < $length; $i++)
	{
		$rndstr .= substr($chars, rand(0, $maxvalue), 1);
	}
	return $rndstr;
}

function foxy_utf8_to_nce($utf = '')
{
	if ($utf == '')
	{
		return ($utf);
	}

	$max_count	 = 5; // flag-bits in $max_mark ( 1111 1000 == 5 times 1)
	$max_mark	 = 248; // marker for a (theoretical ;-)) 5-byte-char and mask for a 4-byte-char;

	$html = '';
	for ($str_pos = 0; $str_pos < strlen($utf); $str_pos++)
	{
		$old_chr = $utf{$str_pos};
		$old_val = ord($utf{$str_pos});
		$new_val = 0;

		$utf8_marker = 0;

		// skip non-utf-8-chars
		if ($old_val > 127)
		{
			$mark = $max_mark;
			for ($byte_ctr = $max_count; $byte_ctr > 2; $byte_ctr--)
			{
				// actual byte is utf-8-marker?
				if (($old_val & $mark) == (($mark << 1) & 255))
				{
					$utf8_marker = $byte_ctr - 1;
					break;
				}
				$mark = ($mark << 1) & 255;
			}
		}

		// marker found: collect following bytes
		if ($utf8_marker > 1 and isset($utf{$str_pos + 1}))
		{
			$str_off = 0;
			$new_val = $old_val & (127 >> $utf8_marker);
			for ($byte_ctr = $utf8_marker; $byte_ctr > 1; $byte_ctr--)
			{

				// check if following chars are UTF8 additional data blocks
				// UTF8 and ord() > 127
				if ((ord($utf{$str_pos + 1}) & 192) == 128)
				{
					$new_val = $new_val << 6;
					$str_off++;
					// no need for Addition, bitwise OR is sufficient
					// 63: more UTF8-bytes; 0011 1111
					$new_val = $new_val | (ord($utf{$str_pos + $str_off}) & 63);
				}
				// no UTF8, but ord() > 127
				// nevertheless convert first char to NCE
				else
				{
					$new_val = $old_val;
				}
			}
			// build NCE-Code
			$html	 .= '&#' . $new_val . ';';
			// Skip additional UTF-8-Bytes
			$str_pos = $str_pos + $str_off;
		}
		else
		{
			$html	 .= chr($old_val);
			$new_val = $old_val;
		}
	}
	return ($html);
}
define('L2WEB', true);
$a = isset($_GET['a']) ? $_GET['a'] : '';

switch ($a)
{
	case 'b': #button
		header("Content-type: image/png");
		require_once ("include/core.php");

		$expires		 = 60 * 60 * 24 * 14; //2 weeks
		header("Pragma: public");
		header("Cache-control: public");
		header("Cache-Control: maxage=" . $expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
		header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
		$theme			 = User::getVar('theme');
		$lng			 = User::getVar('lang');
		$t				 = fString(filter_input(INPUT_GET, 'text'));
		$text			 = foxy_utf8_to_nce($Lang[$t]);
		$button_img		 = imagecreatefrompng('img/buttons/back3.png');
		//if(!$button_img) die('te');
		$button_complete = imagecreate(138, 34);
		$color			 = imagecolorallocate($button_complete, 210, 210, 210);
		$tb				 = imagettfbbox(10, 0, 'img/buttons/courbd.ttf', $text);
		$x				 = ceil((138 - $tb[2]) / 2); // lower left X coordinate for text
		imagecopy($button_complete, $button_img, 0, 0, 0, 0, 138, 34);
		imagettftext($button_complete, 10, 0, $x, 23, -$color, 'img/buttons/courbd.ttf', $text);

		imagepng($button_complete);
		imagepng($button_complete, 'img/buttons/' . $lng . '_' . $theme . '_' . $t . '.png');
		imagedestroy($button_complete);
		imagedestroy($button_img);
		break;


	case 'lb': #login button
		header("Content-type: image/png");
		include ('include/core.php');
		$t		 = fString(filter_input(INPUT_GET, 'text'));
		$text	 = $Lang[trim($t)];
		$theme	 = User::getVar('theme');
		$lng	 = User::getVar('lang');
		$style	 = fString(filter_input(INPUT_GET, 'style'));
		switch ($style)
		{
			case 'normal':
				$button_img	 = imagecreatefrompng('img/buttons/normal.png');
				break;
			case 'hover':
				$button_img	 = imagecreatefrompng('img/buttons/hover.png');
				break;
			case 'press':
				$button_img	 = imagecreatefrompng('img/buttons/pressed.png');
				break;
			default:
				die();
				break;
		}

		$izq_img		 = imagecreate(9, 26);
		$cen_img		 = imagecreate(1, 26);
		$der_img		 = imagecreate(9, 26);
		$button_complete = imagecreate((9 + (strlen($text) * 7) + 9), 26);
		$color			 = imagecolorallocate($button_complete, 210, 210, 210);

		imagecopy($izq_img, $button_img, 0, 0, 0, 0, 9, 26);
		imagecopy($cen_img, $button_img, 0, 0, 10, 0, 1, 26);
		imagecopy($der_img, $button_img, 0, 0, 85, 0, 9, 26);
		imagecopy($button_complete, $izq_img, 0, 0, 0, 0, 9, 26);

		$i = 0;
		while ($i <= (strlen($text) * 7))
		{
			imagecopy($button_complete, $cen_img, (9 + $i), 0, 0, 0, 1, 26);
			$i++;
		}
		imagecopy($button_complete, $der_img, (9 + (strlen($text) * 7)), 0, 0, 0, 9, 26);
		imagettftext($button_complete, (9), 0, ceil(((9 + (strlen($text) * 7) + 9) / 2) -
						(strlen($text) * 3.5)), 17, $color, 'img/buttons/verdana.ttf', $text);


		//header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
		imagepng($button_complete);
		imagepng($button_complete, 'img/buttons/' . $lng . '_' . $theme . '_' . trim($t) . '_' . $style . '.png');
		imagedestroy($button_complete);
		imagedestroy($izq_img);
		imagedestroy($cen_img);
		imagedestroy($der_img);
		imagedestroy($button_img);
		break;

	case 'captcha':
		session_start();
		$random				 = RandomGenerator(rand(4, 6));
		$_SESSION['captcha'] = $random;
		$width				 = strlen($random);
		$imagecreate		 = imagecreate($width * 10 + 2, 18);
		$background			 = imagecolorallocate($imagecreate, 0, 0, 0);
		$textcolor			 = imagecolorallocate($imagecreate, 255, 255, 255);
		imagestring($imagecreate, 5, 3, 1, $random, $textcolor);
		header("Content-type: image/png");
		imagepng($imagecreate);
		imagedestroy($imagecreate);
		break;
	case 'char': //search char? / check query
		require_once ("include/core.php");
		if (!User::logged())
		{
			die();
		}
		$q		 = getString('q');
		$server	 = getInt('server');
		$limit	 = getInt('limit');
		if (!empty($q) && !empty($limit) && !empty($server))
		{
			$query	 = '%' . strtr($q, ' ', '%') . '%';
			$db		 = getGSById($server)['id'];
			$r		 = $sql[$db]->query2('SEARCH_CHARS', [[':name', "%$query%", PDO::PARAM_STR], [':limit', (int) $limit, PDO::PARAM_INT]]);
			$data	 = $r->fetchAll(PDO::FETCH_ASSOC);
		}

		echo json_encode($data);
		break;
	case 'getchar':
		require_once ("include/core.php");
		#TODO: fix server id?
		if (isset($_GET['server']) && is_numeric($_GET['server']) && User::logged())
		{
			$server	 = getInt('server');
			$db		 = getGSById($server)['id'];
			foreach ($sql[$db]->query('GET_ACC_CHARS', [':login' => User::getUser()]) as $option)
			{
				echo "obj.options[obj.options.length] = new Option('{$option['char_name']}','{$option['charId']}');\n";
			}
		}

		break;
	case 'vars':
		require_once ("include/core.php");
		if (isset($_GET['var']) && isset($_GET['val']))
		{
			$var	 = getString('var');
			$value	 = getString('val');
			if (User::setVar($var, $value))
			{
				if ($var == 'theme' || $var == 'lang')
				{
					head('', 1, 'index.php', 5);
					msg($Lang['success']);
					foot();
				}
				else
				{
					die('OK');
				}
			}
			else
			{
				die('Something went wrong');
			}
		}
		else
		{
			die('Missing vars!');
		}
		break;
	case 'viewimg':
		require_once ("include/core.php");
		tpl::parse('viewimg', null);
		break;

	case 'item':
		require_once ("include/core.php");
		$id	 = getInt('id');
		$sId = getInt('srv');
		if ($sId)
		{
			$gs	 = getGSById($sId);
			$srv = $gs['id'];
		}
		else
		{
			$srv = 'ws';
			$gs	 = getGSById();
		}
		//head('',0);
		echo $gs['l2web']::getItemData($srv, $id);
		//foot(0);
		break;
	case 'skill':
		require_once ("include/core.php");
		$id	 = getInt('id');
		$lvl = getInt('lvl');
		
		echo getGSById()['l2web']::getSkillData($id, $lvl);
		break;
			case 'henna':
		require_once ("include/core.php");
		$id	 = getInt('id');

		echo getGSById()['l2web']::getHennaData($id);
		break;
	default:
		echo 'Undefined action: ' . $a;
		break;
}