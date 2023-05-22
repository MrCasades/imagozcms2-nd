<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

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
	$selectVideo = 'SELECT video.id AS videoid, author.id AS authorid,  videotitle, videodate, imghead, imgalt, videofile, viewcount, idauthor, idcategory, category.id AS categoryid, categoryname, authorname FROM video
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
		$error = 'Ошибка выбора новостей';
		include MAIN_FILE . '/includes/error.inc.php';
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
		$error = 'Ошибка выбора статей';
		include MAIN_FILE . '/includes/error.inc.php';
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
		$error = 'Ошибка выбора промоушена';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'promotiondate' => $row['promotiondate'],
						'categoryname' => $row['categoryname'], 'authorname' => $row['authorname'],'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'], 'www' =>  $row['www'],
						'categoryid' => $row['categoryid']);
	}

	try
	{
		$sql = $selectVideo.$idCategory. ' ORDER BY video.id DESC '. $limitPost;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$videos[] =  array ('id' => $row['videoid'], 'idauthor' => $row['authorid'], 'videotitle' =>  $row['videotitle'], 'videodate' => $row['videodate'],
						'categoryname' => $row['categoryname'], 'authorname' => $row['authorname'],'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'], 'viewcount' =>  $row['viewcount'], 'videofile' =>  $row['videofile'],
						'categoryid' => $row['categoryid']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}

	/*Загрузка настроек раздела*/
	$blockFolder = 'viewcategory';
	include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';

	include 'categorypost.html.php';
	exit();
}