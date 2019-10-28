{__last-update_} {time}<br />
{__next-update_} {update_time}<br />
<table align="center">
    <tr>
        <td>
            <img src="img/face/{race}_{sex}.png" alt="" />
            <br />
            <a href="message.php?a=sendmessage&amp;receiver={char_name}&amp;t=c&amp;server={server}">
                <img src="img/new_message.png" title="{__send-pm_}" alt="{__send-pm_}"/>
            </a>
        </td>
        <td>
            <div id='paperdoll' align="left">
                <div id='paperdoll_items' align="left">
                    {eq_items}
                </div>
                <div id="P_tip"></div>
            </div>
        </td>
        <td>
            <table border="1">
                <tr><td>{__name_}:</td><td>{char_name}{main_sub}</td></tr>
                <tr><td>{__level_}:</td><td>{level}</td></tr>
                <tr><td class="maxCp">{__cp_}:</td><td class="maxCp">{maxCp}</td></tr>
                <tr><td class="maxHp">{__hp_}:</td><td class="maxHp">{maxHp}</td></tr>
                <tr><td class="maxMp">{__mp_}:</td><td class="maxMp">{maxMp}</td></tr>
                <tr><td>{__class_}:</td><td>{ClassName}</td></tr>
                <tr><td>{__clan_}:</td><td>{clan_link}</td></tr>
                <tr><td>{__ally_}:</td><td>{ally_link}</td></tr>
                <tr><td>{__pvp_}/<font color="red">{__pk_}</font>:</td>
                    <td><b>{pvpkills}</b>/<b><font color="red">{pkkills}</font></b></td>
                </tr>
                <tr><td>{__online_}:</td>
                    <td><img src="img/status/{onoff}line.png" title="{__online_}" alt="{__online_}" /></td>
                </tr>
            </table>
        </td>
        <td>
            <table border="1">
                <tr><td colspan="3">{__subclasses_}</td></tr>
                <tr><th>Class</th><th>Level</th><th>{__henna_}</th></tr>
                {sub_rows}
            </table>
        </td>
    </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" align="center" >
    <tr>
        <td>{inv_items}</td>
        <td>{ware_items}</td>
        <td>{skills}</td>
    </tr>
</table>
<h1>{__otherchars_}</h1>
{charlist}