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
if (isset ($_GET['blogpub']))
{
	$idPub = $_GET['blogpub'];
	
	$select = 'SELECT p.id, 
					  a.id AS idauthor, 
					  p.title, 
					  p.imghead, 
					  p.imgalt, 
					  p.videoyoutube, 
					  p.date, 
					  a.authorname, 
				FROM publication p 
				INNER JOIN author a ON p.idauthor = a.id 
				WHERE p.premoderation = "NO" AND p.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPub;
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
	//$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	//$videoFile = $row['videofile'];
	$date = $row['date'];
	$articleTitle = $row['title'];
	$nameAuthor = $row['authorname'];
	//$categoryName = $row['categoryname'];
	$authorId = $row['idauthor'];
	//$categoryId = $row['categoryid'];
	
	$title = $row['title'];//Данные тега <title>
	$headMain = $row['title'];	
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
				WHERE video.id = '.$idPub;//Вверху самое последнее значение
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
						<input type = 'hidden' name = 'id' value = '".$idPub."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_2 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_3 addit-btn'>
					  </form>";
		$premoderation = "<form action = '../../../admin/premoderation/videopremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$idPub."'>
						<input type = 'submit' name = 'action' value = 'Опубликовать' class='btn_1 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Отклонить' class='btn_2 addit-btn'>
					  </form>";			  
	}
	
	include 'viewpremodvideo.html.php';
}