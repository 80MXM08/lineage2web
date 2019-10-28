<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Base64 Encode / Decode</title>
</head>
<body>
<form action="base64.php" method="POST">
<textarea name="data"><?php echo isset($_POST['data'])?$_POST['data']:'';?></textarea><br />
<input type="radio" name="a" value="enc" />Encode
<input type="radio" name="a" value="dec" />Decode<br />
<input type="submit"/>
</form><br />
<textarea>
<?php
if(isset($_POST['a'])&&$_POST['a']=='dec')
{
    echo base64_decode($_POST['data']);
}
else if(isset($_POST['a']) && $_POST['a']=='enc')
{
    echo base64_encode($_POST['data']);
}
?>

</textarea>
</body>
</html>