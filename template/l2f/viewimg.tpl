<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>View Image</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />

 <script type="text/javascript">
   var arrTemp=self.location.href.split("&");
   var picUrl = (arrTemp.length>0)?arrTemp[1]:"";
   var NS = (navigator.appName=="Netscape")?true:false;

     function FitPic() {
       iWidth = (NS)?window.innerWidth:document.body.clientWidth;
       iHeight = (NS)?window.innerHeight:document.body.clientHeight;
       iWidth = document.images[0].width - iWidth;
       iHeight = document.images[0].height - iHeight;
       window.resizeBy(iWidth, iHeight);
       self.focus();
     };
 </script>
</head>
<body onload="FitPic();">
 <script type="text/javascript">
 <!--
 document.write( "<img src='news/" + picUrl + "' alt='' />" );
 // -->
 </script>
</body>
</html>