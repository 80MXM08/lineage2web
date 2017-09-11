<?php
define('WEB', True);
require_once("include/core.php");
//пароль
head('',0);
if($_GET['id'])
{
    $id=getVar('id', 'int');
    $item=$sql[0]->query("SELECT * FROM `all_items` WHERE `id`='$id'");
    $i=SQL::fetchArray();
    ?>

    <table width="425px" border="0" style="color: white;"><tr><td>
    <font color="#FFFFFF">
    <table cellpadding="5" cellspacing="5" border="2" width="425px">
    <tr><td><img src="img/icons/<?php echo $i['icon1'];?>.png" alt="<?php echo $i['name'];?>" title="<?php echo $i['name'];?>" width="64" height="64"/></td>
    <td>
    <table border="1" width="315px">
    <tr><td>Name</td><td><?php echo $i['name'];?></td></tr>
    <tr><td>Additional name</td><td><?php echo $i['add_name'];?></td></tr>
    <tr><td>Type</td><td><?php echo $i['type'];?></td></tr>
    <tr><td>Body Part</td><td><?php echo $i['bodypart'];?></td></tr>
    <?php
    $grade=($i['grade']!='none')?"<img src=\"img/grade/{$i['grade']}-grade.png\" alt=\"{$i['grade']}\" title=\"{$i['grade']}\" />":"none";
    ?>
    <tr><td>Grade</td><td><?php echo $grade;?></td></tr>
    </table>
    </td></tr>
    </table>
    <br />
    <?php
    if($i['desc']!="" || $i['grade']=="none")
    {
        if($i['desc']!="")
        {
        ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc'];?></td></tr></table>
    
    <?php
    }
    }
    else
    {
        if($i['bodypart']=="lhand")
            $i['bodypart']="shield";
        //try to find chest from armorsets
        $c=$sql[SQL_NEXT_ID]->query("SELECT `chest` FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
        if(SQL::numRows($c))
        {
            
            $chest_id=SQL::result($c);
            $i['desc']=SQL::result($sql[0]->query("SELECT `desc` FROM `all_items` WHERE `id`='$chest_id'"));
           ?>
    Description:<br />
    <table cellpadding="5" cellspacing="5" border="1" width="425px"><tr><td><?php echo $i['desc'];?></td></tr></table>
    <?php 
        }
    }
    
    //check set items
    if($i['bodypart']=="fullarmor")
        $i['bodypart']="chest";
//    if($i['bodypart']=="lhand")
//        $i['bodypart']="shield";
    if($i['bodypart']=="chest" || $i['bodypart']=="legs" || $i['bodypart']=="head" || $i['bodypart']=="gloves"
    || $i['bodypart']=="feet" || $i['bodypart']=="shield")
    {
    $set=$sql[SQL_NEXT_ID]->query("SELECT * FROM `armorsets` WHERE `{$i['bodypart']}`='{$i['id']}'");
    if($SQL::numRows($set))
    {
    
    ?>
    <br />
    Set items
    <br />
    <?php
    while($i2=SQL::fetchArray($set))
    {
    ?>
    <table border="1" cellpadding="5" cellspacing="5">
    <tr>
    <?php
    for($n=1;$n<8;$n++)
    {
        if($n==6 || $i2[$n]=="0")
            continue;
        $query=$sql[0]->query("SELECT `name`, `icon1` FROM `all_items` WHERE `id`='{$i2[$n]}'");
        $i3=SQL::fetchArray($query);
        if($id!=$i2[$n])
            echo "<td><a href=\"item.php?id={$i2[$n]}\"><img src=\"img/icons/{$i3['icon1']}.png\" alt=\"{$i3['name']}\" title=\"{$i3['name']}\" border=\"0\"/></a></td>";
        else
            echo "<td><img src=\"img/icons/{$i3['icon1']}.png\" alt=\"{$i3['name']}\" title=\"{$i3['name']}\" border=\"0\"/></td>";
    }
    ?>
    </tr>
    </table>
    <?php
}
    }
}
?>
</font></td></tr></table>
<?php
}
foot(0);
?>