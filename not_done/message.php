<?php
//пароль
define('WEB', True);
require_once("include/core.php");
loggedInOrReturn('message.php');
define('PM_DELETED',0); // Message was deleted
define('PM_INBOX',1); // Message located in Inbox for reciever
define('PM_SENTBOX',2); // GET value for sent box
includeLang('message');
$a = getVar('a');
if (!$a)
{
    $a = 'viewmailbox';
}
switch($a)
{
    case "viewmailbox":
        $mailbox = getVar('box');
        if (!$mailbox)
        {
                $mailbox = PM_INBOX;
        }
        if ($mailbox == PM_INBOX)
        {
            $mailbox_name = $Lang['inbox'];
        }
        else
        {
            $mailbox_name = $Lang['outbox'];
        }
        head($mailbox_name); ?>
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
        
        <h1><?php echo $mailbox_name;?></h1>
        <div align="right"><form action="message.php" method="get">
        <input type="hidden" name="a" value="viewmailbox" /><?php echo $Lang['go_to'];?>: <select name="box">
        <option value="1"<?php echo ($mailbox == PM_INBOX ? " selected=\"\"" : "");?>><?php echo $Lang['inbox'];?></option>
        <option value="2"<?php echo ($mailbox == PM_SENTBOX ? " selected=\"\"" : "");?>><?php echo $Lang['outbox'];?></option>
        </select> <input type="submit" value="<?php echo $Lang['go'];?>" /></form>
        </div>
        <table border="0" cellpadding="4" cellspacing="0" width="100%">
        <form action="message.php" method="post" name="form1">
        <input type="hidden" name="a" value="moveordel" />
        <tr>
        <td width="2%" class="colhead"></td>
        <td width="51%" class="colhead"><?php echo $Lang['subject'];?></td>
        <?php
        if ($mailbox == PM_INBOX )
                echo '<td width="35%" class="colhead">'.$Lang['sender'].'</td>';
        else
                echo '<td width="35%" class="colhead">'.$Lang['receiver'].'</td>';
        ?>
        <td width="10%" class="colhead"><?php echo $Lang['date'];?></td>
        <td width="2%" class="colhead"><input type="checkbox" title="<?php echo $Lang['mark_all'];?>" value="<?php echo $Lang['mark_all'];?>" onclick="this.value=check(document.form1.elements);" /></td>
        </tr>
        <?php
        if ($mailbox != PM_SENTBOX) {
                $res=$sql[0]->query(30, array('account' => $user->getUser(),'loc'=>$mailbox));
        } else {
                $res=$sql[0]->query(31, array('account' => $user->getUser()));
        }
        if (!SQL::numRows($res)) {
                echo'<td colspan="6" align="center">'.$Lang['no_messages'].'.</td><br />';
        }
        else
        {
            while ($row = SQL::fetchArray($res))
            {
                        if ($row['sender'] != 0) {
                            $username = "<a href=\"userdetails.php?id=" . $row['sender'] . "\">" . $row["sender"] . "</a>";
                                
                        }
                        else {
                                $username = $Lang['from_system'];
                        }
                        if ($row['receiver']) {
                                $receiver = "<a href=\"userdetails.php?id=" . $row['receiver'] . "\">" . $row["receiver"] . "</a>";
                        }
                        else {
                                $receiver = $Lang['from_system'];
                        }
                        $subject = htmlspecialchars($row['subject']);
                        if (strlen($subject) <= 0) {
                                $subject = $Lang['no_subject'];
                        }
                        if ($row['unread'] == 'yes' && $mailbox != PM_SENTBOX) {
                                echo'<tr><td ><img src="img/pn_inboxnew.gif" alt="'.$Lang['mail_unread'].'" /></td>';
                        }
                        else {
                                echo'<tr><td><img src="img/pn_inbox.gif" alt="'.$Lang['mail_read'].'"></td>';
                        }
                        echo'<td><a href="message.php?a=viewmessage&amp;id=' . $row['id'] . '">' . $subject . '</a></td>';
                        if ($mailbox != PM_SENTBOX) {
                            echo'<td>'.$username.'</td>';
                        }
                        else {
                            echo'<td>'.$receiver.'</td>';
                        }
                        echo'<td nowrap>' . display_date_time(strtotime($row['added']), 2) . '</td>';
                        echo'<td><input type="checkbox" name="messages[]" title="'.$Lang['mark'].'" value="' . $row['id'] . '" id="checkbox_tbl_' . $row['id'] . '"></td></tr>';
                }
        }
        ?>
        <tr class="colhead">
        <td colspan="6" align="right" class="colhead">
        <input type="hidden" name="box" value="<?php echo $mailbox;?>" />
        <input type="submit" name="delete" title="<?php echo $Lang['delete_marked_messages'];?>" value="<?php echo $Lang['delete'];?>" onclick="return confirm('<?php echo $Lang['sure_mark_delete'];?>')" />
        <input type="submit" name="markread" title="<?php echo $Lang['mark_as_read'];?>" value="<?php echo $Lang['mark_read'];?>" onclick="return confirm('<?php echo $Lang['sure_mark_read'];?>')" />
        </td>
        </tr>
        </form>
        </table>
        <div align="left"><img src="img/pn_inboxnew.gif" alt="<?php echo $Lang['mail_unread_desc'];?>" /> <?php echo $Lang['mail_unread_desc'];?><br />
        <img src="img/pn_inbox.gif" alt="<?php echo $Lang['mail_read_desc'];?>" /> <?php echo $Lang['mail_read_desc'];?></div>
        <?php
        foot();
        break;
    case "viewmessage":
            $pm_id = getVar('id');
        if (!$pm_id)
        {
                msg('Error','Missing ID','error');
        }
        
        
        $res=$sql->query(32, array('webdb'=>$webdb, 'account' => $_SESSION['account'],'pm_id'=>$pm_id));
        if (!$sql->num_rows())
        {
                msg($Lang['error'],'Message Not Found!','error');
        }
        $message = $sql->fetch_array();
        if ($message['sender'] != $_SESSION['account'])
        {
                $sender = "<a href=\"userdetails.php?id=" . $message['receiver'] . "\">" . $message['receiver'] . "</a>";
                $reply = "";
                $from = "To";
        }
        else
        {
                $from = "From";
                if ($message['sender'] == 0)
                {
                        $sender = "System";
                        $reply = "";
                }
                else
                {
                        $sender = "<a href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</a>";
                        $reply = " [ <a href=\"message.php?a=sendmessage&amp;receiver=" . $message['sender'] . "&amp;replyto=" . $pm_id . "\">Reply</a> ]";
                }
        }
        $body = format_body($message['msg']);
        $added = display_date_time(strtotime($message['added']), 2);
        if ($message['sender'] == $_SESSION['account'])
        {
                $unread = ($message['unread'] == 'yes' ? "<span style=\"color: #FF0000;\"><b>(Unread)</b></a>" : "");
        }
        else
        {
                $unread = "";
        }
        $subject = htmlspecialchars($message['subject']);
        if (strlen($subject) <= 0)
        {
                $subject = "No subject";
        }
        $sql->query(33, array('webdb'=>$webdb, 'account' => $_SESSION['account'],'pm_id'=>$pm_id));
        head("Private Message (Subject: $subject)"); ?>
        <table width="580" border="0" cellpadding="4" cellspacing="0">
        <tr><td class="colhead" colspan="2">Subject: <?php echo $subject; ?></td></tr>
        <tr>
        <td width="50%" class="colhead"><?php echo $from; ?></td>
        <td width="50%" class="colhead">Date</td>
        </tr>
        <tr>
        <td class="colhead"><?php echo $sender; ?></td>
        <td class="colhead"><?php echo $added; ?>&nbsp;&nbsp;<?php echo $unread; ?></td>
        </tr>
        <tr>
        <td colspan="2" bgcolor="white" style="color: black;"><?php echo $body; ?></td>
        </tr>
        <tr>
        <td align="right" colspan="2">[ <a href="message.php?a=deletemessage&id=<?php echo $pm_id; ?>">Delete</a> ]<?php echo $reply; ?> [ <a href="message.php?a=forward&id=<?php echo $pm_id; ?>">Forward</a> ]</td>
        </tr>
        </table><?php
        foot();
    break;
    case "forward":
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $pm_id = getVar('id');

                $res = $sql->query(32, array('webdb'=>$webdb, 'account' => $_SESSION['account'],'pm_id'=>$pm_id));

                if (!$res) {
                        err($Lang['error'], "Invalid ID");
                }
                if (!$sql->row_count) {
                        err($Lang['error'], "Invalid ID");
                }
                $message = $sql->fetch_array();

                $subject = "Fwd: " . htmlspecialchars($message['subject']);
                $from = $message['sender'];
                $orig = $message['receiver'];

                $orig_name = "<a href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</a>";
                if ($from == 0) {
                        $from_name = "System";
                        $from2['username'] = "System";
                }
                else {
                        $from_name = "<a href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</a>";
                }

                $body = "-------- Original PM From " . $message['sender'] . ": --------<br />" . format_body($message['msg']);

                head($subject);?>

                <form action="message.php" method="post">
                <input type="hidden" name="a" value="forward" />
                <input type="hidden" name="id" value="<?php echo $pm_id;?>" />
                <table border="0" cellpadding="4" cellspacing="0">
                <tr><td class="colhead" colspan="2"><?php echo $subject;?></td></tr>
                <tr>
                <td>To:</td>
                <td><input type="text" name="to" value="Input name" size="83" /></td>
                </tr>
                <tr>
                <td>Original<br />sender</td>
                <td><?php echo $orig_name;?></td>
                </tr>
                <tr>
                <td>From:</td>
                <td><?php echo $from_name;?></td>
                </tr>
                <tr>
                <td>Subject:</td>
                <td><input type="text" name="subject" value="<?php echo $subject;?>" size="83" /></td>
                </tr>
                <tr>
                <td>Message:</td>
                <td><textarea name="msg" cols="80" rows="8"></textarea><br /><?php echo $body;?></td>
                </tr>
                <tr>
                <td colspan="2" align="center">Save message <input type="checkbox" name="save" value="1" />&nbsp;<input type="submit" value="Forward" /></td>
                </tr>
                </table>
                </form><?php
                foot();
        }

        else {
                $pm_id = getVar('id');

                $res = $sql->query(32, array('webdb'=>$webdb, 'account' => $_SESSION['account'],'pm_id'=>$pm_id));
                if (!$res) {
                        err($Lang['error'], "You don't have permission to forward this message");
                }

                if (!$sql->num_rows()) {
                        stderr($Lang['error'], "You don't have permission to forward this message");
                }

                $message = $sql->fetch_array();
                $subject = getVar('subject');
                $username = getVar('to');

                $res = $sql->query(101, array('login'=>$username));
                if (!$res) {
                        err($Lang['error'], "User not found");
                }
                if (!$sql->num_rows()) {
                        err($Lang['error'], "User not found");
                }

                $to = $sql->fetch_array();
                $to = $to['login'];

                // Get Orignal sender's username
                if ($message['sender'] == 0) {
                        $from = "System";
                }
                else {
                        $from = $message['sender'];
                }
                $body = getVar('msg');
                $body .= "\n-------- Original Message from " . $from . ": --------\n" . $message['msg'];
                $save = getVar('save');
                if ($save) {
                        $save = 'yes';
                }
                else {
                        $save = 'no';
                }

                $sql->query("INSERT INTO l2web.messages (sender, receiver, added, subject, msg, location, saved) VALUES('{$_SESSION['account']}', '$to', '" . get_date_time() . "', '$subject','$body', '" . PM_INBOX . "', '$save')");
                        suc("Success", "PM Forwarded");
        }
        break;
        case "deletemessage":
                $pm_id = getVar('id');

        $res = $sql->query(34, array('webdb'=>$webdb, 'pm_id'=>$pm_id)) ;
        if (!$res) {
                err($Lang['error'],"Message not found");
        }
        if (!$sql->num_rows()) {
                err($Lang['error'],"Message not found");
        }
        $message = $sql->fetch_array();
        if (strtolower($message['receiver']) == $_SESSION['account'] && $message['saved'] == 'no') {
                $res2 = $sql->query(35, array('webdb'=>$webdb, 'pm_id'=>$pm_id));
                $loc=1;
        }
        elseif (strtolower($message['sender']) == $_SESSION['account'] && $message['location'] == PM_DELETED) {
                $res2 = $sql->query(35, array('webdb'=>$webdb, 'pm_id'=>$pm_id));
                $loc=1;
        }
        elseif (strtolower($message['receiver']) == $_SESSION['account'] && $message['saved'] == 'yes') {
                $res2 = $sql->query(36, array('webdb'=>$webdb, 'pm_id'=>$pm_id));
                $loc=1;
        }
        elseif (strtolower($message['sender']) == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                $res2 = $sql->query(37, array('webdb'=>$webdb, 'pm_id'=>$pm_id));
                $loc=2;
        }
        if (!$res2) {
                err($Lang['error'],"Failed to delete");
        }
        if (!$sql->row_count) {
                err($Lang['error'],"Failed to delete");
        }
        else {
                header("Location: message.php?a=viewmailbox&box=$loc");
                exit();
        }
        break;
        case "mass_pm":
                if (!$user->mod())
                err($Lang['error'], $Lang['access_denied']);
        head("Send PM");
        ?>
        <table class="main" border="0" cellspacing="0" cellpadding="0">
        <tr><td class="embedded"><div align="center">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" name="message">
        <input type="hidden" name="a" value="takemass_pm" />
        <?php if ($_SERVER["HTTP_REFERER"]) { ?>
        <input type="hidden" name="returnto" value="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]);?>" />
        <?php } ?>
        <table border="1" cellspacing="0" cellpadding="5">
        <tr><td class="colhead" colspan="2">Mass PM</td></tr>
        <tr>
        <td colspan="2"><b>Subject:</b>
        <input name="subject" type="text" size="60" maxlength="255" /></td>
        </tr>
        <tr><td colspan="2"><div align="center">
        <?php echo textbbcode("message","msg","$body");?>
        </div></td></tr>
        
        <tr><td><div align="center"><b>From:</b>
        <?php echo $_SESSION['account']?>
        <input name="sender" type="radio" value="self" checked="checked" />
        System
        <input name="sender" type="radio" value="system" />
        </div></td></tr>
        <tr><td colspan="2" align="center"><input type="submit" value="Send!" class="btn" />
        </td></tr></table>
        </form><br /><br />
        </div>
        </td>
        </tr>
        </table>
        <?php
        foot();
        break;
        case "takemass_pm":
        if (!$user->mod())
                err($Lang['error'], $Lang['access_denied']);
        $msg = getVar('msg');
        if (!$msg)
                err($Lang['error'],"Empty message");
        $sender_id = (getVar('sender') == 'system' ? 0 : $_SESSION['account']);
        
        $subject = getVar('subject');
        $query = "INSERT INTO l2web.messages (sender, receiver, added, subject, msg, location) SELECT '$sender_id',`accounts`.`login`, NOW(), '$subject','$msg','1' FROM `l2jdb`.`accounts`";

        $sql->query($query);
        $n = $sql->row_count;


        header ("Refresh: 3; url=message.php");
        
        suc($Lang['success'], (($n > 1) ? "$n messages was" : "Message was")." successfully sent!");
        break;
}

