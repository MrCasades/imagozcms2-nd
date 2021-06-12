<?php 
/*Вывод списка рубрик*/

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод рубрик*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT * FROM category';//Вверху самое последнее значение
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
	$categorys[] =  array ('id' => $row['id'], 'category' => $row['categoryname']);
}

/*Вывод ТОП-5 статей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, posttitle, viewcount, averagenumber FROM posts WHERE premoderation = "YES" ORDER BY averagenumber DESC LIMIT 5';//Вверху самое последнее значение
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
	$postsTOP[] =  array ('id' => $row['id'], 'posttitle' => $row['posttitle'], 'viewcount' => $row['viewcount'], 'averagenumber' => $row['averagenumber']);
}

include 'categorypanel.inc.html.php';