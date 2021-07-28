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
	$idNews = $_GET['id'];
	
	$select = 'SELECT newsblock.id AS newsid, author.id AS idauthor, news, newstitle, imghead, videoyoutube, viewcount, votecount, averagenumber, favouritescount, description, imgalt, newsdate, authorname, category.id AS categoryid, categoryname FROM newsblock 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND draft = "YES" AND newsblock.id = ';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$sql = $select.$idNews;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select news ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['newsid'];
	$authorId = $row['idauthor'];
	$articleText = $row['news'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['newsdate'];
	$viewCount = $row['viewcount'];
	$averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	$favouritesCount = $row['favouritescount'];

	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории	
	
	$title = $row['newstitle'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['newstitle'];
	$robots = 'noindex, nofollow';
	$descr = $row['description'];
	$authorComment = '';
	$jQuery = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
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
		$sql = 'SELECT meta.id, metaname FROM newsblock 
				INNER JOIN metapost ON newsblock.id = idnews 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE newsblock.id = '.$idNews;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора тега ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
		
	/*Вывод кнопок "Обновить" | "Удалить"*/
	
	$pubAndUpd = "<form action = '../../../admin/addupdnews/' method = 'post'>
			
					Действия с материалом:
					<input type = 'hidden' name = 'id' value = '".$idNews."'>
					<input type = 'submit' name = 'action' value = 'ОБНОВИТЬ' class='btn_2'>
					<input type = 'submit' name = 'action' value = 'ОПУБЛИКОВАТЬ' class='btn_1'>
				</form>";

	include 'viewdraftnews.html.php';
	exit();		
}
	
