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
	$categorysMM[] =  array ('id' => $row['id'], 'category' => $row['categoryname']);
}

include 'mainmenu.inc.html.php';