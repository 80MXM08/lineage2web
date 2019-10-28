<?php
define('L2WEB', true);
require_once ("include/core.php");

if (!User::isAdmin()) {
    die();
}
$dbname = 'l2web';

head();
$parse = null;
$parse['content'] = '';
$sql['core']->query('SHOW_TABLES', array('db' => $dbname));
while ($r = $sql['core']->fetchRow()) {
    $parse['content'] .= '<option value="' . $r[0] . '" selected>' . $r[0] . '</option>';
}
tpl::parse('admin/database', $parse);

$totaltotal = 0;
$totalfree = 0;
$i = 0;
if(isset($_POST['type']) && $_POST['type']=='a')
{
    
}
elseif (isset($_POST['type']) && $_POST['type'] == "o") {
    $sql['core']->query('SHOW_STATUS', array('db' => $dbname));
    $tables = array();

    $parse = null;
    $parse['rows'] = '';
    $parse['db_opt'] = sprintf($Lang['lDb_opt'], $dbname);
    while ($row = $sql['core']->fetch()) {
        if (!in_array($row[0], $_POST['datatable'])) {
            continue;
        }
        $total = $row['Data_length'] + $row['Index_length'];
        $totaltotal += $total;
        $free = ($row['Data_free']) ? $row['Data_free'] : 0;
        $totalfree += $free;
        $i++;
        if (!$free) {
            $parse2['color'] = '#FF0000';
            $parse2['tableStatus'] = $Lang['lUnnecessary'];
        } else {
            $parse2['color'] = '#009900';
            $parse2['tableStatus'] = $Lang['lOptimized'];
        }
        $parse2['i'] = $i;
        $parse2['table'] = $row[0];
        $parse2['total'] = fSize($total);
        $parse2['free'] = fSize($free);
        $tables[] = $row[0];

        $parse['rows'].=tpl::parse('admin/db_opt_row', $parse2, true);
    }
    $sql['core']->query('OPTIMIZE_TABLE', array('table' => implode(", ", $tables)));

    $parse['db_size'] = sprintf($Lang['lDb_size'], fSize($totaltotal));
    $parse['db_free'] = sprintf($Lang['lDb_free'], fSize($totalfree));

    tpl::parse('admin/db_opt', $parse);
} elseif (isset($_POST['type']) && $_POST['type'] == "r") {
    $parse = null;
    $parse['rows'] = '';
    $parse['db_rep'] = sprintf($Lang['lDb_rep'], $dbname);
    $r1 = $sql['core']->query('SHOW_STATUS', array('db' => $dbname));
    while ($row = $sql['core']->fetch($r1)) {
        if (!in_array($row[0], $_POST['datatable'])) {
            continue;
        }
        $total = $row['Data_length'] + $row['Index_length'];
        $totaltotal += $total;
        $i++;

        $r2 = $sql['core']->query('REPAIR_TABLE', array('table' => $row[0]));
        if (!$r2) {
            $parse2['color'] = '#FF0000';
            $parse2['tableStatus'] = $Lang['lError'];
        } else {
            $parse2['color'] = '#009900';
            $parse2['tableStatus'] = $Lang['lOK'];
        }
        $parse2['i'] = $i;
        $parse2['table'] = $row[0];
        $parse2['total'] = fSize($total);
        $parse['rows'].=tpl::parse('admin/db_rep_row', $parse2, true);
    }
    $parse['db_size'] = sprintf($Lang['lDb_size'], fSize($totaltotal));
    tpl::parse('admin/db_rep', $parse);
}
foot();




