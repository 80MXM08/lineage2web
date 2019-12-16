<?php

if (!defined('CORE')) {
    exit();
}

class news {

    static $htmlDone = false;
    static $lAdd, $lEdit, $lDelete, $lRead;
    static $allowedTypes = array(
        "image/gif" => "gif",
        "image/pjpeg" => "jpg",
        "image/jpeg" => "jpg",
        "image/jpg" => "jpg",
        "image/png" => "png");

    static function initHtml() {
        global $Lang;
        news::$lAdd = htmlLink('news.php?a=a', htmlImg('img/add.png', $Lang['__add_']));
        news::$lEdit = htmlLink('news.php?a=e&amp;id=%d', htmlImg('img/edit.png', $Lang['__edit_']));
        news::$lDelete = htmlLink('news.php?a=d&amp;id=%d', htmlImg('img/delete.png', $Lang['__delete_']));
        news::$lRead = htmlLink('news.php?a=v&amp;id=%d', $Lang['__read-more_']);
        news::$htmlDone = true;
    }

    static function viewAll() {
        global $Lang;
        if (news::$htmlDone == false) {
            news::initHtml();
        }
        $content = '';
        $rows = DAO::get()::News()::getAll();
        if (!count($rows)) {

            $content .= $Lang['__no-news_'];
            if (User::isMod()) {
                $content .= '<br />' . news::$lAdd;
            }
            return $content;
        }
        foreach ($rows as $n) {
            $new = $n;
            $new['img_title'] = $Lang['__img-title_'];
            $new['content'] = html_entity_decode($n['content']);
            $new['dots'] = '...';

            $new['edited'] = $new['add'] = $new['edit'] = $new['delete'] = '';
            if ($n['editBy'] != '') {
                $new['edited'] = sprintf($Lang['__last-edit-by_'], $n['editTime'], $n['editBy']);
            }

            if (User::isMod()) {
                $new['add'] = news::$lAdd;
                $new['edit'] = sprintf(news::$lEdit, $n['id']);
                $new['delete'] = sprintf(news::$lDelete, $n['id']);
            }

            $md5 = explode(".", $n['image']);
            if (!file_exists('news/' . $md5[0] . '.' . $md5[1])) {
                $new['image'] = 'image.png';
                $new['thumb'] = 'image_thumb.png';
            } else {
                $new['image'] = $md5[0] . '.' . $md5[1];
                $new['thumb'] = $md5[0] . '_thumb.' . $md5[1];
            }
            $new['read_more'] = sprintf(news::$lRead, $n['id']);
            $content .= tpl::parse('news_row', $new);
        }

        return $content;
    }

    static function viewById($id) {
        global $Lang;
        if (news::$htmlDone == false) {
            news::initHtml();
        }
        global $Lang;
        $r = DAO::get()::News()::get($id)[0];

        if (!$r) {
            echo msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
            return;
        }
        $md5 = explode(".", $r['image']);
        $nid = $md5[0];
        if (!file_exists('news/' . $nid . '.html')) {
            msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
            if (User::isMod()) {
                echo $Lang['__are-u-sure-news_'];
                echo '<br/><a href="news.php?a=d&amp;c=1&amp;id=' . $id . '">';
                echo menubutton('delete');
                echo '</a>';
            }
            return;
        }
        if (!file_exists('news/' . $r['image'])) {
            $parse['image'] = 'image.png';
        }

        $r['content'] = html_entity_decode(file_get_contents('news/' . $nid . '.html'));
        $parse['title'] = $r['title'];
        $r['read_more'] = $r['dots'] = $r['edited'] = $r['add'] = $r['edit'] = $r['delete'] = '';

        if ($r['editBy'] != '') {
            $r['edited'] = sprintf($Lang['__last-edit_'], $r['editTime'], $r['editBy']);
        }
        if (User::isMod()) {
            $r['add'] = news::$lAdd;
            $r['edit'] = sprintf(news::$lEdit, $r['id']);
            $r['delete'] = sprintf(news::$lDelete, $r['id']);
        }
        return tpl::parse('news_row', $r);
    }

    static function add($title, $content, $file) {
        global $Lang;
        $content2db = substr($content, 0, 500);
        $ext = $file['name'] != '' ? news::$allowedTypes[$file['type']] : '';
        $md5 = substr(md5($title . time()), 0, 12);

        if (DAO::get()::News()::add($title, $content2db, $md5 . '.' . $ext)) {
            if (file_exists('news/' . $md5 . '.html')) {
                unlink('news/' . $md5 . '.html');
            }
            file_put_contents('news/' . $md5 . '.html', $content);

            if (file_exists('news/' . $md5 . '.' . $ext)) {
                unlink('news/' . $md5 . '.' . $ext);
            }
            if ($file['name'] != '') {
                move_uploaded_file($file['tmp_name'], 'news/' . $md5 . '.' . $ext);
                convertPic($md5, $ext, 150, 150);
            }
            DAO::get()::Cache()::reCache('index');
            return msg($Lang['__success_'], $Lang['__news-added_']);
        } else {
            return msg($Lang['__error_'], $Lang['__something-wrong_'], 'error');
        }
    }

    static function edit($id, $title, $content, $file) {
        global $Lang;
        $news = DAO::get()::News()::get($id)[0];
        if ($news) {

            $md5 = explode(".", $news['image']);
            if (isset($file) && $file['name'] != '') {
                $ext = news::$allowedTypes[$_FILES['file']['type']];
            } else {
                $ext = $md5[1];
            }
            if (file_exists('news/' . $md5[0] . '.html')) {
                unlink('news/' . $md5[0] . '.html');
            }
            file_put_contents('news/' . $md5[0] . '.html', $content);

            DAO::get()::News()::update($id, $title, substr($content, 0, 500));

            if (isset($file) && $file['tmp_name'] != '') {
                if (file_exists('news/' . $md5[0] . '.' . $ext)) {
                    unlink('news/' . $md5[0] . '.' . $ext);
                }
                move_uploaded_file($file['tmp_name'], 'news/' . $md5[0] . '.' . $ext);
                convertPic($md5[0], $ext, 150, 150);
            }
            DAO::get()::Cache()::reCache('index');
            return msg($Lang['__success_'], $Lang['__news-updated_']);
        } else {
            return msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
        }
    }
    static function delete($id)
    {
        global $Lang;
        $news = DAO::get()::News()::get($id)[0];
        $msg='';
        if ($news) {
            
            $md = explode(".", $news['image']);
            $ext = $md[1];
            $md5 = $md[0];

            if (file_exists('news/' . $md5 . '.html')) {
                if (unlink('news/' . $md5 . '.html')) {
                    $msg.= sprintf($Lang['__file-f-deleted_'], $md5 . '.html');
                }
            }
            if (file_exists('news/' . $md5 . '.' . $ext)) {
                if (unlink('news/' . $md5 . '.' . $ext)) {
                    $msg.= sprintf($Lang['__file-f-deleted_'], 'news/' . $md5 . '.' . $ext);
                }
            }
            if (file_exists('news/' . $md5 . '_thumb.' . $ext)) {
                if (unlink('news/' . $md5 . '_thumb.' . $ext)) {
                    $msg.= sprintf($Lang['__file-f-deleted_'], 'news/' . $md5 . '_thumb.' . $ext);
                }
            }
            DAO::get()::News()::delete($id);
            DAO::get()::Cache()::reCache('index');
            $msg .=msg($Lang['__success_'], $Lang['__news-deleted_']);
        } else {
            $msg .=msg($Lang['__error_'], $Lang['__news-not-found_'], 'error');
        }
        return $msg;
    }
}
