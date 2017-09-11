<div align="center">
    <form name="webpoint" action="webpoints.php" method="post">
        <table border="1">
        <thead>
        <tr><th>{server}</th><th>{char}</th><th>{exchange_for}</th><th>{count}</th></tr></thead>
    <tbody>
    <tr>
	<td><select id="server" name="server" onchange="getCharList(this)"><option value="" selected="selected" disabled="">{select_server}</option>
	{server_list}
	</select></td>
	<td><select id="char" name="char">
    <option>{select_server}</option>
    </select></td><td><select name="item"><option value="1" selected="">Gold Einhasad x4</option><option value="2">Festival Adena x1</option></select></td>
    <td>x<input name="multiplier" id="multiplier" type="text" value="1" size="3" maxlength="3" /></td>
    </tr>
    </tbody>
    </table>
    <table border="0"><tr><td>{b_exchange}</td></tr></table>
    </form>
 </div>