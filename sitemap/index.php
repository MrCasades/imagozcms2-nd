<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

$title = 'Катра сайта imagoz.ru';//Данные тега <title>
$headMain = 'Катра сайта';
$robots = 'all';
$descr = 'Катра сайта imagoz.ru - ключ ко всем материалам портала!';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Выбор материалов из базы данных*/

/*Вывод рубрик*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT * FROM category';
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора рубрик';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$categorysSM[] =  array ('id' => $row['id'], 'category' => $row['categoryname']);
}

/*Вывод всех новостей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, newstitle FROM newsblock WHERE premoderation = "YES"';
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
	$newsInSM[] =  array ('id' => $row['id'], 'newstitle' => $row['newstitle']);
}

/*Вывод всех промоушена*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, promotiontitle FROM promotion WHERE premoderation = "YES"';
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
	$promotionsSM[] =  array ('id' => $row['id'], 'promotiontitle' => $row['promotiontitle']);
}

/*Вывод всех статей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, posttitle FROM posts WHERE premoderation = "YES"';
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
	$postsSM[] =  array ('id' => $row['id'], 'posttitle' => $row['posttitle']);
}

/*Вывод всех видео*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, videotitle FROM video WHERE premoderation = "YES"';
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
	$videossSM[] =  array ('id' => $row['id'], 'videotitle' => $row['videotitle']);
}

include 'sitemap.html.php';
exit();	
