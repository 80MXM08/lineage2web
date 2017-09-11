$(function () {
    var width = $(document).width()-482;
    var width2 = width-2;
	if($('#main_top_center')!=null&&$('#main_bot_center')!=null && $('#content')!=null)
	{
        $('#main_top_center').width(width);
        $('#main_bot_center').width(width);
        $('#content').width(width2);
		$( window ).bind("resize", function()
		{
			var width = $(document).width()-482;
			var width2 = width-2;
			if($('#main_top_center')!=null&&$('#main_bot_center')!=null && $('#content')!=null)
			{
                $('#main_top_center').width(width);
                $('#main_bot_center').width(width);
                $('#content').width(width2);
			}
		});
	}
});