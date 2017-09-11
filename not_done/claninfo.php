<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
if(isset($_GET['clan'])){
    $clanid=getVar('clan');  
    $srv=getVar('server');
    $dbname = getDBName($srv);
    $query=$sql->query('SELECT `clan_id`, `clan_name`, `clan_level`, `reputation_score`, `charId`, `char_name` FROM `'.$dbname.'`.`clan_data` INNER JOIN `'.$dbname.'`.`characters` ON `clan_data`.`leader_id`=`characters`.`charId` WHERE `clan_id`='.$clanid);
    if($sql->num_rows($query))
    {
        includeLang('clan_info');
        head($Lang['clan_info']);
        $clan_data=$sql->fetch_array($query);
        ?>
         <div align="center"><h1>Clan Info</h1></div>
        <div align="center">
        <table border="1">
        <tr><td><?php echo $Lang['clan'];?>: </td><td><?php echo $clan_data['clan_name'];?></td></tr>
        <tr><td><?php echo $Lang['leader'];?>: </td><td><a href="user.php?cid=<?php echo $clan_data['charId'];?>&amp;server=<?php echo $srv;?>"><?php echo $clan_data['char_name'];?></a></td></tr>
        <tr><td><?php echo $Lang['lvl'];?>: </td><td><?php echo $clan_data['clan_level'];?></td></tr>
        <tr><td><?php echo $Lang['rep'];?>: </td><td><?php echo $clan_data['reputation_score'];?></td></tr>
        </table>
        </div>
         <div align="center"><h1>Clan Skills</h1></div>
        <div align="center">
        <table border="1">
        <?php
        $clan_skills=$sql->query("SELECT * FROM `clan_skills` WHERE `clan_id`='$clanid'");
        $i=0;
        while($clan_skill=$sql->fetch_array($clan_skills))
        {
            if($i==0)
            {
                echo '<tr>';
            }
            echo "<td><img src=\"img/skill/icon.skill0{$clan_skill['skill_id']}.png\" alt=\"\" onmouseover=\"Tip('{$clan_skill['skill_name']} <br /> Level {$clan_skill['skill_level']} <br /> <img src=img/skill/icon.skill0{$clan_skill['skill_id']}.png />', FONTCOLOR, '#FFFFFF',BGCOLOR, '#406072', BORDERCOLOR, '#666666', FADEIN, 500, FADEOUT, 500, FONTWEIGHT, 'bold')\"/></td>";
            if($i==9)
            {
                echo '</tr>';
                $i=0;
            }
            $i++;
        }
        if($i!=0)
        {
            echo '</tr>';
        }
        ?>
        </tr>
        </table>
        </div>
        <div align="center"><h1><?php echo $Lang['clan_members'];?></h1>
        <table border="1" align="center"><thead><tr><th><?php echo $Lang['nr'];?></th><th><?php echo $Lang['name'];?></th><th><?php echo $Lang['sex'];?></th><th><?php echo $Lang['class'];?></th><th>Level</th><th><?php echo $Lang['pvp_pk'];?></th><th>Fame</th></tr></thead>
        <tbody>
        <?php
        $query=$sql->query('SELECT `charId`, `char_name`, `sex`, `level`, `fame`, `pvpkills`, `pkkills`, `ClassName` FROM `'.$dbname.'`.`characters` INNER JOIN `'.$dbname.'`.`char_templates` ON `characters`.`base_class`=`char_templates`.`ClassId`  WHERE `clanid`='.$clan_data['clan_id'].' AND charId!='.$clan_data['charId'].' ORDER BY `level` DESC,`pvpkills` DESC, `fame` DESC');
        $i=0;
        while($clan_char=$sql->fetch_array($query))
        {
            $i++;
            ?>
            <tr><td><?php echo $i;?></td><td><a href="user.php?cid=<?php echo $clan_char['charId'];?>&amp;server=<?php echo $srv;?>"><?php echo $clan_char['char_name'];?></a></td><td><?php echo ($clan_char['sex']==0)? '<img src="img/stat/sex.jpg" alt="'.$Lang['male'].'" />':'<img src="img/stat/sex1.jpg" alt="'.$Lang['female'].'" />';?></td><td><?php echo $clan_char['ClassName'];?></td><td><?php echo $clan_char['level'];?></td><td><?php echo $clan_char['pvpkills'].' / '.$clan_char['pkkills'];?></td><td><?php echo $clan_char['fame'];?></td></tr>
            <?php
        }
        ?>
        </tbody>
        </table>
        </div>
        <?php
        foot();
    }else
    {
        header('Location:index.php');
    }
}else{
    header('Location:index.php');
}
?>