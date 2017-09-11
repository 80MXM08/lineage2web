<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Buy WebPoints by SMS");
?>
<div>
<script type="text/javascript">
  
    var countries = new Array(1, 2, 3, 4, 5, 6, 7, 12, 29, 10, 38, 41, 18, 14, 39, 27, 40, 15, 33, 28, 21, 37, 16, 34, 9, 26, 42, 43, 30, 44, 45, 46, 31, 32, 47, 8, 48, 17, 50, 51, 52, 53, 54, 55, 56, 221, 162);
  
  function show_only_one_country(country) {
    for (var i = 0; i &lt; countries.length; i++) {
      Element.hide('service_preview_' + countries[i]);
    }
    Element.show('service_preview_' + country);
  }
</script>

<p>
  <img title="Somija" style="cursor: pointer;" src="http://cdn0.fortumo.com/6c975a67a/images/flags/fi.png" onclick="show_only_one_country(1);" alt="FI">  <img title="Zviedrija" style="cursor: pointer;" src="http://cdn1.fortumo.com/5dd560952/images/flags/se.png" onclick="show_only_one_country(2);" alt="SE">  <img title="Norvēģija" style="cursor: pointer;" src="http://cdn0.fortumo.com/36c6d2a0c/images/flags/no.png" onclick="show_only_one_country(3);" alt="NO">  <img title="Dānija" style="cursor: pointer;" src="http://cdn3.fortumo.com/e363b670b/images/flags/dk.png" onclick="show_only_one_country(4);" alt="DK">  <img title="Igaunija" style="cursor: pointer;" src="http://cdn2.fortumo.com/2f1aeaadd/images/flags/ee.png" onclick="show_only_one_country(5);" alt="EE">  <img title="Latvija" style="cursor: pointer;" src="http://cdn0.fortumo.com/4d924e757/images/flags/lv.png" onclick="show_only_one_country(6);" alt="LV">  <img title="Lietuva" style="cursor: pointer;" src="http://cdn1.fortumo.com/2a20ac718/images/flags/lt.png" onclick="show_only_one_country(7);" alt="LT">  <img title="Ķīna" style="cursor: pointer;" src="http://cdn1.fortumo.com/068fefa61/images/flags/cn.png" onclick="show_only_one_country(12);" alt="CN">  <img title="Rumānija" style="cursor: pointer;" src="http://cdn1.fortumo.com/70fbbe535/images/flags/ro.png" onclick="show_only_one_country(29);" alt="RO">  <img title="Bulgārija" style="cursor: pointer;" src="http://cdn2.fortumo.com/d2783366b/images/flags/bg.png" onclick="show_only_one_country(10);" alt="BG">  <img title="Serbija" style="cursor: pointer;" src="http://cdn2.fortumo.com/34a6b8207/images/flags/rs.png" onclick="show_only_one_country(38);" alt="RS">  <img title="Horvātija" style="cursor: pointer;" src="http://cdn1.fortumo.com/ee33c5673/images/flags/hr.png" onclick="show_only_one_country(41);" alt="HR">  <img title="Ungārija" style="cursor: pointer;" src="http://cdn3.fortumo.com/5ca3fd551/images/flags/hu.png" onclick="show_only_one_country(18);" alt="HU">  <img title="Čehija" style="cursor: pointer;" src="http://cdn1.fortumo.com/8834515f8/images/flags/cz.png" onclick="show_only_one_country(14);" alt="CZ">  <img title="Malaysia" style="cursor: pointer;" src="http://cdn2.fortumo.com/c3c66a7ec/images/flags/my.png" onclick="show_only_one_country(39);" alt="MY">  <img title="Polija" style="cursor: pointer;" src="http://cdn2.fortumo.com/b19773c8a/images/flags/pl.png" onclick="show_only_one_country(27);" alt="PL">  <img title="Taiwan" style="cursor: pointer;" src="http://cdn3.fortumo.com/77883fc7a/images/flags/tw.png" onclick="show_only_one_country(40);" alt="TW">  <img title="Francija" style="cursor: pointer;" src="http://cdn0.fortumo.com/e2c147baa/images/flags/fr.png" onclick="show_only_one_country(15);" alt="FR">  <img title="Spānija" style="cursor: pointer;" src="http://cdn0.fortumo.com/a4ac03f46/images/flags/es.png" onclick="show_only_one_country(33);" alt="ES">  <img title="Portugāle" style="cursor: pointer;" src="http://cdn2.fortumo.com/34aeac1fa/images/flags/pt.png" onclick="show_only_one_country(28);" alt="PT">  <img title="Īrija" style="cursor: pointer;" src="http://cdn1.fortumo.com/75da0b9f3/images/flags/ie.png" onclick="show_only_one_country(21);" alt="IE">  <img title="Apvienotā Karaliste" style="cursor: pointer;" src="http://cdn1.fortumo.com/fe18b8b41/images/flags/gb.png" onclick="show_only_one_country(37);" alt="GB">  <img title="Vācija" style="cursor: pointer;" src="http://cdn0.fortumo.com/bcf3f30e4/images/flags/de.png" onclick="show_only_one_country(16);" alt="DE">  <img title="Šveice" style="cursor: pointer;" src="http://cdn0.fortumo.com/17a98c4c9/images/flags/ch.png" onclick="show_only_one_country(34);" alt="CH">  <img title="Beļģija" style="cursor: pointer;" src="http://cdn2.fortumo.com/b03b16323/images/flags/be.png" onclick="show_only_one_country(9);" alt="BE">  <img title="Niderlande" style="cursor: pointer;" src="http://cdn3.fortumo.com/e70a646af/images/flags/nl.png" onclick="show_only_one_country(26);" alt="NL">  <img title="Austrālija" style="cursor: pointer;" src="http://cdn2.fortumo.com/4b1c93df1/images/flags/au.png" onclick="show_only_one_country(42);" alt="AU">  <img title="Honkonga" style="cursor: pointer;" src="http://cdn0.fortumo.com/fbaa236dc/images/flags/hk.png" onclick="show_only_one_country(43);" alt="HK">  <img title="Krievija" style="cursor: pointer;" src="http://cdn2.fortumo.com/210ba0dc9/images/flags/ru.png" onclick="show_only_one_country(30);" alt="RU">  <img title="Indonēzija" style="cursor: pointer;" src="http://cdn1.fortumo.com/6e5afcf22/images/flags/id.png" onclick="show_only_one_country(44);" alt="ID">  <img title="Bosnija un Hercegovina" style="cursor: pointer;" src="http://cdn1.fortumo.com/4167a558a/images/flags/ba.png" onclick="show_only_one_country(45);" alt="BA">  <img title="Baltkrievija" style="cursor: pointer;" src="http://cdn2.fortumo.com/0bc400d92/images/flags/by.png" onclick="show_only_one_country(46);" alt="BY">  <img title="Slovākija" style="cursor: pointer;" src="http://cdn0.fortumo.com/91bc2ab05/images/flags/sk.png" onclick="show_only_one_country(31);" alt="SK">  <img title="Slovēnija" style="cursor: pointer;" src="http://cdn1.fortumo.com/f72cf01ea/images/flags/si.png" onclick="show_only_one_country(32);" alt="SI">  <img title="Ukraina" style="cursor: pointer;" src="http://cdn1.fortumo.com/082ff24be/images/flags/ua.png" onclick="show_only_one_country(47);" alt="UA">  <img title="Austrija" style="cursor: pointer;" src="http://cdn2.fortumo.com/4f2b6c098/images/flags/at.png" onclick="show_only_one_country(8);" alt="AT">  <img title="South Africa" style="cursor: pointer;" src="http://cdn1.fortumo.com/d7f7b3435/images/flags/za.png" onclick="show_only_one_country(48);" alt="ZA">  <img title="Grieķija" style="cursor: pointer;" src="http://cdn3.fortumo.com/ac24d4805/images/flags/gr.png" onclick="show_only_one_country(17);" alt="GR">  <img title="Israel" style="cursor: pointer;" src="http://cdn0.fortumo.com/5025e0e89/images/flags/il.png" onclick="show_only_one_country(50);" alt="IL">  <img title="Vietnam" style="cursor: pointer;" src="http://cdn3.fortumo.com/7b663e9b2/images/flags/vn.png" onclick="show_only_one_country(51);" alt="VN">  <img title="Chile" style="cursor: pointer;" src="http://cdn1.fortumo.com/667851b1f/images/flags/cl.png" onclick="show_only_one_country(52);" alt="CL">  <img title="Colombia" style="cursor: pointer;" src="http://cdn0.fortumo.com/1370b3052/images/flags/co.png" onclick="show_only_one_country(53);" alt="CO">  <img title="Venezuela" style="cursor: pointer;" src="http://cdn1.fortumo.com/a87573922/images/flags/ve.png" onclick="show_only_one_country(54);" alt="VE">  <img title="Mexico" style="cursor: pointer;" src="http://cdn1.fortumo.com/08b6b4532/images/flags/mx.png" onclick="show_only_one_country(55);" alt="MX">  <img title="Turkey" style="cursor: pointer;" src="http://cdn3.fortumo.com/418fda6c2/images/flags/tr.png" onclick="show_only_one_country(56);" alt="TR">  <img title="Thailand" style="cursor: pointer;" src="http://cdn0.fortumo.com/24fbaf771/images/flags/th.png" onclick="show_only_one_country(221);" alt="TH">  <img title="Macedonia" style="cursor: pointer;" src="http://cdn2.fortumo.com/800b57b7a/images/flags/mk.png" onclick="show_only_one_country(162);" alt="MK"></p>
