<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Donate");
//includeLang('donate');
?>
<table cellpadding="5" cellspacing="5">
<tr><td><a href="sms_fort.php"><img src="img/sms/smsplus.gif" alt="SMS" title="SMS" border="0" /></a></td><td><a href="paypal_donate.php"><img src="img/paypal.gif" alt="Donate with paypal" title="Donate with paypal" border="0" /></a></td></tr>
</table>
<?php
//$action = $_GET['action'];
//if($action='addtodb')
//{
//    msg("NOT YET FINISHED");
//}
####################
/*if($action='smscoin')
{
### SMS:Key v1.0.6 ###
$old_ua = @ini_set('user_agent', 'smscoin_key_1.0.6');
$key_id = 221463;
$response = @file("http://key.smscoin.com/language/english/key/?s_pure=1&s_enc=utf-8&s_key=".$key_id
."&s_pair=".urlencode(substr($_GET["s_pair"],0,10))
."&s_language=".urlencode(substr($_GET["s_language"],0,10))
."&s_ip=".$_SERVER["REMOTE_ADDR"]
."&s_url=".$_SERVER["SERVER_NAME"].htmlentities(urlencode($_SERVER["REQUEST_URI"])));
if ($response !== false) {
 if (count($response)>1 || $response[0] != 'true') {
  die(implode("", $response));
 }
} else die('Не удалось запросить внешний сервер');
@ini_set('user_agent', $old_ua);
### SMS:Key end ###
}
####################
function cena($code) {
    $slr = array('slr35', 'slr75', 'slr95', 'slr200', 'slr300', 'slree10', 'slree25', 'slree35', 'slrlt2', 'slrlt3','slrlt5', 'slrlt7', 'slrlt10');
    $wp = array('4', '10', '15', '40', '75', '4', '17', '25', '4', '7','15', '25', '40');
    $wpcount = str_replace($slr, $wp, $code);
    return $wpcount;
}
$ip = $_SERVER['REMOTE_ADDR'];
$error=0;
if(logedin())
{
    $account = $_SESSION['account'];
}
else
{
    if($_POST)
    {
    $account = mysql_real_escape_string($_POST['account']);
    $account=mysql_result(mysql_query("SELECT `login` FROM `accounts` WHERE `login` = '".$account."' LIMIT 1"), 0, 0);
    if(!$account){
        echo sprintf($Lang['notfound'], $_POST['account']);
        $error++;
        mysql_query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('$ip', 'Donate', 'Error', 'Reason=\"Account not found (".mysql_real_escape_string($_POST['account']).")\"');");
    }
    }
}
//if(eregi("^[0-9]{8}$",$_POST['code']))
//die('erregi=true');
if (isset($_POST['code']) && isset($_POST['vertiba']) && !$error){
    $code = 0 + $_POST['code'];
    $id = 92;
    $price = mysql_real_escape_string($_POST['vertiba']);
    $answer = @file_get_contents("http://sms.solarf.lv/confirm.php?code=$code&id=$id&price=$price",FALSE,NULL,0,140);
    $newprice = cena($price);
    if (isset($answer) && $answer == 'key_ok') {
        $time = time();


        ################################## REWARD ####################################
        mysql_query("UPDATE `accounts` SET `webpoints`=`webpoints`+'$newprice' WHERE `login`='$account'");
        mysql_query("INSERT INTO donates (name, price, time, code, ip) values ('$account', '$newprice', '$time', '$code', '$ip')");
        mysql_query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('$account', 'Donate', 'Success', 'Code=\"$code\", WebPointReward=\"$newprice\"');");
        ################################## REWARD ####################################
      echo sprintf($Lang['ty_for_donate'], $account);
    }else{
        echo $Lang['sry_code_incorrect'];
        mysql_query("INSERT INTO `".$DB['webdb']."`.`log` (`Account`, `Type`, `SubType`, `Comments`) VALUES ('$account', 'Donate', 'Error', 'Reason=\"Incorrect Code (".mysql_real_escape_string($_POST['code']).")\"');");
    }
}
?>
<table border="0" width="470" cellspacing="0" cellpadding="0" class="btb">
<tr><td>
<script type="text/javascript">
function show(ele) {
	document.getElementById('vert0').style.display='none';
	document.getElementById('vert1').style.display='none';
	document.getElementById('vert2').style.display='none';
	document.getElementById('vert3').style.display='none';
	document.getElementById('vert4').style.display='none';
	document.getElementById('vert5').style.display='none';
	document.getElementById('vert6').style.display='none';
	document.getElementById('vert7').style.display='none';
	document.getElementById('vert8').style.display='none';
	document.getElementById('vert9').style.display='none';
	document.getElementById('vert10').style.display='none';
	document.getElementById('vert11').style.display='none';
	document.getElementById('vert12').style.display='none';
	document.getElementById('vert13').style.display='none';
	document.getElementById('smsform').style.display='block';
	document.getElementById(ele).style.display='block';
	return false;
}
</script>

<div align="center">
    <p><?php echo $Lang['choose_price'];?>:</p>
    <table width="100%" align="left">
	   <tr>
		  <td width="250" align="left" valign="top">
		      <div class="block">
                <form id="smsdonate" action="" method="post">
                    <table border="0">
	                   <tr>
		                  <td align="center">
		                  <span><input onclick="show('vert1')" type="radio" value="slr35" name="vertiba" />0.35 LVL = 4 WP</span><br />
		                  <span><input onclick="show('vert2')" type="radio" value="slr75" name="vertiba" />0.75 LVL = 10 WP</span><br />
		                  <span><input onclick="show('vert3')" type="radio" value="slr95" name="vertiba" />0.95 LVL = 15 WP</span><br />
		                  <span><input onclick="show('vert4')" type="radio" value="slr200" name="vertiba" />2.00 LVL = 40 WP</span><br />
		                  <span><input onclick="show('vert5')" type="radio" value="slr300" name="vertiba" />3.00 LVL = 75 WP</span><br />
                          </td>
		
		                  <td align="center">
		                  <span><input onclick="show('vert6')" type="radio" value="slrlt2" name="vertiba" />2 LTL = 4 WP</span><br />
		                  <span><input onclick="show('vert7')" type="radio" value="slrlt3" name="vertiba" />3 LTL = 7 WP</span><br />
		                  <span><input onclick="show('vert8')" type="radio" value="slrlt5" name="vertiba" />5 LTL = 15 WP</span><br />
                          <span><input onclick="show('vert9')" type="radio" value="slrlt7" name="vertiba" />7 LTL = 25 WP</span><br />
		                  <span><input onclick="show('vert10')" type="radio" value="slrlt10" name="vertiba" />10 LTL = 40 WP</span><br />
                          </td>
                          
                          <td align="center">
		                  <span><input onclick="show('vert11')" type="radio" value="slree10" name="vertiba" />10 EEK = 4 WP</span><br />
		                  <span><input onclick="show('vert12')" type="radio" value="slree25" name="vertiba" />25 EEK = 17 WP</span><br />
		                  <span><input onclick="show('vert13')" type="radio" value="slree35" name="vertiba" />35 EEK = 25 WP</span><br />
                          </td>
                        </tr>
                    </table>
                    <div id="smsbox">
                        <div id="vert0">&nbsp;</div>
                        <div id="vert1" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR35', '157', 'LMT/Tele2/Bite', '0.35', 'LVL')?></div>
                        <div id="vert2" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR75', '157', 'LMT/Tele2/Bite', '0.75', 'LVL')?></div>	
                        <div id="vert3" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR95', '157', 'LMT/Tele2/Bite', '0.95', 'LVL')?></div>
                        <div id="vert4" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR200', '157', 'LMT/Tele2/Bite', '2.00', 'LVL')?></div>
                        <div id="vert5" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLR300', '157', 'LMT/Tele2/Bite', '3.00', 'LVL')?></div>
                        
                        <div id="vert6" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT2', '1337', 'Tele2/Bite/Omnitel', '2.00', 'LTL')?></div>
                        <div id="vert7" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT3', '1337', 'Tele2/Bite/Omnitel', '3.00', 'LTL')?></div>
                        <div id="vert8" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT5', '1337', 'Tele2/Bite/Omnitel', '5.00', 'LTL')?></div>
                        <div id="vert9" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT7', '1337', 'Tele2/Bite/Omnitel', '7.00', 'LTL')?></div>
                        <div id="vert10" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLRLT10', '1337', 'Tele2/Bite/Omnitel', '10.00', 'LTL')?></div>
                        
                        <div id="vert11" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE10', '13011', 'EMT/TELE2/Elisa', '10.00', 'EEK')?></div>
                        <div id="vert12" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE25', '13013', 'EMT/TELE2/Elisa', '25.00', 'EEK')?></div>
                        <div id="vert13" style="display: none;"><?php echo sprintf($Lang['send_code_to'], 'SLREE35', '13015', 'EMT/TELE2/Elisa', '35.00', 'EEK')?></div>
                    </div>
                    <div id="smsform" style="display: none;">
                        <table>
                            <tbody>
                                <tr><td><?php echo $Lang['unlock_code'];?>:</td><td><input name="code" /></td></tr>
                                <tr><td><?php echo $Lang['name'];?>:</td><td><?php if(!logedin()){?><input name="account" /><?php } ?></td></tr>
                                <tr><td></td><td colspan="2"><input class="button" type="submit" value="<?php echo $Lang['do_donate'];?>" /></td></tr>
                            </tbody>
                        </table>
                    </div>
                </form>
		      </div>
		  </td>					
	   </tr>
    </table>
</div>
</td></tr></table>
<?php*/
foot();
?>