<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Вывод статей по категориям*/

if (isset ($_GET['id']))
{
		
	$idCategory = $_GET['id'];
	$selectNews = 'SELECT newsblock.id, news, newstitle, newsdate, idauthor, idcategory, categoryname, authorname, imghead FROM newsblock
			INNER JOIN category
			ON idcategory = category.id
			INNER JOIN author
			ON idauthor = author.id 
			WHERE premoderation = "YES" AND idcategory = ';
	$selectPost = 'SELECT posts.id AS postid, author.id AS authorid,  post, posttitle, postdate, imghead, imgalt, idauthor, idcategory, category.id AS categoryid, categoryname, authorname FROM posts
			INNER JOIN category
			ON idcategory = category.id
			INNER JOIN author
			ON idauthor = author.id 
			WHERE premoderation = "YES" AND zenpost = "NO" AND idcategory = ';
	$selectPromotion = 'SELECT promotion.id AS promotionid, author.id AS authorid,  promotion, promotiontitle, promotiondate, imghead, imgalt, promotion.www, idauthor, idcategory, category.id AS categoryid, categoryname, authorname FROM promotion
			INNER JOIN category
			ON idcategory = category.id
			INNER JOIN author
			ON idauthor = author.id 
			WHERE premoderation = "YES" AND idcategory = ';
	$limitNews = ' LIMIT 9';
	$limitPost = ' LIMIT 6';
			
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $selectNews.$idCategory. ' ORDER BY newsblock.id DESC '. $limitNews;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора новостей ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['id'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'newsdate' => $row['newsdate'],
								'category' => $row['categoryname'], 'author' => $row['authorname'], 'imghead' => $row['imghead']);
	}	
	
	try
	{
		$sql = $selectPost.$idCategory. ' ORDER BY posts.id DESC '. $limitPost;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора статей ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['authorid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'postdate' => $row['postdate'],
						'categoryname' => $row['categoryname'], 'authorname' => $row['authorname'],'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'categoryid' => $row['categoryid']);
	}
	
	try
	{
		$sql = $selectPromotion.$idCategory. ' ORDER BY promotion.id DESC '. $limitPost;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора статей ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'promotiondate' => $row['promotiondate'],
						'categoryname' => $row['categoryname'], 'authorname' => $row['authorname'],'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'], 'www' =>  $row['www'],
						'categoryid' => $row['categoryid']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}

	if (isset ($row['categoryname']))
	{		
	
		$title = $row['categoryname'].' | imagoz.ru';//Данные тега <title>
		$headMain = 'Материалы рубрики '. '"'.$row['categoryname'].'"';
		$robots = 'noindex, follow';
		$descr = 'В даном разделе отображаются все статьи и новости рубрики '.$row['categoryname'];
	}
	
	else
	{
		$title = 'В рубрике отсутствуют материалы';//Данные тега <title>
		$headMain = 'В рубрике отсутствуют материалы';
		$robots = 'noindex, follow';
		$descr = '';
	}
	
	include 'categorypost.html.php';
	exit();
}