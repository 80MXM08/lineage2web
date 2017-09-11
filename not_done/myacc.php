<?php
define('INWEB', True);
require_once("include/config.php");
includeLang('user');
includeLang('myacc');

head(getLang('my_chars'));

if ($user->logged())
{
    echo sprintf(getLang('welcome'), $_SESSION['account']);?>
    <br /><?php
    $timevoted = $_SESSION['vote_time'];
$now = time();

if ($timevoted <= ($now-60*60*12))
{
    echo "<a href=\"vote.php\"><font color=\"red\">".getLang('vote')."</font></a><br />";
}else{
    echo "<font color=\"red\">You can vote again after ". date('H:i:s', $timevoted -($now-60*60*12)-60*60*2) ."</font><br />";
}?>
    <a href="changepass.php"><?php echo getLang('changepass');?></a><br />
    Your Referal Url: <input type="text" name="refurl" value="http://l2.pvpland.lv/reg.php?ref=<?php echo $_SESSION['account'];?>" size="40" onclick="select()"  readonly="readonly" /><br />
    Every user who registers from your link will add you <?php echo getConfig('voting','reg_reward','5');?> webpoints<br />
    <h1>Your Chars</h1>
    1 Webpoint = 2500 (12.5%) Vitality points, max = 20000 (4 LvL 100%)
    <?php
    $dbq = $sql->query("SELECT `id`, `name`, `database` FROM `$webdb`.`gameservers` WHERE `active` = 'true'");
    while($dbs = $sql->fetchArray($dbq))
    {
    	$dbn = $dbs['database'];

    
    ?><br />
    <hr />
    <h1><?php echo $dbs['name'];?></h1>
    <?php
    $sqlq=$sql->query("SELECT `account_name`, `charId`, `char_name`, `level`, `maxHp`, `maxCp`, `maxMp`, `sex`, `karma`, `fame`, `pvpkills`, `pkkills`, `race`, `online`, `onlinetime`, `onlinemap`, `lastAccess`, `nobless`, `vitality_points`, `ClassName`, `clan_id`, `clan_name` FROM `$dbn`.`characters` INNER JOIN `$dbn`.`char_templates` ON `characters`.`classid` = `char_templates`.`ClassId` LEFT OUTER JOIN `$dbn`.`clan_data` ON `characters`.`clanid`=`clan_data`.`clan_id` WHERE `account_name` = '{$_SESSION['account']}';");
    if ($sql->numRows($sqlq) != 0)
    {
    	?>
        <table border="1">
        <tr><td><?php echo $Lang['face'];?></td><td><?php echo $Lang['name'];?></td><td><?php echo $Lang['level'];?></td><td><?php echo $Lang['class'];?></td><td class="maxCp"><?php echo $Lang['cp'];?></td><td class="maxHp"><?php echo $Lang['hp'];?></td><td class="maxMp"><?php echo $Lang['mp'];?></td><td><?php echo $Lang['clan'];?></td><td><?php echo $Lang['pvp_pk'];?></td><td><?php echo $Lang['online_time'];?></td><td><?php echo $Lang['online'];?></td><td><?php echo $Lang['unstuck'];?></td><td>OnlineMap</td><td>Vitality</td></tr>
<?php
$i=0;
    while($char=$sql->fetchArray($sqlq))
    {
        $i++;
        $onlinetimeH=round(($char['onlinetime']/60/60)-0.5);
	$onlinetimeM=round(((($char['onlinetime']/60/60)-$onlinetimeH)*60)-0.5);
        if ($char['online']) {$online='<img src="img/status/online.png" alt="" />';} 
	else {$online='<img src="img/status/offline.png" alt="" />';}
	$map = ($char['onlinemap'] == 'true') ? 'checked="checked"':'';
        if ($char['clan_id']) {$clan_link = "<a href=\"claninfo.php?clan={$char['clan_id']}\">{$char['clan_name']}</a>";}else{$clan_link = "No Clan";}
 ?>
<tr<?php echo ($i%2==0)?' style="altRow"':'';?> ><td><img src="img/face/<?php echo $char['race'].'_'.$char['sex'];?>.gif" alt="" /></td><td><a href="user.php?cid=<?php echo $char['charId'];?>"><font color="<?php echo $color;?>"><?php echo $char['char_name'];?></font></a></td><td><?php echo $char['level'];?></td><td><?php echo $char['ClassName'];?></td><td class="maxCp"><?php echo $char['maxCp'];?></td><td class="maxHp"><?php echo $char['maxHp'];?></td><td class="maxMp"><?php echo $char['maxMp'];?></td><td><?php echo $clan_link;?></td><td><b><?php echo $char['pvpkills'];?><font color="red"><?php echo $char['pkkills'];?></font></b></td><td><?php echo $onlinetimeH.' '.$Lang['hours'].' '.$onlinetimeM.' '.$Lang['min'];?></td><td><?php echo $online;?></td><td><a href="unstuck.php?cid=<?php echo $char['charId'];?>"><?php echo $Lang['unstuck'];?></a></td><td><input type="checkbox" id="onlinemap" name="onlinemap" onchange="map(<?php echo $dbs['ID'];?>,<?php echo $char['charId'];?>);" <?php echo $map;?> /></td><td onclick="raiseVitality(<?php echo $dbs['ID'];?>,<?php echo $char['charId'];?>, <?php echo $i;?>);"><img id="vitality<?php echo $i;?>" src="img/ss/ssqbar2.gif" width="<?php echo $char['vitality_points']/250;?>" height="9" border="0" alt="<?php echo $char['vitality_points'];?>/20000 = <?php echo $char['vitality_points']/2000*100;?>%" title="<?php echo $char['vitality_points'];?>/20000 = <?php echo $char['vitality_points']/20000*100;?>%" onclick=""/></td></tr>
<?php
    }
    echo "</table>";
    } else {echo '<h1>'.$Lang['no_characters'].'</h1>';}
    }
} else {echo '<h1>'.$Lang['login'].'</h1>';}
foot();
?>