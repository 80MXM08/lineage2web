<?php

define('L2WEB', true);
require_once ('core/core.php');
require_once ('core/class.news.php');
head($Lang['__news_']);

$maxfilesize = 1024 * 1024 * 1024 * 5;


$action = filter_input(INPUT_GET, 'a');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => array('default' => null, 'min_range' => 1)]);
$title = fString(filter_input(INPUT_POST, 'title'));
$content = fString(filter_input(INPUT_POST, 'desc'));
if ($action == 'a' && User::isMod()) {

    if ($_POST) {
        $error = 0;
        if ($title == '') {
            echo msg($Lang['__error_'], $Lang['__invalid-title_'], 'error');
            $error++;
        }
        if ($content == '') {
            echo msg($Lang['__error_'], $Lang['__invalid-content_'], 'error');
            $error++;
        }
        if ($_FILES['file']['name'] != null) {
            if ($_FILES['file']['size'] > $maxfilesize) {
                echo msg($Lang['__error_'], $Lang['__file-too-large_'], 'error');
                $error++;
            }
            if ($_FILES['file']['name'] == '') {
                echo msg($Lang['__error_'], $Lang['__empty-file_'], 'error');
                $error++;
            }
            if (!array_key_exists($_FILES['file']['type'], news::$allowedTypes) && $_FILES['file']['name'] != '') {
                echo msg($Lang['__error_'], $Lang['__wrong-filetype_'], 'error');
                $error++;
            }
        }
        if ($error === 0) {
            echo news::add($title, $content, $_FILES['file']);
        } else {
            echo msg($Lang['__error_'], $Lang['__fix-errors_'], 'error');
        }
    }
    $parse['a'] = 'a';
    $parse['titleV'] = htmlspecialchars(html_entity_decode($title));
    $parse['content'] = htmlspecialchars(html_entity_decode($content));
    $parse['bSubmit'] = button('submit');
    $parse['id']='';
    echo tpl::parse('news', $parse);
} else if ($action == 'e') {
    if (isset($id) && User::isMod() && $id != null) {
        if ($_POST) {
            $error = 0;
            if (!isset($_POST['title']) || $_POST['title'] == '') {
                echo msg($Lang['__error_'], $Lang['__invalid-title_'], 'error');
                $error++;
            }
            if (!isset($_POST['desc']) || $_POST['desc'] == '') {
                echo msg($Lang['__error_'], $Lang['__something-content_'], 'error');
                $error++;
            }
            if ($_FILES['file']) {
                if ($_FILES['file']['size'] > $maxfilesize) {
                    echo msg($Lang['__error_'], $Lang['__file-too-large_'], 'error');
                    $error++;
                }
                if (!array_key_exists($_FILES['file']['type'], news::$allowedTypes) && $_FILES['file']['name'] != '') {
                    echo msg($Lang['__error_'], $Lang['__wrong-filetype_'], 'error');
                    $error++;
                }
            }
            if ($error === 0) {
                $name = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'title'))));
                $desc = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'desc'))));
                $desc = str_replace(array('\r\n'), '<br />', $desc);
                $desc = str_replace(array('\n'), '<br />', $desc);
                $desc = str_replace(array('\r'), '<br />', $desc);
                echo news::edit($id, $name, $desc, $_FILES['file']);
            } else {
                echo msg($Lang['__error_'], $Lang['__fix-errors_'], 'error');
            }
        }

        $news = DAO::get()::News()::get($id)[0];
        if ($news) {
            $md5 = explode(".", $news['image']);

            $desc = file_exists('news/' . $md5[0] . '.html') ? file_get_contents('news/' . $md5[0] . '.html') : $news['content'];

            $parse['a'] = 'e';
            $parse['id'] = '&amp;id=' . $id;
            $parse['titleV'] = $news['title'];
            $parse['content'] = htmlspecialchars(html_entity_decode($desc));
            $parse['bSubmit'] = button('submit');
            echo tpl::parse('news', $parse);
        }
    }
} else if ($action == 'd') {

    if (isset($id) && isset($_GET['c']) && $id != null && User::isMod()) {
        news::delete($id);
    } else {
        if (User::isMod()) {
            echo $Lang['__are-u-sure-news_'];
            echo '<br/><a href="news.php?a=d&amp;c=1&amp;id=' . $id . '">';
            echo menubutton('delete');
            echo '</a>';
        }
    }
} else {
    if (isset($id) && $id != null) {
        echo news::viewById($id);
    } else {
        echo news::viewAll();
    }
}

foot();
