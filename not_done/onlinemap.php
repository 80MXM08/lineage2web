<?php
define('INWEB', true);
require_once('include/config.php');
//header("Cache-Control: no-cache");
//header("Expires: -1");
head('Online Map',0);
$webdb=getConfig('settings','webdb','l2web');
if(isset($_GET['server']) && is_numeric($_GET['server']))
{
	$server = 0 + $_GET['server'];
	$s_db = $sql->result($sql->query("SELECT `DataBase` FROM `$webdb`.`gameservers` WHERE `ID` = '$server';"));
}else
{
	$s_db = getConfig('settings','DDB','l2jdb');
}

$parse['server_list'] = NULL;
$server_list = $sql->query("SELECT `ID`, `Name` FROM `$webdb`.`gameservers`");
while($slist = $sql->fetch_array($server_list))
{
	$selected=($slist['ID']==$_GET['server'])?'selected':'';
	$parse['server_list'] .= '<option onclick="GoTo(\'onlinemap.php?server='.$slist['ID'].'\')" '.$selected.'>'.$slist['Name'].'</option>';
}
//if(isset($_GET['type']) AND ($_GET['type'] == 'normal' OR $_GET['type'] == 'big' OR $_GET['type'] == 'very_big'))
//{
//	$map_size=$sql->escape($_GET['type']);
//}else
//{
//	$map_size="small";
//}
//switch($map_size){
//    case 'very_big':
//       $data_red=1300;
//    break;
//    case 'big':
//       $data_red=970;
//    break;
 //   case 'normal':
 //       $data_red=770;
 //   break;
//    default:
//        $data_red=642;
 //   break;
//}
        $data_red=650;
