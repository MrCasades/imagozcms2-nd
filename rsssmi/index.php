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
			WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 15';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей в rss';
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

try
{
	$sql = 'SELECT newsdate FROM newsblock WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 1';//Вверху самое последнее значение
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода последней новости';
	include MAIN_FILE . '/includes/error.inc.php';
}

$row = $s -> fetch();

$lastBuild = $row['newsdate'];


include 'rsssmi.html.php';
exit();