if ($a == "sendmessage") {

        $receiver = getVar('receiver');
        $replyto = getVar('replyto');
        $t = getVar('t');
        $srv=getDBInfo(getVar('server'));
        if($t=='c')
        {
            $rec=$sql->result($sql->query("SELECT `account_name` FROM `{$srv['DataBase']}`.`characters` WHERE `char_name`='$receiver'"));
            if($rec)
                $receiver=$rec;
        }
        if ($replyto) {
                $res = $sql->query(34, array('webdb'=>$webdb, 'pm_id'=>$replyto));
                $msga = $sql->fetch_array();
                if ($msga["receiver"] != $_SESSION['account'])
                        err($Lang['error'], "You cannot reply to yourself!");

                $body .= "\n\n\n-------- {$msga['sender']} wrote: --------\n".htmlspecialchars($msga['msg'])."\n";
                // Change
                $subject = "Re: " . htmlspecialchars($msga['subject']);
                // End of Change
        }

        head("Send Private Message");
        ?>
        <table class="main" border="0" cellspacing="0" cellpadding="0"><tr><td class="embedded">
        <form name="message" method="post" action="message.php">
        <input type="hidden" name="a" value="takemessage" />
        <table class="message" cellspacing="0" cellpadding="5">
        <tr><td colspan="2" class="colhead">To <?php echo $receiver?'<a class="altlink_white" href="userdetails.php?id='.$receiver.'">'.$receiver.'</a>':'<input type="text" name="user" value="Input Name" />';?></td></tr>
        <tr>
        <td colspan="2"><b>Subject:&nbsp;&nbsp;</b>
        <input name="subject" type="text" size="60" value="<?php echo $subject; ?>" maxlength="255" /></td>
        </tr>
        <tr><td<?php echo $replyto?" colspan=\"2\"":"";?>>
        <?php
        textbbcode("message","msg","$body");
        ?>
        </td></tr>
        <tr>
        <?php if ($replyto) { ?>
        <td align="center"><input type="checkbox" name="delete" value="yes" />Delete PM after reply
        <input type="hidden" name="origmsg" value="<?php echo $replyto; ?>" /></td>
        <?php } ?>
        <td align="center"><input type="checkbox" name="save" value="yes" />Save PM in outbox</td></tr>
        <tr><td<?php echo $replyto?" colspan=2":"";?> align="center"><?php echo button('Send');?></td></tr>
        </table>
        <input type="hidden" name="receiver" value="<?php echo $receiver; ?>" />
        </form>
        </div></td></tr></table>
        <?php
        foot();
}

