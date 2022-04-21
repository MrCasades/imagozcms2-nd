<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор') && !userRole('Автор') && !userRole('Рекламодатель'))
{
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Вывод материалов для премодерации*/
if (userRole('Автор') || userRole('Администратор'))
{

	/*возврат ID автора*/
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Вывод новостей*/
	/*Команда SELECT*/

	try
	{
		$sql = 'SELECT newsblock.id AS newsid, news, author.id AS authorid, newstitle, imghead, imgalt, newsdate, authorname, category.id AS categoryid, categoryname FROM newsblock 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id 
				WHERE premoderation = "NO" AND draft = "YES" AND idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода новостей в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['authorid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}

	/*Вывод стаей*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT posts.id AS postid, post, author.id AS authorid, posttitle, imghead, imgalt, postdate, authorname, category.id AS categoryid, categoryname FROM posts 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id 
				WHERE premoderation = "NO" AND draft = "YES" AND idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода статей в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['authorid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
	
	/*Вывод промоушен*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT promotion.id AS promotionid, promotion, author.id AS authorid, promotiontitle, promotion.www, imghead, imgalt, promotiondate, authorname, category.id AS categoryid, categoryname FROM promotion 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id 
				WHERE premoderation = "NO" AND draft = "YES" AND idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода промоушена в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
								'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'],
								'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}


	/*Вывод видео*/
	/*Команда SELECT*/

	try
	{
		$sql = 'SELECT v.id, v.videotitle, v.videodate, v.imghead, c.categoryname
				FROM video v 
				INNER JOIN category c ON v.idcategory = c.id  
				WHERE premoderation = "NO" AND draft = "YES" AND idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода видео на главной странице';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$videos[] =  array ('id' => $row['id'], 'videotitle' =>  $row['videotitle'], 'videodate' =>  $row['videodate'], 'categoryname' =>  $row['categoryname'],
							'imghead' =>  $row['imghead']);
	}

	
	if (!isset($newsIn) && !isset($posts) && !isset($promotions))
	{
		$title = 'Материалы отсутствуют';//Данные тега <title>
		$headMain = 'Материалы отсутствуют';
		$robots = 'noindex, nofollow';
		$descr = 'Вданном разделе выводятся материалы которые находятся в премодерации';
	}
	
	else
	{
		$title = 'Мой черновик';//Данные тега <title>
		$headMain = 'Мой черновик';
		$robots = 'noindex, nofollow';
		$descr = 'В данном разделе выводятся материалы которые находятся в черновике';
	}

	include 'draft.html.php';
	exit();
}

/*Вывод рекламных материалов для премодерации*/
if (userRole('Рекламодатель'))
{

	/*возврат ID автора*/
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Вывод промоушен*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT promotion.id AS promotionid, promotion, author.id AS authorid, promotiontitle, promotion.www, imghead, imgalt, promotiondate, authorname, category.id AS categoryid, categoryname FROM promotion 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id 
				WHERE premoderation = "NO" AND refused = "NO" AND idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода промоушена в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
								'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'],
								'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
	
	if (!isset($promotions))
	{
		$title = 'Материалы отсутствуют';//Данные тега <title>
		$headMain = 'Материалы отсутствуют';
		$robots = 'noindex, nofollow';
		$descr = 'Вданном разделе выводятся материалы которые находятся в премодерации';
	}

	else
	{
		$title = 'Мой черновик';//Данные тега <title>
		$headMain = 'Мой черновик';
		$robots = 'noindex, nofollow';
		$descr = 'В данном разделе выводятся материалы которые находятся в черновике';
	}
	
	include 'draftpromotion.html.php';
	exit();
}