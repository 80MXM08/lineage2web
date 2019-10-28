<script>
var TimeFormat = "%%D%% {__days_}, %%H%% {__hours_}, %%M%% {__minutes_}, %%S%% {__seconds_}.";
var date = new Date();
var banCounter = new Countdown({  
    seconds:{secs}-date.getTime()/1000,  // number of seconds to count down
    onUpdateStatus: function(secs){
        ShowTime = TimeFormat.replace(/%%D%%/g, calctime(secs,86400,100000));
        ShowTime = ShowTime.replace(/%%H%%/g, calctime(secs,3600,24));
        ShowTime = ShowTime.replace(/%%M%%/g, calctime(secs,60,60));
        ShowTime = ShowTime.replace(/%%S%%/g, calctime(secs,1,60));

  document.getElementById("ban_counter").innerHTML = ShowTime;
        
    }, // callback for each second
    onCounterEnd: function(){ document.getElementById("ban_counter").innerHTML='{__ban-over_}'} // final action
});

banCounter.start();
</script>
<div id="divContainer">
<table id="banned">
<tr><td colspan="2"><div><h1>{__access-denied_}</h1></div></td></tr>
<tr><td>{__your-ip_}:</td><td>{ip}</td></tr>
<tr><td>{__reason_}:</td><td>{comment}</td></tr>
<tr><td>{__baned-from_}: </td><td>{date_from}</td></tr>
<tr><td>{__baned-till_}:</td><td>{date_to}</td></tr>
<tr><td colspan="2">{__time-left_}t</td></tr>
<tr><td colspan="2"><h1><span id="ban_counter">&nbsp;</span></h1></td></tr>
</table>
</div>