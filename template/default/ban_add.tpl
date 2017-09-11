<form action="?a=add" method="post">
<table>
<tr>
<td>{ip}</td>
<td colspan="2"><input name="ip" type="text" size="50" maxlength="16" /></td>
</tr>

<tr>
<td>{reason}</td>
<td colspan="2"><input name="reason" type="text" size="50" maxlength="50" /></td>
</tr>

<tr>
<td >{time}</td>
<td colspan="2">{days}: <input name="days" type="text" size="3" maxlength="3" /> {hours}: <input name="hours" type="text" size="2" maxlength="2" /></td>
</tr>

<tr>
<td colspan="2" style="text-align: center;">
<input type="submit" name="submit" value="{ban}" /></td>
</tr>
</table>
</form>