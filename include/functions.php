<?php

if (!defined('CORE')) {
    header("Location: ../index.php");
    die();
}

function fString($string = '') {
    return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function fInt($int = 0) {
    return filter_var($int, FILTER_VALIDATE_INT);
}

function fFloat($float = 0.0) {
    return filter_var($float, FILTER_VALIDATE_FLOAT);
}

function autoVersion($file) {
    if (!file_exists($file)) {
        return $file;
    }

    $mtime = filemtime($file);
    return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
}

function getDateTime($timestamp = 0) {
    if ($timestamp) {
        return date("Y-m-d H:i:s", $timestamp);
    } else {
        return date("Y-m-d H:i:s");
    }
}

function writeLog($type, $sub, $comment) {
    global $sql;

    $sql[0]->query("INSERT INTO `log` (`account`, `type`, `subType`, `comment`) VALUES ('{acc}', '{type}', '{sub}', '{comment}');", array('acc' => User::getUser(), 'type' => $type, 'sub' => $sub, 'comment' => $comment));
}

function includeBlock($file, $blockTitle = 'Menu', $frame = true, $return = false) {
    global $sql, $Lang, $GS, $content;
    //$imgLink = 'themes/'.$user->getVar('theme');
    $cnt = '';
    if ($frame) {
        $parse2['blockTitle'] = $blockTitle;
        //$parse2=$parse;
        $cnt.=TplParser::parse('blocks/block_t', $parse2, true);
    }

    if (file_exists('blocks/' . $file . '.php')) {
        //includeLang('blocks/' . $file);
        require_once ('blocks/' . $file . '.php');
        $cnt .= $content;
    } else {
        $cnt .= msg('Error', 'Failed to get block ' . $file, 'error', 1);
    }
    if ($frame) {
        $cnt.=TplParser::parse('blocks/block_b', $parse2, true);
    }
    if ($return) {
        return $cnt;
    }
    echo $cnt;
}

function msg($heading = '', $text = '', $div = 'success', $return = false) {
    $content = '<table width="90%" border="0"><tr><td>';
    $content .= '<div align="center" class="' . $div . '">' . ($heading ? '<b>' . $heading . '</b><br />' : '') . $text . '</div></td></tr></table>';
    if ($return) {
        return $content;
    }
    echo $content;
}

function head($title = '', $head = true, $url = '', $time = 0) {
    global $sql, $Lang, $GS;
    require_once ('themes/' . User::getVar('theme') . '/head.php');
}

function foot($foot = true) {
    global $sql, $startTime, $Lang, $GS;
    require_once ('themes/' . User::getVar('theme') . '/foot.php');
}

function button($text = '', $name = 'Submit', $return = true, $disabled = false, $id = null) {
    global $Lang;
    $theme = User::getVar('theme');
    $lng=User::getVar('lang');
    $img = 'img/buttons/' . $lng . '_' . $theme . '_' . $text . '_';
    //$parse['text'] = $Lang[$text];
    $parse['name'] = $name;
    $parse['png'] = '';
    if (file_exists($img . 'normal.png') && file_exists($img . 'press.png') && file_exists($img . 'hover.png')) {
        $parse['link'] = $img;
        $parse['png'] = '.png';
    } else {
        $parse['link'] = 'actions.php?a=lb&amp;text=' . $text . '&amp;style=';
    }
    if ($id == null) {
        $parse['id'] = "bt_" . rand(20, 99);
    } else {
        $parse['id'] = $id;
    }
    if ($disabled)
        $parse['disabled'] = 'disabled="disabled"';
    $parse['alt'] = $Lang[$text];
    return TplParser::parse('button', $parse, $return);
}

function menuButton($text) {
    global $Lang;
    $theme = User::getVar('theme');
        $lng=User::getVar('lang');
    $img = 'img/buttons/' . $lng . '_' . $theme . '_' . $text . '.png';
    if (file_exists($img)) {
        $text = $Lang[$text];
        return '<img src="' . $img . '" title="' . $text . '" alt="' . $text . '" width="138" height="34" />';
    } else {
        return '<img src="actions.php?a=b&amp;text=' . $text . '" title="' . $Lang[$text] . '" alt="' . $Lang[$text] . '" width="138" height="34" />';
    }
}

function page($page, $count = 0, $link, $server) {
    global $Lang;
    $top = Config::get('settings', 'TOP', '10');
    $content = null;
    $content .= '<div class="page-choose" align="center"><br /><table align="center"><tr>';
    $ps = "?";
    $lnkquest = stripos($link, "?");
    if ($lnkquest !== false) {
        $ss = '&amp;';
        $ps = '&amp;';
    } else {
        $ss = "?";
    }
    if ($server != '') {
        $server = $ss . 'server=' . $server;
        $ps = '&amp;';
    }
    $totalpages = ceil($count / $top);
    if ($totalpages == 0) {
        $totalpages++;
    }
    if ($page == 0)
        $page = 1;
    if ($page > 3) {
        $content .= '<td><a href="' . $link . $server . $ps . 'page=1" title="' . $Lang['first'] . '"  class="btn"> &laquo; </a></td>';
    }
    if ($page > 1) {
        $content .= '<td><a href="' . $link . $server . $ps . 'page="';
        $content .= $page - 1;
        $content .= '" title="' . $Lang['prev'] . '" class="btn"> &lt; </a></td>';
    }
    if ($page - 2 > 0) {
        $start = $page - 2;
    } else {
        $start = 1;
    }
    for ($i = $start; $i <= $totalpages && $i <= $page + 2; $i++) {

        if ($i == $page) {
            $content .= '<td>  <a href="#" class="btn brown" title="';
            $content .= ' [';
            $content .= ($count != 0) ? $i * $top + 1 - $top : 0;
            $content .= ' - ';
            $content .= ($i * $top > $count) ? $count : $i * $top;
            $content .= ']"> ';
            $content .= $i;
            $content .= ' </a>  </td>';
        } else {
            $content .= '<td>  <a href="' . $link . $server . $ps;
            $content .= 'page=' . $i;
            $content .= '" title="[';
            $content .= ($count != 0) ? $i * $top + 1 - $top : 0;
            $content .= ' - ';
            $content .= ($i * $top > $count) ? $count : $i * $top;
            $content .= ']" class="btn"> ';
            $content .= $i;
            $content .= ' </a>  </td>';
        }
    }
    if ($totalpages > $page) {

        $content .= '<td><a href="' . $link . $server . $ps . 'page=';
        $content .= $page + 1;
        $content .= '" title="' . $Lang['next'] . '" class="btn"> &gt; </a></td>';
    }
    if ($totalpages > $page + 2) {

        $content .= '<td><a href="' . $link . $server . $ps . 'page=';
        $content .= $totalpages;
        $content .= '" title="' . $Lang['next'] . '" class="btn"> &raquo; </a></td>';
    }

    $content .= '</tr></table> </div>';
    return $content;
}

function convertPic($id, $ext, $width, $height) {
    if (file_exists('news/' . $id . '_thumb.' . $ext)) {
        unlink('news/' . $id . '_thumb.' . $ext);
    }
    $new_img = 'news/' . $id . '_thumb.' . $ext;

    $file_src = 'news/' . $id . '.' . $ext;

    list($w_src, $h_src, $type) = getimagesize($file_src);
    $ratio = $w_src / $h_src;
    if ($width / $height > $ratio) {
        $width = floor($height * $ratio);
    } else {
        $height = floor($width / $ratio);
    }

    switch ($type) {
        case 1: //   gif -> jpg
            $img_src = imagecreatefromgif($file_src);
            break;
        case 2: //   jpeg -> jpg
            $img_src = imagecreatefromjpeg($file_src);
            break;
        case 3: //   png -> jpg
            $img_src = imagecreatefrompng($file_src);
            break;
    }
    $img_dst = imagecreatetruecolor($width, $height); //  resample
    //$img_dst = imagecreate($width, $height);  //  resample
    imageantialias($img_dst, true);
    imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width, $height, $w_src, $h_src);
    switch ($type) {
        case 1:
            imagegif($img_dst, $new_img);
            break;
        case 2:
            imagejpeg($img_dst, $new_img);
            break;
        case 3:
            imagepng($img_dst, $new_img);
            break;
    }
    imagedestroy($img_src);
    imagedestroy($img_dst);
}

?>