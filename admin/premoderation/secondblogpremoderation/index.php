<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

$title = 'Повторная премодерация статей блогов';//Данные тега <title>
$headMain = 'Повторная премодерация статей блогов';
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
	$sql = 'SELECT publication.id, title, upddate, authorname, email FROM publication INNER JOIN author 
			ON idauthor = author.id WHERE secondpremoderation = "NO" LIMIT 20';//Вверху самое последнее значение
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
	$publications[] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'upddate' =>  $row['upddate'], 
						'authorname' =>  $row['authorname'], 'email' =>  $row['email']);
}

include 'secondblogpremoderation.html.php';
exit();