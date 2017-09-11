tinymce.init({
    selector: "textarea"
 });
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

var date = new Date();
var time = date.getTime()/1000;
secs = Math.floor(secs - time);
function calctime(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}