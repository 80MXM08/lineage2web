<?php
if (!defined('CORE')) {
    exit();
}
class news
{
    static $htmlDone = false;
    static $lAdd, $lEdit, $lDelete, $lRead;

    static function initHtml()
    {
	global $Lang;
	news::$lAdd	 = htmlLink('news.php?a=a', htmlImg('img/add.png', $Lang['__add_']));
	news::$lEdit	 = htmlLink('news.php?a=e&amp;id=%d', htmlImg('img/edit.png', $Lang['__edit_']));
	news::$lDelete	 = htmlLink('news.php?a=d&amp;id=%d', htmlImg('img/delete.png', $Lang['__delete_']));
	news::$lRead	 = htmlLink('news.php?a=v&amp;id=%d', $Lang['__read-more_']);
	news::$htmlDone	 = true;
    }

    static function viewAll()
    {
	global $Lang;
	if (news::$htmlDone == false)
	{
	    news::initHtml();
	}
	$content='';
	$rows	 = DAO::get()::News()::getAll();
        if (!count($rows)) {

            $content .= $Lang['__no-news_'];
            if (User::isMod()) {
                $content .= '<br />' . news::$lAdd;
            }
	    return $content;
        }
	foreach ($rows as $n)
	{
	    $new			 = $n;
	    $new['img_title']	 = $Lang['__img-title_'];
	    $new['content']		 = html_entity_decode($n['desc']);
	    $new['dots']		 = '...';
	    
	    $new['edited']= $new['add']=$new['edit']=$new['delete']='';
	    if ($n['editBy'] != '')
	    {
		$new['edited'] = sprintf($Lang['__last-edit-by_'], $n['editTime'], $n['editBy']);
	    }

	    if (User::isMod())
	    {
		$new['add']	 = news::$lAdd;
		$new['edit']	 = sprintf(news::$lEdit, $n['id']);
		$new['delete']	 = sprintf(news::$lDelete, $n['id']);
	    }

	    $md5 = explode(".", $n['image']);
	    if (!file_exists('news/' . $md5[0] . '.' . $md5[1]))
	    {
		$new['image']	 = 'image.png';
		$new['thumb']	 = 'image_thumb.png';
	    }
	    else
	    {
		$new['image']	 = $md5[0] . '.' . $md5[1];
		$new['thumb']	 = $md5[0] . '_thumb.' . $md5[1];
	    }
	    $new['read_more'] = sprintf(news::$lRead, $n['id']);
	    $content .= tpl::parse('news_row', $new);
	}

	return $content;
    }

    static function viewById($id)
    {
	if (news::$htmlDone == false)
	{
	    news::initHtml();
	}
	global $Lang;
	$r = DAO::get()::News()::get($id);

	if (!count($r))
	{
	    echo msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
	    return;
	}

	$md5	 = explode(".", $r['image']);
	$nid	 = $md5[0];
	if (!file_exists('news/' . $nid . '.html'))
	{
	    msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
	    if (User::isMod())
	    {
		echo $Lang['__are-u-sure-news_'];
		echo '<br/><a href="news.php?a=d&amp;c=1&amp;id=' . $id . '">';
		echo menubutton('delete');
		echo '</a>';
	    }
	    return;
	}
	if (!file_exists('news/' . $r['image']))
	{
	    $parse['image'] = 'image.png';
	}

	$r['content']	 = html_entity_decode(file_get_contents('news/' . $nid . '.html'));
	$parse['title']	 = $r['title'];
	$r['read_more']	= $r['dots'] = $r['edited'] = $r['add'] = $r['edit'] = $r['delete']='';

	if ($r['editBy'] != '')
	{
	    $r['edited'] = sprintf($Lang['__last-edit_'], $r['editTime'], $r['editBy']);
	}
	if (User::isMod())
	{
	    $r['add']	 = news::$lAdd;
	    $r['edit']	 = sprintf(news::$lEdit, $r['id']);
	    $r['delete']	 = sprintf(news::$lDelete, $r['id']);
	}
	return tpl::parse('news_row', $r);
    }
}