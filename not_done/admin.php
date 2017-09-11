<?php 
define('L2WEB', True);
require_once("include/core.php");

loggedInOrReturn('admin.php');
head("Admin");

if (!$user->isAdmin()) die($Lang['nothing_here']);
?>
<h2><?php echo $Lang['admin_settings']; ?></h2><br />
<a href="?config=config">Config</a> | <a href="?config=telnet">Telnet</a> | <a href="?config=trade">Offline Trade</a><br /><?php
$c=isset($_GET['config'])?$_GET['config']:'';
$a=getVar('action');
switch($c){
    case 'telnet':
    if($_POST)
    {
        if($a=='add')
        {
            $name=getVar('server');
            $ip=getVar('ip');
            $port=getVar('port');
            $password=getVar('password');
            if($name!='' && $ip!='' && $port!='' && $password!='')
            {
                $sql[0]->query("INSERT INTO `telnet` (`Server`, `IP`, `Port`, `Password`) VALUES ('$name', '$ip', '$port', '$password');");
                echo $Lang['saved'];
            }else{
                echo 'Nothing to insert!!!';
            }
            
        }else if($a=='delete')
        {
            $server=getVar('server');
            if($server!=''){
                $sql[0]->query("DELETE FROM `telnet` WHERE `ID`='$server';");
                echo $Lang['deleted'];
            }
        }else if($a=='execute')
        {
            $mycommand = getVar('todo');
            $time=getVar('time');
            $password=getVar('telnet_password');
            $serverid=getVar('server');

                $targetserver=$sql[0]->query('SELECT * FROM `telnet` WHERE `Server`=\''.$serverid.'\' ');
                if(SQL::numRows($targetserver)){
                    $server_data=SQL::fetchArray($targetserver);
                    $fp=@fsockopen($server_data['IP'],$server_data['Port'],$errno,$errstr);
                    //$command="$mycommand $time\r";
                    $command="$mycommand\r";
                    fputs($fp,$server_data['Password']."\r");
                    fputs($fp,$command);
                    fputs($fp,"quit\r");
                    while(!feof($fp)){
                        $output.=fread($fp,16);
                    }
                    fclose($fp);
                    $clear_r=array("Password Correct!","Password:","Please Insert Your Password!","\n","Password: Password Correct!","Welcome To The L2J Telnet Session.","[L2J]","Bye Bye!");
                    $output = str_replace($clear_r,"", $output);
                    echo 'Server Response = '.$output;
                }
        }else{}
    }
    else
    {?>
        <a href="javascript:showhide('add');">Add/Delete</a>
        <form action="admin.php?config=telnet" method="post">
        <table border="1" align="center"><tr><td>
        <select name="server">
        <?php
        $servers=$sql[0]->query('SELECT `server` FROM `telnet`');
        while($slist=SQL::fetchArray($servers))
        {?>
            <option value="<?php echo $slist['server'];?>"><?php echo $slist['server'];?></option>
  <?php } ?>
        </select>
        <select name="todo">
        <option value="restart">Restart</option>
        <option value="shutdown">ShutDown</option>
        </select>
        <input type="text" name="time" value="5" size="5" /></td></tr>
        <tr><td>Password: <input type="password" name="telnet_password" value="" />
        <input type="hidden" name="execute" value="yes" /></td></tr><tr><td>
        <?php echo button('execute'); ?>
        </td></tr></table></form>
        <div id="add" style="display: none;">
        <table><tr><td>
        <div align="left">
        <form action="admin.php?config=telnet&amp;action=add" method="post">
        <table border="1"><tr><td>Name: </td><td><input name="server" type="text" /></td></tr>
        <tr><td>IP: </td><td><input name="ip" type="text" /></td></tr>
        <tr><td>Port: </td><td><input name="port" type="text" /></td></tr>
        <tr><td>Password: </td><td><input name="password" type="text" /></td></tr>
        <tr><td></td><td><?php echo button('add'); ?></td></tr>
        </table>
        </form>
        </div></td><td>
        <div align="right">
        <table border="1">
        <thead><tr><th>Server</th><th>IP</th><th>Port</th><th>Password</th><th>Action</th></tr></thead>
        <tbody>
        <?php
        $servers=$sql[0]->query('SELECT * FROM `telnet`');
        while($slist=SQL::fetchArray($servers))
        {?>
            <tr><td><?php echo $slist['server'];?></td><td><?php echo $slist['ip'];?></td><td><?php echo $slist['port'];?></td><td><?php echo $slist['password'];?></td><td><a href="admin.php?config=telnet&amp;action=delete&amp;server=<?php echo $slist['id'];?>">Delete</a></td></tr>
  <?php }?>
        </tbody>
        </table>
        </div></td></tr>
        </table>
        </div>
        <?php
    }
    break;
    case "trade":
        if($_POST)
        {
            $items=array(
                0=>'4356',
                1=>'4357',
                2=>'4358'
            );
            $db=getDBInfo(getVar('server'));
            $level=getVar('level');
            $gchance=getVar('chance');
            $i=0;
            $qry=$sql[3]->query("SELECT `charId` FROM `{$db['database']}`.`characters` WHERE `level`>'$level' GROUP BY `account_name`");
            while($char=SQL::fetchArray($qry))
            {
                $chance=rand(0,100);
                if($chance>$gchance) continue;
                $i++;
                $time=time();
                $sql[3]->query("TRUNCATE TABLE `{$db['database']}`.`character_offline_trade`;");
                $sql[3]->query("TRUNCATE TABLE `{$db['database']}`.`character_offline_trade_items`");
                $query="INSERT INTO `{$db['database']}`.`character_offline_trade` (`charId`, `time`, `type`) VALUES ('{$char['charId']}', '$time', '3')";
                $sql[3]->query($query);
                $item=$items[rand(0,2)];
                $query="INSERT INTO `{$db['database']}`.`character_offline_trade_items` (`charId`, `item`, `count`, `price`) VALUES ('{$char['charId']}', '$item', '1', '1')";
                $sql[3]->query($query);
            }
            echo $i." Offliners added!";
        }
        else
        {
            ?>
            <form action="" method="post">
            <table><tr><td>Server</td><td>
            <select name="server">
            <?php
            $sql[0]->query("SELECT * FROM `gameservers`");
            while($srv=SQL::fetchArray())
            {?>
                <option value="<?php echo $srv['id'];?>"><?php echo $srv['name'];?></option>
      <?php }?>
            </select></td></tr>
            <tr><td>Character chance:</td><td><input name="chance" value="50" title="Character Chance" /></td></tr>
            <tr><td>Min Char Level:</td><td><input name="level" value="60" title="Character Minimal Level" /></td></tr>
            <tr><td align="center"><?php echo button('go'); ?></td></tr>
            </table>
            </form>
            <?php
        }
        break;
        
    default:
        if($_POST)
        {
        $qry=$sql[0]->query("SELECT name, config.type as type_id, config_type.type as type_name, value FROM l2web.config , l2web.config_type WHERE config.type =  id;");
        while ( $row = SQL::fetchArray($qry) )
        {
            $type =getVar($row['type_id'].'_'.$row['name'].'_t');
            $value=getVar($row['type_id'].'_'.$row['name'].'_v');
            $sql[0]->query("UPDATE `config` SET `type`='$type', `value` = '$value' WHERE `name` = '{$row['name']}' AND `type`='{$row['type_id']}'");
            $item=$Lang[$row['type_name']].'->'.$Lang[$row['type_name'].'_'.$row['name']].' ';
            if(SQL::getRowCount())
                msg($Lang['success'],$item.$Lang['success_update']);
            else
                msg($Lang['warning'],$item.$Lang['failed_to_update_or'], 'warning');
        }
        }
        else
        {
            ?>
            <form action="" method="post">
            <table border="1"><?php
            $types=array();
            $tqry=$sql[0]->query("SELECT * FROM config_type");
            while($type=SQL::fetchArray($tqry))
            {
                array_push($types, $type);
            }
            $qry=$sql[0]->query("SELECT name, config.type as type_id, config_type.type as type_name, value FROM l2web.config , l2web.config_type WHERE config.type =  id;");
            while ( $row = SQL::fetchArray($qry) )
            {?>
                <tr>
                <td><?php echo $Lang[$row['type_name'].'_'.$row['name']];?>:</td>
                <td><select name="<?php echo $row['type_id'].'_'.$row['name'];?>_t">
                <?php
                foreach($types as $type)
                {
                    $sel=$row['type_id']==$type['id']?' selected="selected"':'';
                    echo '<option value="'.$type['id'].'"'.$sel.'>'.$Lang[$type['type']].'</option>';
                }
                ?>
                </select></td>
                <td><input name="<?php echo $row['type_id'].'_'.$row['name'];?>_v" size="50" value="<?php echo htmlspecialchars(html_entity_decode(stripslashes($row['value'])));?>" type="text" /></td>
                </tr>
      <?php }?>
            
            </table><input value="<?php echo $Lang['save'];?>" type="submit" />
            </form><?php
        }
        break;
}
foot();
?>