if ($a == 'takemessage') {

        $receiver = getVar('receiver');
        if(!$receiver) $receiver=getVar('user');
        $origmsg = getVar('origmsg');
        $save = getVar('save');
        $returnto = getVar('returnto');
        $msg = getVar('msg');
        if (!$msg)
                err($Lang['error'],"Body cannot be empty!");
        $subject = getVar('subject');
        if (!$subject)
                err($Lang['error'],"Subject cannot be empty!");
        $save = ($save == 'yes') ? "yes" : "no";
        $sql->query("INSERT INTO l2web.messages (sender, receiver, added, msg, subject, saved, location) VALUES('" . $_SESSION['account'] . "',
        '$receiver', '" . get_date_time() . "', '" . $msg . "', '" . $subject . "', '" . $save . "', 1)");

        $delete = getVar('delete');
        if ($origmsg)
        {
                if ($delete == "yes")
                {
                        $res = $sql->query(34, array('webdb'=>$webdb, 'pm_id'=>$origmsg));
                        if ($sql->num_rows())
                        {
                                $arr = $sql->fetch_array();
                                if ($arr["receiver"] != $_SESSION['account'])
                                        err($Lang['error'],"Incorrect message!");
                                if ($arr["saved"] == "no")
                                        $sql->query(35, array('webdb'=>$webdb, 'pm_id'=>$origmsg));
                                elseif ($arr["saved"] == "yes")
                                        $sql->query(38, array('webdb'=>$webdb, 'pm_id'=>$origmsg));
                        }
                }
                if (!$returnto)
                        $returnto = "message.php";
        }
        if ($returnto) {
                header("Location: $returnto");
                die;
        }
        else {
                header ("Refresh: 2; url=message.php");
                head('Message sent!');
                msg($Lang['success'] , "Message successfully sent!");
                foot();
                exit();
        }


}


