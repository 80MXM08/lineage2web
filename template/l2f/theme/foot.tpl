{foot}
<footer>
<p>{copyrights}</p>
<div id="debug-bar" style="display: {debugDisplay2};">
    <div id="debug-bar-bar-container" onclick="toogle_Debug()">
      <div id="debug-bar-bar">
       <span class="debug-bar-group">{timeString}</span>
<span class="fRight"><span class="debug-bar-group"><button class="yt_button" type="button" title="{show_debug}" onclick="return false;"><img id="img_debug_toogle" alt="" src="img/up.png" width="16" height="16" /></button><button class="yt_button" type="button" title="{close_debug}" onclick="toogleDebugBar();">{x}</button></span></span>
</div>
    </div>
<div id="debug-bar-content" style="display: none;">
{debugs}
</div>
</div>     
<div style="display: {debugDisplay}; position: fixed; right: 10px; bottom: 10px;" id="show_debug_bar"><button class="yt_button" type="button" title="Open Debug" onclick="toogleDebugBar();">{enable_debug_bar}</button></div>
</footer>
</body></html>