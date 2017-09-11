<?php
define('L2WEB', true);
require_once ("include/core.php");

User::loggedInOrReturn('news.php');
head($Lang['news']);

$maxfilesize = 1024 * 1024 * 1024 * 5;

$allowed_types = array(
	"image/gif" => "gif",
	"image/pjpeg" => "jpg",
	"image/jpeg" => "jpg",
	"image/jpg" => "jpg",
	"image/png" => "png");
$action = isset($_GET['a']) ? filter_input(INPUT_GET, 'a') : '';
$id = isset($_GET['id']) ? fInt(filter_input(INPUT_GET, 'id')) + 0 : 0;
if (!is_numeric($id) || $id <= 0) { $id = null; }
$parse = $Lang;

switch ($action)
{
	case 'a':
		if (User::isMod())
		{
			if (isset($_POST['title']))
			{
				$name = fString(filter_input(INPUT_POST, 'title'));
				$desc = fString(filter_input(INPUT_POST, 'desc'));
				$error = 0;
				if ($name == '')
				{
					msg($Lang['error'], $Lang['invalid_title'], 'error');
					$error++;
				}
				if ($desc == '')
				{
					msg($Lang['error'], $Lang['invalid_content'], 'error');
					$error++;
				}
				if ($_FILES['file']['name'] != null)
				{
					if ($_FILES['file']['size'] > $maxfilesize)
					{
						msg($Lang['error'], $Lang['file_too_large'], 'error');
						$error++;
					}
					if ($_FILES['file']['name'] == '')
					{
						msg($Lang['error'], $Lang['empty_file'], 'error');
						$error++;
					}
					if (!array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
					{
						msg($Lang['error'], $Lang['wrong_filetype'], 'error');
						$error++;
					}
				}
				if ($error === 0)
				{
					$descdb = substr($desc, 0, 500);
					//$desc=str_replace('\r\n','<br />');
					$ext = $_FILES['file']['name'] != '' ? $allowed_types[$_FILES['file']['type']] : '';
					$md5 = substr(md5($name . time()), 0, 12);
					$sql[0]->query('RECACHE_CACHE_BY_PAGE', array('page' => 'index'));
					$qry = $sql[0]->query('ADD_NEW', array(
						"desc" => $descdb,
						"title" => $name,
						"author" => User::getUser(),
						"date" => date('Y-m-d H:i:s'),
						"image" => $md5 . '.' . $ext));
					if (SQL::numRows())
					{
						if (file_exists('news/' . $md5 . '.html'))
							unlink('news/' . $md5 . '.html');
						file_put_contents('news/' . $md5 . '.html', $desc);

						if (file_exists('news/' . $md5 . '.' . $ext))
							unlink('news/' . $md5 . '.' . $ext);
						if ($_FILES['file']['name'] != '')
						{
							move_uploaded_file($_FILES['file']['tmp_name'], 'news/' . $md5 . '.' . $ext);
							convertPic($md5, $ext, 150, 150);
						}
						msg($Lang['success'], $Lang['news_added']);
					}
					else
					{
						msg($Lang['error'], $Lang['something_wrong'], 'error');
					}

				}
				else
				{
					msg($Lang['error'], $Lang['fix_errors'], 'error');
				}

			}
			$parse['a'] = 'a';
			$parse['titleV'] = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'title'))));
			$parse['content'] = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'desc'))));
			$parse['bSubmit'] = button('submit');
			TplParser::parse('news', $parse);
		}
		break;
	case 'e':
		if (isset($id) && User::isMod() && $id != null)
		{
			if ($_POST)
			{
				$error = 0;
				if (!isset($_POST['title']) || $_POST['title'] == '')
				{
					msg($Lang['error'], $Lang['invalid_title'], 'error');
					$error++;
				}
				if (!isset($_POST['desc']) || $_POST['desc'] == '')
				{
					msg($Lang['error'], $Lang['something_content'], 'error');
					$error++;
				}
				if ($_FILES['file'])
				{
					if ($_FILES['file']['size'] > $maxfilesize)
					{
						msg($Lang['error'], $Lang['file_too_large'], 'error');
						$error++;
					}
					if (!array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
					{
						msg($Lang['error'], $Lang['wrong_filetype'], 'error');
						$error++;
					}
				}
				if ($error === 0)
				{
					$newsq = $sql[0]->query('GET_NEW_BY_ID', array("id" => $id));
					if (SQL::numRows($newsq))
					{
						$news = SQL::fetchArray($newsq);
						$name = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'title'))));
						$desc = htmlspecialchars(html_entity_decode(fString(filter_input(INPUT_POST, 'desc'))));
						$desc = str_replace(array('\r\n'), '<br />', $desc);
						$desc = str_replace(array('\n'), '<br />', $desc);
						$desc = str_replace(array('\r'), '<br />', $desc);
						$md5 = explode(".", $news['image']);
						if (isset($_FILES['file']) && $_FILES['file']['name'] != '')
						{
							$ext = $allowed_types[$_FILES['file']['type']];
						}
						else
						{
							$ext = $md5[1];
						}
						if (file_exists('news/' . $md5[0] . '.html'))
						{
							unlink('news/' . $md5[0] . '.html');
						}
						file_put_contents('news/' . $md5[0] . '.html', $desc);
						$desc = substr($desc, 0, 500);
						$sql[0]->query('RECACHE_CACHE_BY_PAGE', array('page' => 'index'));
						$sql[0]->query('UPDATE_NEW_BY_ID', array(
							"id" => $id,
							"desc" => $desc,
							"title" => $name,
							"date" => date('Y-m-d H:i:s'),
							"editor" => $_SESSION['account']));
						if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != '')
						{
							if (file_exists('news/' . $md5[0] . '.' . $ext))
                                                        {
								unlink('news/' . $md5[0] . '.' . $ext);
                                                        }
							move_uploaded_file($_FILES['file']['tmp_name'], 'news/' . $md5[0] . '.' . $ext);
							convertPic($md5[0], $ext, 150, 150);

						}
						msg($Lang['success'], $Lang['news_updated']);
					}
					else
					{
						msg($Lang['error'], $Lang['news_not_found'], 'error');
					}
				}
				else
				{
					echo msg($Lang['error'], $Lang['fix_errors'], 'error');
				}

			}

			$newsq = $sql[0]->query('GET_NEW_BY_ID', array("id" => $id));
			if (SQL::numRows($newsq))
			{
				$news = SQL::fetchArray($newsq);
				$md5 = explode(".", $news['image']);

				$desc = file_exists('news/' . $md5[0] . '.html') ? file_get_contents('news/' . $md5[0] . '.html') : $news['desc'];
				//$desc = str_replace('\\r\\n', "\n", $desc);
				//$desc = nl2br($desc);
				$parse['a'] = 'e';
				$parse['id'] = '&amp;id=' . $id;
				$parse['titleV'] = $news['title'];
				$parse['content'] = htmlspecialchars(html_entity_decode($desc));
				$parse['bSubmit'] = button('submit');
				TplParser::parse('news', $parse);
			}
		}
		break;
	case 'd':

		if (isset($id) && isset($_GET['c']) && $id != null && User::isMod())
		{
			$news = $sql[0]->query('GET_NEW_BY_ID', array("id" => $id));
			if (SQL::numRows($news))
			{
				$new = SQL::fetchArray($news);
				$sql[0]->query('DELETE_NEW_BY_ID', array("id" => $id));
				$md = explode(".", $new['image']);
				$ext = $md[1];
				$md5 = $md[0];

				if (file_exists('news/' . $md5 . '.html'))
				{
					if (unlink('news/' . $md5 . '.html'))
					{
						echo sprintf($Lang['file_f_deleted'], $md5 . '.html');
					}
				}
				if (file_exists('news/' . $md5 . '.' . $ext))
				{
					if (unlink('news/' . $md5 . '.' . $ext))
					{
						echo sprintf($Lang['file_f_deleted'], 'news/' . $md5 . '.' . $ext);
					}
				}
				if (file_exists('news/' . $md5 . '_thumb.' . $ext))
				{
					if (unlink('news/' . $md5 . '_thumb.' . $ext))
					{
						echo sprintf($Lang['file_f_deleted'], 'news/' . $md5 . '_thumb.' . $ext);
					}
				}
				$sql[0]->query('RECACHE_CACHE_BY_PAGE', array('page' => 'index'));
				msg($Lang['success'], $Lang['news_deleted']);
			}
			else
			{
				msg($Lang['error'], $Lang['news_not_found'], 'error');
			}
		}
		else
		{
			if (User::isMod())
			{
				echo $Lang['are_u_sure_news'];
				echo '<br/><a href="news.php?a=d&amp;c=1&amp;id=' . $id . '">';
				echo menubutton('delete');
				echo '</a>';
			}
		}
		break;
	default:
		$lAdd = '<a href="news.php?a=a"><img src="img/add.png" alt="' . $Lang['add'] . '" title="' . $Lang['add'] . '" /></a>';
		$lEdit = '<a href="news.php?a=e&amp;id=%d"><img src="img/edit.png" alt="' . $Lang['edit'] . '" title="' . $Lang['edit'] . '" /></a>';
		$lDelete = '<a href="news.php?a=d&amp;id=%d"><img src="img/delete.png" alt="' . $Lang['delete'] . '" title="' . $Lang['delete'] . '" /></a>';
		$lRead = '<a href="news.php?a=v&amp;id=%d">' . $Lang['read_more'] . '</a>';
		if (isset($id) && $id != null)
		{
			$new = $sql[0]->query('GET_NEW_BY_ID', array("id" => $id));
			if (SQL::numRows())
			{
				$newid = SQL::fetchArray();

				$md5 = explode(".", $newid['image']);
				$ext = $md5[1];
				$nid = $md5[0];
				if (file_exists('news/' . $nid . '.html'))
				{
					$parse += $newid;
                    $parse['date']=$newid['date'];
					if (!file_exists('news/' . $nid . '.' . $ext))
					{
						$parse['image'] = 'image.png';
					}
					else
					{
                                                $parse['image'] = $newid['image'];
					}
                    $parse['content'] = html_entity_decode(file_exists('news/' . $nid . '.html') ? file_get_contents('news/' . $nid . '.html') : $newid['desc']);
					$parse['title']=$newid['title'];
                    $parse['read_more'] = '';

					if ($newid['editBy'] != '')
					{
						$parse['edited'] = sprintf($Lang['last_edit'], $newid['editTime'], $newid['editBy']);
					}
					if (User::isMod())
					{
						$parse['add'] = $lAdd;
						$parse['edit'] = sprintf($lEdit, $newid['id']);
						$parse['delete'] = sprintf($lDelete, $newid['id']);
					}
					else
					{
						$parse['add'] = '';
						$parse['edit'] = '';
						$parse['delete'] = '';
					}
					TplParser::parse('news_row', $parse);
				}
				else
				{
					msg($Lang['error'], $Lang['news_not_found'], 'error');
					if (User::isMod())
					{
						echo $Lang['are_u_sure_news'];
						echo '<br/><a href="news.php?a=d&amp;c=1&amp;id=' . $id . '">';
						echo menubutton('delete');
						echo '</a>';
					}
				}
			}
			else
			{
				msg($Lang['error'], $Lang['news_not_found'], 'error');
			}
		}
		else
		{
			$newsq = $sql[0]->query('GET_NEWS_LIMITED', array("limit" => Config::get('news', 'news_limit', 10)));
            //unset($parse);
			while ($news = SQL::fetchArray($newsq))
			{
			 //$parse=$Lang;
				//$parse += $news;
                $parse['content']=html_entity_decode($news['desc']);
                $parse['title']=$news['title'];
				$parse['read_more'] = sprintf($lRead, $news['id']);
				$parse['dots'] = '...';
				$md5 = explode(".", $news['image']);
				if (!file_exists('news/' . $md5[0] . '_thumb.' . $md5[1]))
				{
					$parse['thumb'] = 'image_thumb.png';
				}
				else
				{
					$parse['thumb'] = $md5[0] . '_thumb.' . $md5[1];
				}
				if ($news['editBy'] != '')
				{
					$parse['edited'] = sprintf($Lang['last_edit'], $news['editTime'], $news['editBy']);
				}
				if (User::isMod())
				{
					$parse['add'] = $lAdd;
					$parse['edit'] = sprintf($lEdit, $news['id']);
					$parse['delete'] = sprintf($lDelete, $news['id']);
				}
				else
				{
					$parse['add'] = '';
					$parse['edit'] = '';
					$parse['delete'] = '';
				}
				TplParser::parse('news_row', $parse);
			}
		}
		break;
}
foot();
?>