<div id="service_previews">
        
  <div style="width: 100%; display: none;" id="service_preview_1" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/6c975a67a/images/flags/fi.png" alt="FI">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Somijā</b> is <br><b>2,00 EUR</b><b>&nbsp;(ap&nbsp;1,37 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT2 FANTASY</strong> uz pakalpojuma numuru <strong>17163</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_2" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/5dd560952/images/flags/se.png" alt="SE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Zviedrijā</b> is <br><b>15,00 SEK</b><b>&nbsp;(ap&nbsp;1,13 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>72401</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_3" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/36c6d2a0c/images/flags/no.png" alt="NO">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Norvēģijā</b> is <br><b>15,00 NOK</b><b>&nbsp;(ap&nbsp;1,29 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>2201</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_4" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/e363b670b/images/flags/dk.png" alt="DK">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Dānijā</b> is <br><b>15,00 DKK</b><b>&nbsp;(ap&nbsp;1,36 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>1999</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_5" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/2f1aeaadd/images/flags/ee.png" alt="EE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Igaunijā</b> is <br><b>1,60 EUR / 25,03 EEK</b><b>&nbsp;(ap&nbsp;1,10 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>13013</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_6" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/4d924e757/images/flags/lv.png" alt="LV">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Latvijā</b> is <br><b>0,99 LVL</b><b>&nbsp;(ap&nbsp;0,99 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>1897</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_7" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/2a20ac718/images/flags/lt.png" alt="LT">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Lietuvā</b> is <br><b>5,00 LTL</b><b>&nbsp;(ap&nbsp;0,98 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>1337</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_12" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/068fefa61/images/flags/cn.png" alt="CN">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Ķīnā</b> is <br><b>2,00 RMB</b><b>&nbsp;(ap&nbsp;0,15 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>840FOR FANTASY</strong> uz pakalpojuma numuru <strong>10668001</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_29" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/70fbbe535/images/flags/ro.png" alt="RO">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Rumānijā</b> is <br><b>2,00 EUR</b><b>&nbsp;(ap&nbsp;1,37 LVL)</b> + <b>VAT (24%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>1314</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_10" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/d2783366b/images/flags/bg.png" alt="BG">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Bulgārijā</b> is <br><b>2,40 BGN</b><b>&nbsp;(ap&nbsp;0,84 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>1916</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_38" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/34a6b8207/images/flags/rs.png" alt="RS">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Serbijā</b> is <br><b>177,00 RSD</b><b>&nbsp;(ap&nbsp;1,12 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>150 FANTASY</strong> uz pakalpojuma numuru <strong>1310</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_41" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/ee33c5673/images/flags/hr.png" alt="HR">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Horvātijā</b> is <br><b>6,10 HRK</b><b>&nbsp;(ap&nbsp;0,58 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>67454</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_18" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/5ca3fd551/images/flags/hu.png" alt="HU">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Ungārijā</b> is <br><b>500,00 HUF</b><b>&nbsp;(ap&nbsp;1,26 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>06-91-336-000</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_14" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/8834515f8/images/flags/cz.png" alt="CZ">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Čehijā</b> is <br><b>30,00 CZK</b><b>&nbsp;(ap&nbsp;0,81 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>900 11 30</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_39" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/c3c66a7ec/images/flags/my.png" alt="MY">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Malaysia</b> is <br><b>3,00 MYR</b><b>&nbsp;(ap&nbsp;0,50 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>32088</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_27" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/b19773c8a/images/flags/pl.png" alt="PL">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Poland</b> is <br><b>11,07 PLN</b><b>&nbsp;(ap&nbsp;1,92 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>79550</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_40" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/77883fc7a/images/flags/tw.png" alt="TW">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Taivānā </b> is <br><b>30,00 NTD</b><b>&nbsp;(ap&nbsp;0,52 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>55123</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_15" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/e2c147baa/images/flags/fr.png" alt="FR">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Francijā</b> is <br><b>1,50 EUR</b><b>&nbsp;(ap&nbsp;1,03 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TAT FANTASY</strong> uz pakalpojuma numuru <strong>83700</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_33" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/a4ac03f46/images/flags/es.png" alt="ES">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Spānijā</b> is <br><b>1,42 EUR</b><b>&nbsp;(ap&nbsp;0,97 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR FANTASY</strong> uz pakalpojuma numuru <strong>25000</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_28" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/34aeac1fa/images/flags/pt.png" alt="PT">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Portugālē</b> is <br><b>2,00 EUR</b><b>&nbsp;(ap&nbsp;1,37 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TAT FANTASY</strong> uz pakalpojuma numuru <strong>68636</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_21" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/75da0b9f3/images/flags/ie.png" alt="IE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Īrijā</b> is <br><b>2,50 EUR</b><b>&nbsp;(ap&nbsp;1,71 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>PTW FANTASY</strong> uz pakalpojuma numuru <strong>57800</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_37" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/fe18b8b41/images/flags/gb.png" alt="GB">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Lielbritānijā</b> is <br><b>1,50 GBP</b><b>&nbsp;(ap&nbsp;1,18 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR FANTASY</strong> uz pakalpojuma numuru <strong>81404</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_16" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/bcf3f30e4/images/flags/de.png" alt="DE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Vācijā</b> is <br><b>2,99 EUR</b><b>&nbsp;(ap&nbsp;2,05 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR3 FANTASY</strong> uz pakalpojuma numuru <strong>89000</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_34" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/17a98c4c9/images/flags/ch.png" alt="CH">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Šveicē</b> is <br><b>3,00 CHF</b><b>&nbsp;(ap&nbsp;1,64 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>DAG FANTASY</strong> uz pakalpojuma numuru <strong>911</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_9" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/b03b16323/images/flags/be.png" alt="BE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Beļģijā</b> is <br><b>1,50 EUR</b><b>&nbsp;(ap&nbsp;1,03 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TAT FANTASY</strong> uz pakalpojuma numuru <strong>3569</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_26" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/e70a646af/images/flags/nl.png" alt="NL">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Nīderlandē</b> is <br><b>0,80 EUR</b><b>&nbsp;(ap&nbsp;0,55 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TAG FANTASY</strong> uz pakalpojuma numuru <strong>3555</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_42" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/4b1c93df1/images/flags/au.png" alt="AU">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Austrālijā</b> is <br><b>4,00 AUD</b><b>&nbsp;(ap&nbsp;2,12 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>19900204</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_43" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/fbaa236dc/images/flags/hk.png" alt="HK">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Hong Kong</b> is <br><b>15,00 HKD</b><b>&nbsp;(ap&nbsp;0,99 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT15 FANTASY</strong> uz pakalpojuma numuru <strong>503230</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_30" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/210ba0dc9/images/flags/ru.png" alt="RU">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Krievijā</b> is <br><b>70,00 RUB</b><b>&nbsp;(ap&nbsp;1,14 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR FANTASY</strong> uz pakalpojuma numuru <strong>4243</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_44" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/6e5afcf22/images/flags/id.png" alt="ID">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Indonezijā</b> is <br><b>5&nbsp;000,00 IDR</b><b>&nbsp;(ap&nbsp;0,28 LVL)</b> + <b>VAT (10%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>PESAN5 FANTASY</strong> uz pakalpojuma numuru <strong>9779</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_45" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/4167a558a/images/flags/ba.png" alt="BA">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Bosnijā un Gercegovinā</b> is <br><b>1,20 BAM</b><b>&nbsp;(ap&nbsp;0,42 LVL)</b> + <b>VAT (17%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>091610702</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_46" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/0bc400d92/images/flags/by.png" alt="BY">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Baltkrievijā</b> is <br><b>6&nbsp;900,00 BYR</b><b>&nbsp;(ap&nbsp;1,16 LVL)</b> + <b>VAT (18%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>3337</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_31" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/91bc2ab05/images/flags/sk.png" alt="SK">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Slovākijā</b> is <br><b>0,67 EUR</b><b>&nbsp;(ap&nbsp;0,46 LVL)</b> + <b>VAT (20%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>7779</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_32" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/f72cf01ea/images/flags/si.png" alt="SI">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Slovēnijā</b> is <br><b>0,99 EUR</b><b>&nbsp;(ap&nbsp;0,68 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>3838</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_47" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/082ff24be/images/flags/ua.png" alt="UA">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>Ukrainā</b> is <br><b>12,00 UAH</b><b>&nbsp;(ap&nbsp;0,75 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>WLW FANTASY</strong> uz pakalpojuma numuru <strong>4448</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_8" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/4f2b6c098/images/flags/at.png" alt="AT">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Austria</b> is <br><b>3,00 EUR</b><b>&nbsp;(ap&nbsp;2,05 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT3 FANTASY</strong> uz pakalpojuma numuru <strong>0900100330</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_48" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/d7f7b3435/images/flags/za.png" alt="ZA">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in South Africa</b> is <br><b>30,00 ZAR</b><b>&nbsp;(ap&nbsp;2,27 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR FANTASY</strong> uz pakalpojuma numuru <strong>31208</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_17" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/ac24d4805/images/flags/gr.png" alt="GR">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Greece</b> is <br><b>1,48 EUR</b><b>&nbsp;(ap&nbsp;1,01 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>54534</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_50" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/5025e0e89/images/flags/il.png" alt="IL">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Israel</b> is <br><b>10,00 NIS</b><b>&nbsp;(ap&nbsp;1,44 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>T10 FANTASY</strong> uz pakalpojuma numuru <strong>2727</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_51" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/7b663e9b2/images/flags/vn.png" alt="VN">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Vietnam</b> is <br><b>10&nbsp;000,00 VND</b><b>&nbsp;(ap&nbsp;0,25 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT10 FANTASY</strong> uz pakalpojuma numuru <strong>8608</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_52" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/667851b1f/images/flags/cl.png" alt="CL">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Chile</b> is <br><b>900,00 CLP</b><b>&nbsp;(ap&nbsp;0,91 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR287 </strong> uz pakalpojuma numuru <strong>2777</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_53" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/1370b3052/images/flags/co.png" alt="CO">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Colombia</b> is <br><b>4&nbsp;408,00 COP</b><b>&nbsp;(ap&nbsp;1,25 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR285 </strong> uz pakalpojuma numuru <strong>7766</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_54" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/a87573922/images/flags/ve.png" alt="VE">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Venezuela</b> is <br><b>8,00 VEF</b><b>&nbsp;(ap&nbsp;0,46 LVL)</b> + <b>VAT (12%)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR286 </strong> uz pakalpojuma numuru <strong>7557</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_55" class="service_preview">
    <img style="float: left;" src="http://cdn1.fortumo.com/08b6b4532/images/flags/mx.png" alt="MX">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Mexico</b> is <br><b>15,08 MXN</b><b>&nbsp;(ap&nbsp;0,56 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>FOR287 </strong> uz pakalpojuma numuru <strong>22122</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_56" class="service_preview">
    <img style="float: left;" src="http://cdn3.fortumo.com/418fda6c2/images/flags/tr.png" alt="TR">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Turkey</b> is <br><b>10,00 TRY</b><b>&nbsp;(ap&nbsp;3,46 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>6662</strong></p>
  </div>
  <div style="width: 100%; display: none;" id="service_preview_221" class="service_preview">
    <img style="float: left;" src="http://cdn0.fortumo.com/24fbaf771/images/flags/th.png" alt="TH">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Thailand</b> is <br><b>42,80 THB</b><b>&nbsp;(ap&nbsp;0,71 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TXT FANTASY</strong> uz pakalpojuma numuru <strong>4520000</strong></p>
  </div>
  <div style="width: 100%;" id="service_preview_162" class="service_preview">
    <img style="float: left;" src="http://cdn2.fortumo.com/800b57b7a/images/flags/mk.png" alt="MK">
    <div style="float: left; margin-left: 5px;">
      The end-user price of your service <b>in Macedonia</b> is <br><b>59,00 MKD</b><b>&nbsp;(ap&nbsp;0,65 LVL)</b>    </div><br style="clear: both;">
    <p>Lietotājs sūta īsziņu ar <strong>TAP FANTASY</strong> uz pakalpojuma numuru <strong>141551</strong></p>
  </div>
</div>
<script type="text/javascript">$('service_previews').down('div.service_preview').show();</script>
</div>



<?php




foot();
?>