if ($a == "moveordel") {
        $pm_id = getVar('id');
        $pm_box = getVar('box');
        $pm_messages = getvar('messages');
        if (getVar('move')) {
                if ($pm_id) {
                        // Move a single message
                        $sql->query("UPDATE l2web.messages SET location=" . $pm_box . ", saved = 'yes' WHERE id=" . $pm_id . " AND receiver=" . $_SESSION['account'] . " LIMIT 1");
                }
                else {
                        // Move multiple messages
                        $sql->query("UPDATE l2web.messages SET location=" . $pm_box . ", saved = 'yes' WHERE id IN (" . implode(", ",$pm_messages) . ') AND receiver=' . $_SESSION['account']);
                }
                // Check if messages were moved
                if (!$sql->row_count) {
                        err($Lang['error'], "Unable to move messages!");
                }
                header("Location: message.php?a=viewmailbox&box=" . $pm_box);
                exit();
        }
        elseif (getVar('delete')) {
                if ($pm_id) {
                        // Delete a single message
                        $res = $sql->query("SELECT * FROM messages WHERE id=" . $pm_id);
                        $message = $sql->fetch_array();
                        if ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'no') {
                                $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
                        }
                        elseif ($message['sender'] ==$_SESSION['account'] && $message['location'] == PM_DELETED) {
                                $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
                        }
                        elseif ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'yes') {
                                $sql->query("UPDATE l2web.messages SET location=0 WHERE id=" . $pm_id);
                        }
                        elseif ($message['sender'] == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                                $sql->query("UPDATE l2web.messages SET saved='no' WHERE id=" . $pm_id);
                        }
                } else {
                        // Delete multiple messages
                        if (is_array($pm_messages))
                        foreach ($pm_messages as $id) {
                            $id=val_int($id);
                                $res = $sql->query(34, array('webdb'=>$webdb, 'pm_id'=>$id));
                                $message = $sql->fetch_array($res);
                                if ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'no') {
                                        $sql->query(35, array('webdb'=>$webdb, 'pm_id'=>$id));
                                }
                                elseif ($message['sender'] == $_SESSION['account'] && $message['location'] == PM_DELETED) {
                                        $sql->query(35, array('webdb'=>$webdb, 'pm_id'=>$id));
                                }
                                elseif ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'yes') {
                                        $sql->query(36, array('webdb'=>$webdb, 'pm_id'=>$id));
                                }
                                elseif ($message['sender'] == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                                        $sql->query(37, array('webdb'=>$webdb, 'pm_id'=>$id));
                                }
                        }
                }
                // Check if messages were moved
                if (!$sql->row_count) {
                        err($Lang['error'],"Failed to delete messages");
                }
                else {
                        header("Location: message.php?a=viewmailbox&box=" . $pm_box);
                        exit();
                }
        }
        elseif (getVar('markread')) {
                if ($pm_id) {
                        $sql->query("UPDATE l2web.messages SET unread='no' WHERE id = " . $pm_id);
                }
                else {
                		if (is_array($pm_messages))
                        foreach ($pm_messages as $id) {
                            $id=val_int($id);
                                $res = $sql->query(34, array('webdb'=>$webdb, 'pm_id'=>$id));
                                $message = $sql->fetch_array($res);
                                $sql->query("UPDATE l2web.messages SET unread='no' WHERE id = " . $id) ;
                        }
                }
                if (!$sql->row_count) {
                        err($Lang['error'], "Nothing to mark! ");
                }
                else {
                        header("Location: message.php?a=viewmailbox&box=" . $pm_box);
                        exit();
                }
        }

err($Lang['error'],"No action");
}

?>