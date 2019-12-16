<?php

if (!defined('L2WEB')) {
    header('Location: ../index.php');
    exit();
}
define('ROOT', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/lineage2web/');
$CONFIG = [
    'DAO_driver' => 'mysql',
    'core'       => [
        'driver'   => 'mysql',
        'host'     => 'localhost', //SQL Host
        'port'     => '3306', //SQL Port
        'user'     => 'root', //SQL User
        'password' => '', //SQL Password
        'database' => 'l2web', //L2Web Database (default - l2web)
        'debug'    => true,  //default: false
	'show_on_stats' => false,
        'active'    => true
    ],
    'ls'         => [
        'driver'   => 'mysql',
        'host'     => 'localhost', //SQL Host
        'port'     => '3306', //SQL Port
        'user'     => 'root', //SQL User
        'password' => '', //SQL Password
        'database' => 'l2jls', //L2J Account DataBase (default - l2jls)
        'server_ip' => '127.0.0.1',
	'server_port' => '2106',
        'debug'    => true, //default: false
	'show_on_stats'=>true,
        'active'    => true
    ],
    'cs'         => [
        'driver'   => 'mysql',
        'host'     => 'localhost', //SQL Host
        'port'     => '3306', //SQL Port
        'user'     => 'root', //SQL User
        'password' => '', //SQL Password
        'database' => 'l2jcs', //L2J Comunity DataBase (default - l2jcs)
        'server_ip' => '127.0.0.1',
	'server_port' => '3333', //TODO: find correct port
        'debug'    => false, //default: false
	'show_on_stats'=>false,
        'active'    => false
    ]
];

$timeParts = explode(' ', microtime());
$startTime = $timeParts[1] . substr($timeParts[0], 1);
define('CORE', TRUE);
define('USER_IP', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
define('USER_BROWSER', filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'));
session_start();
$lng = isset($_SESSION['lang']) && $_SESSION['lang'] != '' ? $_SESSION['lang'] : 'en';
require_once(ROOT . 'core/lang/' . $lng . '.php');

//require_once ('config.php');
require_once ('functions.php');
require_once ('class.DB.php');
require_once ('DAO/dao.php');
require_once ('class.config.php');
require_once ('class.tplParser.php');

require_once ('class.user.php');
require_once ('class.cache.php');
require_once ('class.block.php');
require_once ('l2web.php');

$sql = [];
foreach ($CONFIG as $k => $c) {
    if (!is_array($c)) {
        continue;
    }
    if (!$c['active']) {
        continue;
    }
    $sql[$k] = new DB($c, $k);
}

DAO::init($CONFIG['DAO_driver']);
unset($CONFIG);
User::init();
Conf::init();
tpl::setDir(User::getVar('theme'));

if (Conf::get('security', 'ban_management')) {
    $r = DAO::get()::Ban()::get(USER_IP);
    if ($r) {
        if (time() > $r['to']) {
            DAO::get()::Ban()::delete(USER_IP);
        } else {
            head($Lang['__you-banned_'], 0);
            $parse = $r;
            $parse['secs'] = $r['to'];
            $parse['date_from'] = $r['time_from'];
            $parse['date_to'] = $r['time_to'];
            echo tpl::parse('banned', $parse);
            foot(0);
            exit;
        }
    }
}

if (Conf::get('security', 'hack_detect')) {
    checkHack();
}
$GS = [];
DAO::get()::L2WGameServer()::get();
foreach ($GS as &$g) {
    if (!$g['active']) {
        unset($g['db_host'], $g['db_port'], $g['db_user'], $g['db_pass']);
        continue;
    }
    $dbi = [
        'driver' => $g['db_driver'],
        'host' => $g['db_host'],
        'port' => $g['db_port'],
        'user' => $g['db_user'],
        'password' => $g['db_pass'],
        'database' => $g['database'],
        'debug' => filter_var($g['debug'], FILTER_VALIDATE_BOOLEAN),
        'show_on_stats' => filter_var($g['show_on_stats'], FILTER_VALIDATE_BOOLEAN),
        'server_ip' => $g['gs_ip'],
        'server_port' => $g['gs_port']
    ];
    unset($g['db_host'], $g['db_port'], $g['db_user'], $g['db_pass']);
    $sql[$g['id']] = new DB($dbi, 'gs');
    $g['l2web'] = L2WEB::init($g['version']);
}


html::init(Conf::get('cache', 'enabled'));
Block::init();
if (!Conf::get('debug', 'web')) {
    error_reporting(0);
}