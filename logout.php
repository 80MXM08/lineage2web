<?php
define('L2WEB', True);
require_once('core/core.php');
$success=User::doLogout()?$Lang['__success-log-out_']:$Lang['__fail-log-out_'];
head($Lang['__loging-out_'], 1, 'index.php', 5);
echo msg($Lang['__success_'], $success);
foot();
