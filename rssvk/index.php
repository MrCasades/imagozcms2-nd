<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';


/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод  новостей*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT newsblock.id AS newsid, author.id AS idauthor, news, newstitle, imghead, description, imgalt, newsdate, authorname, category.id AS categoryid, categoryname FROM newsblock 
			INNER JOIN author ON idauthor = author.id 
			INNER JOIN category ON idcategory = category.id 
			WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 20';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей rssvk';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	if ($row['categoryname'] != 'Наше сообщество')
	{
	
		$newsMain[] =  array ('id' => $row['newsid'], 'idauthor' => $row['idauthor'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'], 'description' => $row['description']);
	}
}

/*Вывод стаей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT posts.id AS postid, author.id AS idauthor, post, posttitle, imghead, imgalt, postdate, authorname, category.id AS categoryid, categoryname FROM posts 
			INNER JOIN author ON idauthor = author.id 
			INNER JOIN category ON idcategory = category.id 
			WHERE premoderation = "YES" ORDER BY postdate DESC LIMIT 100';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода статей rssvk';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	if (($row['categoryname'] != 'Наше сообщество') && ($row['categoryname'] != 'Изображение дня'))
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['idauthor'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}

include 'rssvk.html.php';
exit();
