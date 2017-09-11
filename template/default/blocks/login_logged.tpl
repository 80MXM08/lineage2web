<ul class="menu">
    {admin_link}
    {ban_link}
    {news_link}
    <li style="color: red;">{vote_after_msg}<span id="vote"></span><script type="text/javascript">Clock(secs.valueOf());</script></li>
    <li><a href="myacc.php">{my_account}</a></li>
    <li>{wp_link}</li>
    <li><a href="message.php?a=viewmailbox&amp;box=1"><img src="img/pn_inbox{new}.gif" alt="{inbox}" title="{in_mes}" /></a>/<a href="message.php?a=viewmailbox&amp;box=2"><img src="img/pn_sentbox.gif" alt="{outbox}" title="{out_mes}" /></a></li>
    <li><a href="logout.php">{logout}</a></li>
</ul>