<?php
define('INWEB', true);
require_once ("include/config.php");

/******************************************
* Function used to convert non-latin chars*
******************************************/
define('EMPTY_STRING', '');
function foxy_utf8_to_nce($utf = EMPTY_STRING)
{
	if($utf == EMPTY_STRING)
		return ($utf);

	$max_count = 5; // flag-bits in $max_mark ( 1111 1000 == 5 times 1)
	$max_mark = 248; // marker for a (theoretical ;-)) 5-byte-char and mask for a 4-byte-char;

	$html = EMPTY_STRING;
	for ($str_pos = 0; $str_pos < strlen($utf); $str_pos++)
	{
		$old_chr = $utf{$str_pos};
		$old_val = ord($utf{$str_pos});
		$new_val = 0;

		$utf8_marker = 0;

		// skip non-utf-8-chars
		if($old_val > 127)
		{
			$mark = $max_mark;
			for ($byte_ctr = $max_count; $byte_ctr > 2; $byte_ctr--)
			{
				// actual byte is utf-8-marker?
				if(($old_val & $mark) == (($mark << 1) & 255))
				{
					$utf8_marker = $byte_ctr - 1;
					break;
				}
				$mark = ($mark << 1) & 255;
			}
		}

		// marker found: collect following bytes
		if($utf8_marker > 1 and isset($utf{$str_pos + 1}))
		{
			$str_off = 0;
			$new_val = $old_val & (127 >> $utf8_marker);
			for ($byte_ctr = $utf8_marker; $byte_ctr > 1; $byte_ctr--)
			{

				// check if following chars are UTF8 additional data blocks
				// UTF8 and ord() > 127
				if((ord($utf{$str_pos + 1}) & 192) == 128)
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
			$html .= '&#' . $new_val . ';';
			// Skip additional UTF-8-Bytes
			$str_pos = $str_pos + $str_off;
		}
		else
		{
			$html .= chr($old_val);
			$new_val = $old_val;
		}
	}
	return ($html);
}
//пароль
header("Content-type: image/png");
$expires = 60 * 60 * 24 * 14; //2 weeks
header("Pragma: public");
header("Cache-control: public");
header("Cache-Control: maxage=" . $expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
header('Last-Modified: 1 Sep 2010 15:00:00 GMT');
$skin = selectSkin();
$text = foxy_utf8_to_nce($_GET['text']);
$button_img = imagecreatefrompng('skins/' . $skin . '/img/back3.png');

$button_complete = imagecreate(138, 34);
$color = imagecolorallocate($button_complete, 210, 210, 210);
$tb = imagettfbbox(10, 0, 'skins/' . $skin . '/fonts/courbd.ttf', $text);
$x = ceil((138 - $tb[2]) / 2); // lower left X coordinate for text
imagecopy($button_complete, $button_img, 0, 0, 0, 0, 138, 34);
imagettftext($button_complete, 10, 0, $x, 23, -$color, 'skins/' . $skin . '/fonts/courbd.ttf', $text);
imagepng($button_complete);
imagedestroy($button_complete);
imagedestroy($button_img);
?>