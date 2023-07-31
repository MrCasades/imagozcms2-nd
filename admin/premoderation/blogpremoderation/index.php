<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

$title = 'Премодерация блогов';//Данные тега <title>
$headMain = 'Блоги в премодерации';
$robots = 'noindex, nofollow';
$descr = 'Вданном разделе выводятся материалы для премодерации';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод новостей*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT blogs.id, title, upddate, authorname, email FROM blogs INNER JOIN author 
			ON idauthor = author.id WHERE blogpremoderation = "NO" LIMIT 20';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей в премодерации';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$blogs[] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'upddate' =>  $row['upddate'], 
						'authorname' =>  $row['authorname'], 'email' =>  $row['email']);
}

include 'blogpremoderation.html.php';
exit();