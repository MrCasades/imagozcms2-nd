<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Загрузка содержимого статьи*/
if (isset ($_GET['video']))
{
	$idPost = $_GET['video'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idpost'] = $idPost;
	$select = 'SELECT video.id, author.id AS idauthor, post, videotitle, videofile, imghead, imgalt, videoyoutube, videofile, videodate, authorname, category.id AS categoryid, categoryname FROM video 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND video.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода содержимого видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();

	$articleId = $row['id'];
	$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$videoFile = $row['videofile'];
	$date = $row['videodate'];
	$articleTitle = $row['videotitle'];
	
	$title = $row['videotitle'];//Данные тега <title>
	$headMain = $row['videotitle'];	
	$robots = 'noindex, nofollow';
	$descr = '';
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = '<iframe width="460px" height="290px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
	}
	
	else
	{
		$video = '';
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT meta.id, metaname FROM video 
				INNER JOIN metapost ON video.id = idpromotion 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE video.id = '.$idPost;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода списка тегов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
	
	/*Вывод кнопок "Обновить" | "Удалить" | "Опубликовать"*/
	
	if ((isset($_SESSION['loggIn'])) && (userRole('Администратор')))
	{
		$delAndUpd = "<form action = '../../../admin/addupdvideo/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_2 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_3 addit-btn'>
					  </form>";
		$premoderation = "<form action = '../../../admin/premoderation/videopremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Опубликовать' class='btn_1 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Отклонить' class='btn_2 addit-btn'>
					  </form>";			  
	}
	
	include 'viewpremodvideo.html.php';
}