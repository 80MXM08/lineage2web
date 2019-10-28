<!DOCTYPE html>
<html id="l2web">
<head lang="en">
<meta charset="UTF-8" />
<meta name="description" content="{metad}" />
<meta name="keywords" content="{metak}" />
<meta name="author" content="80MXM08" />
<meta name="Copyright" content="{copy}" />
<meta name="robots" content="all" />
<meta name="google-site-verification" content="{gsv}" />
{refresh}
<title>{title}</title>

<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link href="themes/{theme}/style.css" type="text/css" rel="stylesheet" />


<script type="text/javascript">//<![CDATA[ 
//document.write(unescape("%3Cscript src='scripts/ga.js' type='text/javascript'%3E%3C/script%3E")); //]]></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="scripts/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="scripts/tinymce/tinymce.min.js"></script>
<!--script type="text/javascript" src="scripts/show.js"></script-->

<!--script type="text/javascript" src="scripts/ajax.js"></script-->
<script type="text/javascript" src="themes/{theme}/scripts/l2f.js"></script>
<script type="text/javascript" src="scripts/l2web.js"></script>


<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>


<script type="text/javascript">
//<![CDATA[
/*
var TimeFormat = "%%D%% {days}, %%H%% {hours}, %%M%% {minutes}, %%S%% {seconds}.";
var banCounter = new Countdown({  
    seconds:<?php //echo ($info[3]-time());?>,  // number of seconds to count down
    onUpdateStatus: function(secs){
        ShowTime = TimeFormat.replace(/%%D%%/g, calctime(secs,86400,100000));
        ShowTime = ShowTime.replace(/%%H%%/g, calctime(secs,3600,24));
        ShowTime = ShowTime.replace(/%%M%%/g, calctime(secs,60,60));
        ShowTime = ShowTime.replace(/%%S%%/g, calctime(secs,1,60));

  document.getElementById("ban_counter").innerHTML = ShowTime;
        
    }, // callback for each second
    onCounterEnd: function(){ alert('counter ended!');} // final action
});

banCounter.start();


*/

var active = true;
var step = -1;
step = Math.ceil(step);
if (step == 0)
  active = false;
var TimeFormat = "%%H%% {hours}, %%M%% {minutes}, %%S%% {seconds}.";
var endmsg = "<a href=\"vote.php\">{vote}</a>";
var secs = "{time}";
var date = new Date();
var time = date.getTime()/1000;
secs = Math.floor(secs - time);
function calctime(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}



try {
var pageTracker = _gat._getTracker("{page_tracker}");
pageTracker._trackPageview();
} catch(err) { }

//]]>
</script>

<style type="text/css">
table
{
	border-spacing: 0px;
}
body
{
	margin : 0px;
	font-size : 14px;
	font-family : Arial;
	color : #ffffff;

	cursor : url('themes/{theme}/cursors/cursor.cur'), auto;
	background: #406072;
}
#logo
{
	display:block;
	z-index: -1;
	/*left:125px;*/
	top:0px;
	position: absolute;
	text-align: center;
	width: auto;
}
#freya
{
	display:block;
	z-index: 0;
	right:0px;
	top:30px;
	position: absolute;
	text-align: center;
}
#header
{
	height: 300px;
	right: 50px;
	top: 50px;
	text-align: right;
}
.opacity1
{
	/*filter: alpha(opacity=70);*/
	opacity: 0.7;
} 
.opacity2
{
	/*filter: alpha(opacity=85);*/
	opacity: 0.85;
}
.block_top
{
	background:url(themes/{theme}/img/block_head.gif) 0 0 no-repeat;
	width:200px;
	height:50px;
	display: block;
	text-align: center;
}
.block_title
{
	padding-top:15px;
}

.block_bot
{
	display: block;
	width:200px;
	height:26px;
	background:url(themes/{theme}/img/block_foot.gif) 0 0 no-repeat;
}
.block_mid
{
	display: block;
	background:url(themes/{theme}/img/block_mid.gif) 0 0 repeat-y;
	width:200px;
}

table.c11 { height: 100px; }
td.c10 {  }
td.c9 { background-image: url(themes/{theme}/img/t_h_cr.gif); }
td.c7 {  }
div.c6 { height:53px; text-align: center; display:block; background-image: url(themes/{theme}/img/t_h_c.gif); background-repeat: no-repeat; background-position: center center; }
td.c5 { background-image: url(themes/{theme}/img/t_h_cl.gif); }
div.c4 { position: right; }
div.c3 { position: center; }
img.c2 { border: 0px; }
div.c1 { position: absolute;z-index: -1; }
</style>
</head>
<body>
<!--<div id="valid">
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-xhtml.png" alt="Valid XHTML 1.0 Transitional" />
</a><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
<img style="border:0;width:88px;height:31px" src="img/valid-css.png" alt="Valid CSS!" /></a>
<a href="http://games.top.org/lineage-2/" title="Lineage 2 TOP.ORG"><img style="border:none;" src="http://img1.top.org/toporg_12309.gif" alt="Lineage 2 TOP.ORG" /></a>
</div>-->

<div id="bg" class="c1">
    <img src="themes/{theme}/bg/bg.jpg" width="100%" alt="" title="{title_desc}" />
</div>

<div id="frm">
	<img width="150" height="150" usemap="#Map" alt="{visit_forum}" class="c2" src="img/visit_forum.png" />
	<map id="Map" name="Map">
		<area href="./forum" target="_blank" coords="3,119,117,3,77,3,3,77,3,119" shape="poly" alt="" />
	</map>
</div>

<div id="logo" class="c3" align="center">
	<img alt="" width="100%" class="c2" src="themes/{theme}/bg/{bg_nr}.png" />
</div>

<div id="freya" class="c4">
	<img alt="" class="c2" src="img/image.png" />
</div>

<div id="header"></div>
{head}