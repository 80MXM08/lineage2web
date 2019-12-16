<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>{__view-image_}</title>
<link rel="SHORTCUT ICON" href="favicon.ico" />

 <script type="text/javascript">
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
 <img alt="" src="news/{image}" />
</body>
</html>