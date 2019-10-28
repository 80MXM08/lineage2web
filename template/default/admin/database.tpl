<form method="post" action="">
    <table border="0" cellspacing="0" cellpadding="3" align="center">
        <tr><td><select name="datatable[]" size="10" multiple="multiple" style="width:400px">{content}</select></td>
            <td>
                <table border="0" cellspacing="0" cellpadding="3">
                    <!--tr><td valign="top"><input type="radio" name="type" value="a"></td><td>{lAnalyse}<br /><font size="1">{lAnalyseD}</font></td></tr-->
                    <tr><td valign="top"><input type="radio" name="type" value="o"></td><td>{lOptimize}<br /><font size="1">{lOptimizeD}</font></td></tr>
                    <tr><td valign="top"><input type="radio" name="type" value="r"></td><td>{lRepair}<br /><font size="1">{lRepairD}</font></td></tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="2" align="center"><input type="submit" value="{lSubmit}"></td></tr>
    </table>
</form>