$imgsize['aden']=getimagesize("img/onlinemap/map.jpg");
//$imgsize['aden']=getimagesize("img/onlinemap/map_aden_".$map_size.".jpg");
$map['aden_x']=$imgsize['aden'][0] / 100;
$map['aden_y']=$imgsize['aden'][1] / 100;
$totalonline = $sql->result($sql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `online`"));
$hiddenonline = $sql->result($sql->query("SELECT count(`charId`) FROM `$s_db`.`characters` WHERE `online` AND `onlinemap`='false'"));
$showusers = $user->admin() ? $totalonline : $totalonline-$hiddenusers;
?>
<table align="center">
    <tr align="center"><td align="center"><h1>Online players Map:</h1></td></tr>
    <tr align="center"><td><a href="onlinemap.php">Small</a> | <a href="onlinemap.php?type=normal">Normal</a> | <a href="onlinemap.php?type=big">Big</a> | <a href="onlinemap.php?type=very_big">Large</a></td></tr>
    <tr align="center"><td>Online Users: <?php echo $totalonline;?>&nbsp;&nbsp;&nbsp;&nbsp;Hidden Online Users: <?php echo $hiddenonline;?>&nbsp;&nbsp;&nbsp;&nbsp;Users listed: <?php echo $showusers;?></td></tr>
    <tr><td><select><?php echo $parse['server_list'];?></select></tr>
    <tr align="center"><td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="main-tables">
        <tr><td class="widelist-txt">
            <div style="width: <?php echo $imgsize['aden'][0]; ?>px; height: <?php echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/map.jpg'); z-index: 1;">
            <?php
            $count=0;
            if($user->admin())
            {
                $char_query = "SELECT `char_name`, `characters`.`x`, `characters`.`y`, `characters`.`z`, `race`, `level`, `ClassName` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` WHERE `online`";
            }
            else
            {
                $char_query = "SELECT `char_name`, `characters`.`x`, `characters`.`y`, `characters`.`z`, `race`, `level`, `ClassName` FROM `$s_db`.`characters` INNER JOIN `$s_db`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId` WHERE `online` AND `onlinemap`='true'";
            }
            //$boss_query = "SELECT `id`, `name`, `title`, `level`, `aggro`, `boss_id`, `currentHp`, `currentMp`, `loc_x`, `loc_y`, `loc_z` FROM `$s_db`.`npc` INNER JOIN `$s_db`.`raidboss_spawnlist` ON `npc`.`id`=`raidboss_spawnlist`.`boss_id` WHERE `npc`.`type` = 'L2RaidBoss' AND `raidboss_spawnlist`.`respawn_time`='0'";
            $char_result=$sql->query($char_query);
            while($char=$sql->fetch_array($char_result))
            {
                //$data['x']=($char['x'] + 130000) / 3600;
                //$data['y']=($char['y'] + 0) / 5250;
                //$data['x']=$map['aden_x'] * $data['x'];
                //$data['y']=$map['aden_y'] * $data['y'] + $data_red;
                $data['x'] = $char['x']+325000;
                $data['y'] = $char['y']+225000;
                ?>
                <div style="width: <?php echo $imgsize['aden'][0]; ?>px; height: <?php echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/pin_<?php echo $char['race']; ?>.gif'); background-repeat: no-repeat; background-position: <?php echo round($data['x']); ?>px <?php echo round($data['y']); ?>px; z-index: <?php echo $count+2; ?>;">
                <?php
                $count++; 
            }
            
            /*$boss_result=$sql->query($boss_query);
            while($rboss=$sql->fetch_array($boss_result))
            {
                $data['loc_x']=($rboss['loc_x'] + 130000) / 3000;
                $data['loc_y']=($rboss['loc_y'] + 0) / 1000;
                $data['loc_x']=$map['aden_x'] * $data['loc_x'];
                $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;    
                ?>
                <div style="width: <?php echo $imgsize['aden'][0]; ?>px; height: <?php echo $imgsize['aden'][1]; ?>px; background-image: url('img/onlinemap/bug3.png'); background-repeat: no-repeat; background-position: <?php echo $data['loc_x']; ?>px <?php echo $data['loc_y']; ?>px; z-index: <?php echo $count+2; ?>;">
                <?php
                $count++; 
            }*/
            ?>
            <map name="Map-Aden" id="Map-Aden">
            <?php
            $char_result=$sql->query($char_query);
            while($char=$sql->fetch_array($char_result))
            {
                $data['x']=($char['x'] + 130000) / 3000;
                $data['y']=($char['y'] + 0) / 1000;
                $data['x']=$map['aden_x'] * $data['x'];
                $data['y']=$map['aden_y'] * $data['y'] + $data_red;
                ?>
                <area shape="rect" coords="<?php echo round($data['x']); ?>,<?php echo round($data['y']); ?>,<?php echo round($data['x']) + 20; ?>,<?php echo round($data['y']) + 20; ?>" title="<?php echo $char['char_name']." - {$char['ClassName']}[".$char['level']."]"; ?>" alt="" />
                <?php
            } 
            /*
            $boss_result=$sql->query($boss_query);
            while($rboss=$sql->fetch_array($boss_result))
            {
                $data['loc_x']=($rboss['loc_x'] + 130000) / 3000;
                $data['loc_y']=($rboss['loc_y'] + 0) / 1000;
                $data['loc_x']=$map['aden_x'] * $data['loc_x'];
                $data['loc_y']=$map['aden_y'] * $data['loc_y'] + $data_red;
                if($rboss['aggro'] == 0) {$rboss['aggro']="no";}else{$rboss['aggro']="yes";}
                //if($rboss['isUndead']== 0) {$rboss['isUndead']="no";}else{$rboss['isUndead']="yes";}
                ?>
                <area shape="rect" coords="<?php echo $data['loc_x']; ?>,<?php echo $data['loc_y']; ?>,<?php echo $data['loc_x'] + 20; ?>,<?php echo $data['loc_y'] + 20; ?><?php echo $rboss['id']; ?>" title="<?php echo $rboss['title']." Name: ".$rboss['name']." , LvL: ".$rboss['level']." , Undead: ".$rboss['isUndead'].", Aggro:".$rboss['aggro'].", HP: ".$rboss['currentHp']." , MP: ".$rboss['currentMp']." , Loc: [x:".$rboss['loc_x']."y:".$rboss['loc_y']."z:".$rboss['loc_z']."]."; ?>" alt="" />
                <?php
            } */
            ?>
            </map>
            <img src="img/onlinemap/leer.gif" border="0" width="<?php echo $imgsize['aden'][0]; ?>" height="<?php echo $imgsize['aden'][1]; ?>" usemap="#Map-Aden" alt="" />
            <?php
            while($count != 0)
            {
                ?></div><?php
                $count--;
            }
            ?>
            </div>
        </td></tr>
    </table>
    </td></tr>
</table>
<?php
foot(0);
?>