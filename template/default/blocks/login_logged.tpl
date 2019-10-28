<ul class="menu">
    {admin_link}
    {ban_link}
    {news_link}
    <li style="color: red;">{vote_after_msg}<span id="vote"></span><script type="text/javascript">Clock(secs.valueOf());</script></li>
    <li><a href="myacc.php">{__my-account_}</a></li>
    <li>{wp_link}</li>
    <li><a href="message.php?a=viewmailbox&amp;box=1"  aria-label="{in_mes}"><img src="img/pn_inbox{new}.gif" alt="{__inbox_}" /></a>/<a href="message.php?a=viewmailbox&amp;box=2" aria-label="{out_mes}"><img src="img/pn_sentbox.gif" alt="{__outbox_}" /></a></li>
    <li><a href="logout.php">{__logout_}</a></li>
</ul>