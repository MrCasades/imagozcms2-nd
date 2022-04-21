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

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	$idVideo = $_GET['id'];
	
	$select = 'SELECT video.id AS videoid, author.id AS idauthor, post, videotitle, imghead, imgalt, videoyoutube, videofile, videodate, authorname, category.id AS categoryid, categoryname FROM video 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND video.id = ';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$sql = $select.$idVideo;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода видео в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['videoid'];
	$authorId = $row['idauthor'];
	$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['videodate'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	$videoFile = $row['videofile'];

	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории	
	
	$title = $row['videotitle'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['videotitle'];
	$robots = 'noindex, nofollow';
	$descr = $row['description'];
	$authorComment = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = '<iframe width="85%" height="320px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
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
				INNER JOIN metapost ON video.id = idvideo 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE video.id = '.$idVideo;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора тега';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
		
	/*Вывод кнопок "Обновить" | "Удалить"*/
	
	$pubAndUpd = "<form action = '../../../admin/addupdvideo/' method = 'post'>
			
					Действия с материалом:
					<input type = 'hidden' name = 'id' value = '".$idVideo."'>
					<input type = 'submit' name = 'action' value = 'ОБНОВИТЬ' class='btn_2 addit-btn'>
					<input type = 'submit' name = 'action' value = 'ОПУБЛИКОВАТЬ' class='btn_1 addit-btn'>
				</form>";

	include 'viewdraftvideo.html.php';
	exit();		
}
	
