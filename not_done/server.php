<?php
//пароль
if(isset($_GET['lang'])){	
if(is_numeric($_GET['lang'])){
$langid = 0+$_GET['lang'];
	setcookie('lang', $langid, 0, '/', '', 0, 0);
	Header("Location: index.php");
}
}else if(isset($_GET['skin']) || isset($_POST['skin'])){
$skin = (isset($_GET['skin'])) ? trim($_GET['skin']): trim($_POST['skin']);
	setcookie('skin', $skin, 0, '/', '', 0, 0);
	Header("Location: index.php");

}else{die();}
?>