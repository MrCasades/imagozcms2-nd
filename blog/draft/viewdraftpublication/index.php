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
	$idPost = $_GET['id'];
	
	$select = 'SELECT 
					p.id AS pubid, 
					a.id AS idauthor, 
					p.text, 
					p.title, 
					p.imghead, 
					p.videoyoutube, 
					p.imgalt, 
					p.date, 
					a.authorname, 
					c.id AS categoryid, 
					c.categoryname
			   FROM publication p  
			   INNER JOIN author a ON a.idauthor = a.id 
			   INNER JOIN blogs b ON p.idblog = b.id 
			   INNER JOIN category c ON p.idcategory = c.id
			   WHERE p.premoderation = "NO" AND p.draft = "YES" AND p.id = ';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$sql = $select.$idPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статьи';			
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['pubid'];
	$authorId = $row['idauthor'];
	$articleText = $row['text'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['date'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	$posttitle = $row['title'];

	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории	
	
	$title = $row['title'].' | imagoz.ru';//Данные тега <title>
	$headMain = '<a href="#" onclick="history.back();">Назад</a>';
	$robots = 'noindex, nofollow';
	$descr = '';
	$authorComment = '';
	
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
		$sql = 'SELECT meta.id, metaname FROM posts 
				INNER JOIN metapost ON posts.id = idpost 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE posts.id = '.$idPost;//Вверху самое последнее значение
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
	
	$pubAndUpd = "<form action = '../addupdblog/' method = 'post'>
			
					Действия с материалом:
					<input type = 'hidden' name = 'id' value = '".$idPost."'>
					<input type = 'submit' name = 'action' value = 'ОБНОВИТЬ' class='btn_2 addit-btn'>
					<input type = 'submit' name = 'action' value = 'ОПУБЛИКОВАТЬ' class='btn_1 addit-btn'>
				</form>";

	include '../admin/commonfiles/preview.html.php';
	exit();		
}
	
