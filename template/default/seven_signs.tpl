<h1>{home}</h1><hr />
<table class="stat">
{race_rows}
<tr><th>{male}<img src="img/stat/sex.jpg" alt="{male}" /></th><td><img src="img/stat/sexline.jpg" height="10px" width="{mc}px" alt="" /> {mc}%</td></tr>
<tr><th>{female}<img src="img/stat/sex1.jpg" alt="{female}" /></th><td><img src="img/stat/sexline.jpg" height="10px" width="{fc}px" alt="" /> {fc}%</td></tr>
</table><hr />

<h1>{seven_signs}</h1>

<script type="text/javascript">
//<!--
var nthDay = {current_cycle};
var ssStatus = {active_period};
var dawnPoint = {dawnScore};
var twilPoint = {twilScore};
var maxPointWidth = 300;
var seal1 = {aowner};
var seal2 = {gowner};
var seal3 = {sowner};
// -->
</script>
<div id="ss">
<div id="ssStatus">{status}</div>
<div id="ssTimeImg"></div>
<div id="ssTime"><div id="ssTime2"></div></div>
<div id="ssDawn">{dawn} <img id="ssDawnImg" src="img/ss/ssqbar2.gif" alt="{dawn}" /> </div>
<div id="ssTwilight">{dusk} <img id="ssTwilightImg" src="img/ss/ssqbar1.gif" alt="{dusk}" /> </div>
<div id="ssSeals">
<div id="ssAvarice"></div>
<div id="ssGnosis"></div>
<div id="ssStrife"></div>
</div>
</div>