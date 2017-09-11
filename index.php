<?php

define('L2WEB', true);
require_once ("include/core.php");

head("Home");

$par['lang'] = User::getVar('lang');
$par['mod'] = User::isMod() == true ? 'true' : 'false';

if (Cache::check('index', implode(';', $par)))
{
    $parse = $Lang;

    $parse['gsrows'] = "";
    foreach ($GS as $gsrow)
    {
            $parse['gsrows'] .= TplParser::parse('index_gsrow', $gsrow, 1);
    }

    $parse['news'] = '';
    if (Config::get('news', 'enabled', '0'))
    {
        
        $lAdd = '<a href="news.php?a=a"><img src="img/add.png" alt="' . $Lang['add'] . '" title="' . $Lang['add'] . '" /></a>';
        $lEdit = '<a href="news.php?a=e&amp;id=%d"><img src="img/edit.png" alt="' . $Lang['edit'] . '" title="' . $Lang['edit'] . '" /></a>';
        $lDelete = '<a href="news.php?a=d&amp;id=%d"><img src="img/delete.png" alt="' . $Lang['delete'] . '" title="' . $Lang['delete'] . '" /></a>';
        $lRead = '<a href="news.php?a=v&amp;id=%d">' . $Lang['read_more'] . '</a>';
        $qry = $sql[0]->query('GET_NEWS_LIMITED', array("limit" => Config::get('news', 'news_in_index', '10')));
        while ($news = SQL::fetchArray($qry))
        {
            $nparse = $news;
            $nparse['img_title'] = $Lang['img_title'];
            $nparse['content'] = html_entity_decode($news['desc']);
            $parse['dots'] = '...';
            if ($news['editBy'] != '')
            {
                $nparse['edited'] = sprintf($Lang['last_edit_by'], $news['editTime'], $news['editBy']);
            }
            if (User::isMod())
            {
                $nparse['add'] = $lAdd;
                $nparse['edit'] = sprintf($lEdit, $news['id']);
                $nparse['delete'] = sprintf($lDelete, $news['id']);
            }
            else
            {
                $nparse['add'] = '';
                $nparse['edit'] = '';
                $nparse['delete'] = '';
            }
            $md5 = explode(".", $news['image']);
            if (!file_exists('news/' . $md5[0] . '.' . $md5[1]))
            {
                $nparse['image'] = 'image.png';
                $nparse['thumb'] = 'image_thumb.png';
            }
            else
            {
                $nparse['thumb'] = $md5[0] . '_thumb.' . $md5[1];
            }
            $nparse['read_more'] = sprintf($lRead, $news['id']);
            $parse['news'] .= TplParser::parse('news_row', $nparse, true);
        }
        if (!SQL::numRows())
        {
                $parse['news'] = $Lang['no_news'];
                if (User::isMod())
                {
                    $parse['news'] .= '<br />' . $lAdd;
                }
        }
    }
    $content = TplParser::parse('index2', $parse, true);
    Cache::update($content);

    echo $content;
}
else
{
    echo Cache::get();
}
foot();

?>