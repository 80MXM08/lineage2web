<?php
if(!defined('CORE'))
{
	header("Location: ../../index.php");
	die();
}
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
'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
'/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
'/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
'file\://', 'window.open', '<script>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
'<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=');

$checkworm = str_replace($wormprotector, '*', $cracktrack);

if ($cracktrack != $checkworm)
{
    $cremotead = $_SERVER['REMOTE_ADDR'];
    $cuseragent = $_SERVER['HTTP_USER_AGENT'];
    $todb = $sql[0]->escape($_SERVER['QUERY_STRING']);
    $sql[0]->query("INSERT INTO `log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('$cremotead', 'CrackTracker', 'Error', 'Reason=\"Used illegal args\", UserAgent=\"$cuseragent\", Action=\"$todb\"');");
    die( "Attack detected! <br /><br /><b>Youre attack was blocked:</b><br />$cremotead - $cuseragent" );
}
?>