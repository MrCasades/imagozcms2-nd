<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод  новостей*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT newsblock.id AS newsid, author.id AS idauthor, news, newstitle, imghead, description, imgalt, newsdate, authorname, category.id AS categoryid, categoryname, videoyoutube FROM newsblock 
			INNER JOIN author ON idauthor = author.id 
			INNER JOIN category ON idcategory = category.id 
			WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 5';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей rsspulse';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	if ($row['categoryname'] != 'Наше сообщество')
	{
	
		$newsMain[] =  array ('id' => $row['newsid'], 'idauthor' => $row['idauthor'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 'videoyoutube' =>  $row['videoyoutube'],
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'], 'description' => $row['description']);
	}
}

/*Вывод стаей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT posts.id AS postid, author.id AS idauthor, post, posttitle, imghead, description, imgalt, postdate, authorname, category.id AS categoryid, categoryname, videoyoutube FROM posts 
			INNER JOIN author ON idauthor = author.id 
			INNER JOIN category ON idcategory = category.id 
			WHERE premoderation = "YES" ORDER BY postdate DESC LIMIT 5';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода статей rsstg';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	if (($row['categoryname'] != 'Наше сообщество') && ($row['categoryname'] != 'Изображение дня'))
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['idauthor'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 'videoyoutube' =>  $row['videoyoutube'],
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'], 'description' => $row['description']);
	}
}

/*Вывод даджеста*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, 
				text, 
				title, 
				imghead, 
				description, 
				imgalt, 
				date, 
				authorname, 
				categoryname 
			FROM newsset
			WHERE ispulse = 1
			ORDER BY date DESC LIMIT 5';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода даджеста rsstg';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{

	$newssets[] =  array ('id' => $row['id'], 'text' => $row['text'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'],
							'categoryname' =>  $row['categoryname'], 'description' => $row['description']);

}

include 'rsstg.html.php';
exit();
