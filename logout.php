<?php
define('L2WEB', True);
require_once('include/core.php');

if(User::logout())
{
    head($Lang['logging_out'],1,'index.php',5);
    msg($Lang['success'], $Lang['success_log_out']);
}
else
{
    head($Lang['logigng_out'],1,'index.php',5);
    msg($Lang['success'], $Lang['fail_log_out']);
}
foot();
?>