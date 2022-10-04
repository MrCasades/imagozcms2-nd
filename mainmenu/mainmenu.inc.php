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
	$error = 'Ошибка выбора рубрик';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$categorysMM[] =  array ('id' => $row['id'], 'category' => $row['categoryname']);
}

include 'mainmenu.inc.html.php';