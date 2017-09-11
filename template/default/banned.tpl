<script type="text/javascript">
var TimeFormat = "%%D%% {days}, %%H%% {hours}, %%M%% {minutes}, %%S%% {seconds}.";
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
    onCounterEnd: function(){ document.getElementById("ban_counter").innerHTML='{ban_over}'} // final action
});

banCounter.start();
</script>
<div id="divContainer">
<table id="banned">
<tr><td colspan="2"><div><h1>{access_denied}</h1></div></td></tr>
<tr><td>{your_ip}:</td><td>{ip}</td></tr>
<tr><td>{reason}:</td><td>{reas}</td></tr>
<tr><td>{baned_from}: </td><td>{date_from}</td></tr>
<tr><td>{baned_till}:</td><td>{date_to}</td></tr>
<tr><td colspan="2">{time_left}t</td></tr>
<tr><td colspan="2"><h1><span id="ban_counter"></span></h1></td></tr>
</table>
</div>