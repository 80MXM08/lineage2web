
/* global TimeFormat */

var active = true;
var step = -1;
step = Math.ceil(step);
if (step === 0)
    active = false;

var date = new Date();
var time = date.getTime() / 1000;
secs = Math.floor(secs - time);
function calctime(secs, num1, num2) {
    s = ((Math.floor(secs / num1)) % num2).toString();
    if (s.length < 2)
        s = "0" + s;
    return "<b>" + s + "</b>";
}
function Clock(secs) {
    if (secs < 0) {
        if (document.getElementById("vote") !== null)
        {
            document.getElementById("vote").innerHTML = endmsg;
        }
        return;
    }
    ShowTime = TimeFormat.replace(/%%D%%/g, calctime(secs, 86400, 100000));
    ShowTime = ShowTime.replace(/%%H%%/g, calctime(secs, 3600, 24));
    ShowTime = ShowTime.replace(/%%M%%/g, calctime(secs, 60, 60));
    ShowTime = ShowTime.replace(/%%S%%/g, calctime(secs, 1, 60));

    document.getElementById("vote").innerHTML = ShowTime;
    if (active)
        setTimeout("Clock(" + (secs + step) + ")", (Math.abs(step) - 1) * 1000 + 990);
}
function Countdown(options) {
    var timer;
    var instance = this;
    var seconds = options.seconds || 10;
    var updateStatus = options.onUpdateStatus;
    var counterEnd = options.onCounterEnd;

    function decrementCounter() {
        updateStatus(seconds);
        if (seconds === 0) {
            counterEnd();
            instance.stop();
        }
        seconds--;
    }

    this.start = function () {
        clearInterval(timer);
        timer = 0;
        seconds = options.seconds;
        timer = setInterval(decrementCounter, 1000);
    };

    this.stop = function () {
        clearInterval(timer);
    };
}
function getEle(name)
{
    return document.getElementById(name);
}
function getElem(name)
{
    return document.getElementsByClassName(name);
}
function ViewPic(img)
{
    window.open("actions.php?a=viewimg&img=" + img, "", "resizable=0,HEIGHT=200,WIDTH=200");
}
function GoTo(url)
{
    window.location.href = url;
}

function raiseVitality(server, charac, id)
{

    if (confirm('{lang_confirm_vit}'))
    {
        alert('NOT DONE WITH JQUERY');
        /*var index = ajax.length;
         ajax[index] = new sack();
         
         ajax[index].requestFile = 'raisevitality.php?server='+server+'&char='+charac+'&id='+id; 
         ajax[index].onCompletion = function(){ evaluateresponse(index) };
         ajax[index].runAJAX();*/
    }
}
function evaluateresponse(index)
{
    eval(ajax[index].response);
}
function map(server, charac)
{
    alert('NOT DONE WITH JQUERY');
    /*
     var index = ajax.length;
     ajax[index] = new sack();
     
     ajax[index].requestFile = 'map.php?server='+server+'&char='+charac; 
     ajax[index].onCompletion = function(){ checkMap(index) };
     ajax[index].runAJAX();*/
}

function checkMap(index)
{
    var obj = document.getElementById('onlinemap');
    eval(ajax[index].response);
}
function getCharList(sel)
{
    var server = sel.options[sel.selectedIndex].value;
    document.getElementById('char').options.length = 0;
    if (server.length > 0)
    {
        alert('NOT DONE WITH JQUERY');
        /*
         var index = ajax.length;
         ajax[index] = new sack();
         
         ajax[index].requestFile = 'getchar.php?server='+server; 
         ajax[index].onCompletion = function(){ createChars(index) };
         ajax[index].runAJAX();*/
    }
}
function createChars(index)
{
    var obj = document.getElementById('char');
    eval(ajax[index].response);
}
function toogleDebugBar()
{
    var ele = getEle('debug-bar');
    var ele2 = getEle('show_debug_bar');
    var var_value;
    if (ele.style.display === 'block')
    {
        ele.style.display = 'none';
        ele2.style.display = 'block';
        var_value = 0;
    } else
    {
        ele.style.display = 'block';
        ele2.style.display = 'none';
        var_value = 1;
    }
    $.ajax({
        url: "actions.php",
        type: "GET",
        data: {a: 'vars', 'var': 'debug_menu', val: var_value},
        dataType: "html"
    });
}
function toogle_Debug()
{
    var cont = getEle('debug-bar-content');
    var img = getEle('img_debug_toogle');
    if (cont.style.display === 'none')
    {
        cont.style.display = 'block';
        img.src = 'img/down.png';
    } else
    {
        cont.style.display = 'none';
        img.src = 'img/up.png';
    }
}
function showTip(curEle, targetEle, color)
{
    document.getElementById(targetEle).style.color = color;
    document.getElementById(targetEle).style.display = 'block';
    document.getElementById(targetEle).innerHTML = curEle.title;
}
function hideTip(targetEle)
{
    document.getElementById(targetEle).style.display = 'none';
}
function load_popup(url) {
    document.getElementById("popup").innerHTML = '<object type="text/html" data="' + url + '" ></object>';
    document.getElementById("popup").style.display = 'block';
}
$(function () {
    if ($("#ss").length)
    {
        var tmp;
        if (1 === ssStatus) {
            tmp = nthDay;
        } else if (0 === ssStatus) {
            tmp = 0;
        } else if (3 === ssStatus || 2 === ssStatus) {
            tmp = nthDay + 7;
        }
        $("#ssTimeImg").css("background", "url(img/ss/time/time" + tmp + ".jpg)");
        var date = new Date();
        $("#ssTime2").html(date.toUTCString());
        var dawnPointWidth = maxPointWidth * dawnPoint / 1000;
        $("#ssDawnImg").css("width", dawnPointWidth);
        $("#ssDawn").html($("#ssDawn").html() + dawnPoint);
        var twilPointWidth = maxPointWidth * twilPoint / 1000;
        $("#ssTwilightImg").css("width", twilPointWidth);
        $("#ssTwilight").html($("#ssTwilight").html() + twilPoint);
        var avarice = gnosis = strife = '';
        if (3 === ssStatus)
        {
            if (0 === seal1)
                avarice = 'close';
            else
                avarice = 'open';
            if (0 === seal2)
                gnosis = 'close';
            else
                gnosis = 'open';
            if (0 === seal3)
                strife = 'close';
            else
                strife = 'open';
        }
        $("#ssAvarice").css("background", "url(img/ss/seals/bongin1" + avarice + ".gif)");
        $("#ssGnosis").css("background", "url(img/ss/seals/bongin2" + gnosis + ".gif)");
        $("#ssStrife").css("background", "url(img/ss/seals/bongin3" + strife + ".gif)");
    }
    //$('.item_info').magnificPopup({
    //    type: 'ajax'
    //});
});
$(document).ready(function() {
    $('.item_info').magnificPopup({
       type: 'ajax'
   });
});