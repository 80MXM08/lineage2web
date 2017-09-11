<style>
.info {
    margin: 6px 0 0px 0;
    padding: 5px;
    border: 1px solid #8CABC8;
    background-color: #D7E5F1;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$db_host = 'localhost';
	$db_user = 'acc';
	$db_password = 'pw';
	$db_name = 'db';
	$connection = mysql_connect($db_host, $db_user, $db_password) or die("Kljuda piesledzoties MYSQL!");
	mysql_select_db($db_name, $connection);
	
			if(isset($_POST["donate"])) {
		
		if(empty($_POST['code']) or (!eregi("^[0-9]{8}$",$_POST['code']))) {
		$error = "Kods nav derigs!!!";
		}
		if(empty($_POST['nick'])) {
		$error = "Ievadi niku!";
		}
		
		if(isset($error)) {
		echo "$error";
		}
		else {
		
		$code = $_POST['code'];
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$time = time();
		$nick = $_POST['nick'];
		$config['id']=21; // Lietotaja ID (var atrast Solar-F Statistika - http://stats.solarf.lv )
$config['prices']=array(1=>'slr15','slr25','slr35','slr50','slr60','slr75','slr95','slr150','slr200','slr250','slr300'); // Te lugums neko nemainit!
// Identiski ja jums ir cits keywords nevis 'slr' tad visiem augstak minetajiem price jaizskatas 'jusu_keywords15', 'jusu_keywords25' utt
function check_valid_code($code){
global $config;

foreach($config['prices'] as $i => $val){
$check = join('', file("http://sms.solarf.lv/confirm.php?id=".$config[id]."&price=".$val."&code=$code"));
if($check=='key_ok'){
    return $val;
	
}

}

}
$code=mysql_escape_string($_POST['code']);
$val=check_valid_code($code);
if(isset($val)) {

$amout =	preg_replace('/[^\d]/','',"$val"); 

mysql_query("INSERT INTO `donates` (`name`, `price`, `time`, `code`, `ip`) VALUES ('$nick', '$amout', '$time', '$code', '$user_ip');");
echo "Paldies par ziedojumu!";
}
else {
echo "Kods nav derigs!";
}
		
		}
		}
?>

					
					<div id="post-32" class="">
			<div class="entry-head">
				<h3 class="entry-title"><a href="#" rel="bookmark">Palidziba projektam</a></h3>

				<div class="entry-meta">
					
					</a>
					
									</div> 

			</div>

			<div class="entry-content">
		
 					
					<div class="info"><center> <br> Lai noziedot projektam  <br><br>Suti kodu: <strong><font color="red">SLR15</font></strong> uz numuru <strong><font color="red">157</font></strong>
								<br>(<u>SMS cena 0.15 Ls</u>)  
								<br><br>Suti kodu: <strong><font color="red">SLR25</font></strong> uz numuru <strong><font color="red">157</font></strong>

								<br>(<u>SMS cena 0.25 Ls</u>)  
								<br><br>Suti kodu: <strong><font color="red">SLR35</font></strong> uz numuru <strong><font color="red">157</font></strong>
								<br>(<u>SMS cena 0.35 Ls</u>)  

								<br><br>Suti kodu: <strong><font color="red">SLR50</font></strong> uz numuru <strong><font color="red">157</font></strong>
								<br> (<u>SMS cena 0.50 Ls</u>)  
<br><br>Suti kodu: <strong><font color="red">SLR75</font></strong> uz numuru <strong><font color="red">157</font></strong>

								<br> (<u>SMS cena 0.75 Ls</u>)   
								<br><br>Suti kodu: <strong><font color="red">SLR300</font></strong> uz numuru <strong><font color="red">157</font></strong>
								<br> (<u>SMS cena 3.00 Ls</u>)   
								
								

								</div>
					</center>
					<center>
					<form action="" method="post">
					<b>Nick</b><br>
										<INPUT name="nick" maxlength='8' onclick="this.value=''" value="Nick..">
											<BR>
										
										<b>UNLOCK Code</b><br>
										<INPUT name="code" maxlength='8'>
									<BR>
									

					
										<input type="submit" name="donate" value="OK">
					
					
					</form>
					
				</div> 

		</div>
		
		<span style="font-size: 10px;">--------------------------------------------------------------------------------------------------</span>
		<table width="100%">
			
		<?php
  $i = 1;
  $res = mysql_query("select name, time, sum(price) as 'sum' from donates group by name order by sum desc limit 10");
  while ($row = mysql_fetch_assoc($res)) {
  echo "<tr><td width=70%>&nbsp;&nbsp;<img src='http://www.softlist.net/images/icons/perfect_people_icons_desktop_icons-22160.gif' width=16 height=16> ".htmlspecialchars($row['name'])."</td><td>".round($row['sum']/100, 2)." LS</td></tr>\n";
  $i++;
  }
?>

</table>
</center>