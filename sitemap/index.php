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
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка выбора рубрик ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
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
	$newsInSM[] =  array ('id' => $row['id'], 'newstitle' => $row['newstitle']);
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
	$postsSM[] =  array ('id' => $row['id'], 'posttitle' => $row['posttitle']);
}

include 'sitemap.html.php';
exit();	
