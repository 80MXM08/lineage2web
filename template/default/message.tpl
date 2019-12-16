<script type="text/javascript">
        <!-- Begin
        var checkflag = "false";
        var marked_row = new Array;
        function check(field) {
                if (checkflag == "false") {
                        for (i = 0; i < field.length; i++) {
                                field[i].checked = true;}
                                checkflag = "true";
                        }
                else {
                        for (i = 0; i < field.length; i++) {
                                field[i].checked = false; }
                                checkflag = "false";
                        }
                }
                //  End -->
        </script>
        
        <h1>{mailbox_name}</h1>
        <div align="right"><form action="" method="get">
        <input type="hidden" name="a" value="viewmailbox" />{__go-to_}: <select name="box">
        <option value="1"{inbox_selected}>{__inbox_}</option>
        <option value="2"{outbox_selected}>{__outbox_}</option>
        </select> <input type="submit" value="{__go_}" /></form>
        </div>
        <table border="1" cellpadding="4" cellspacing="0" width="100%">
        <form action="" method="post" name="form1">
        <input type="hidden" name="a" value="moveordel" />
        <tr>
        <td width="2%" class="colhead"></td>
        <td width="51%" class="colhead">{__subject_}</td>
        <td width="35%" class="colhead">{name}</td>
        
        <td width="10%" class="colhead">{__date_}</td>
        <td width="2%" class="colhead"><input type="checkbox" title="{__mark-all_}" value="{__mark-all_}" onclick="this.value=check(document.form1.elements);" /></td>
                
        </tr>
{no_messages}{message_rows}
        
        <tr class="colhead">
        <td colspan="6" align="right" class="colhead">
        <input type="hidden" name="box" value="{mailbox_name}" />
        <input type="submit" name="delete" title="{__delete-marked-messages_}" value="{__delete_}" onclick="return confirm('{__sure-mark-delete_}')" />
        <input type="submit" name="markread" title="{__mark-as-read_}" value="{__mark-read_}" onclick="return confirm('{__sure-mark-read_}')" />
        </td>
        </tr>
        </form>
        </table>
        <div align="left"><img src="img/pn_inboxnew.gif" alt="{__mail-unread-desc_}" /> {__mail-unread-desc_}<br />
        <img src="img/pn_inbox.gif" alt="{__mail-read-desc_}" /> {__mail-read-desc_}</div>
        