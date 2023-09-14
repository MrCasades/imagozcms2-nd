<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';


/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод  новостей*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT id, newsdate FROM newsblock WHERE premoderation = "YES" ORDER BY newsdate DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$newsMain[] =  array ('id' => $row['id'], 'newsdate' => $row['newsdate']);
}

/*Вывод стаей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, postdate FROM posts WHERE premoderation = "YES" AND zenpost = "NO" ORDER BY postdate DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода статей sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$posts[] =  array ('id' => $row['id'], 'postdate' => $row['postdate']);
}

/*Вывод промоушена*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, promotiondate FROM promotion WHERE premoderation = "YES" ORDER BY promotiondate DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода промоушена sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$promotions[] =  array ('id' => $row['id'], 'promotiondate' => $row['promotiondate']);
}

/*Вывод видео*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, videodate FROM video WHERE premoderation = "YES" ORDER BY videodate DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода промоушена sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$videos[] =  array ('id' => $row['id'], 'videodate' => $row['videodate']);
}

/*Вывод аккаунтов*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, regdate FROM author ORDER BY id DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода аккаунтов sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$authors[] =  array ('id' => $row['id'], 'regdate' => $row['regdate']);
}

/*Вывод блогов*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, date FROM blogs WHERE blogpremoderation = "YES" and indexing = "all" ORDER BY date DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода промоушена sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$blogs[] =  array ('id' => $row['id'], 'date' => $row['date']);
}

/*Вывод публикаций блогов*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, date FROM publication WHERE premoderation = "YES" and indexing = "all" ORDER BY date DESC';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода промоушена sitemap';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$pubs[] =  array ('id' => $row['id'], 'date' => $row['date']);
}

include 'sitemap.html.php';
exit();

