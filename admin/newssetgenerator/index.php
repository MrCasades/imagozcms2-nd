<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

try
{
	$result = $pdo -> query ('SELECT id, categoryname FROM category');
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода category';
	include MAIN_FILE . '/includes/error.inc.php';
}
	
foreach ($result as $row)
{
	$categorys[] = array('id' => $row['id'], 'categoryname' => $row['categoryname']);
}

//$authorName = authorLogin($_SESSION['email'], $_SESSION['password']);//Имя автора

$title = 'Генератор новостного дайджеста';//Данные тега <title>
$headMain = 'Генератор новостного дайджеста';
$robots = 'noindex, nofollow';
$descr = '';
$scriptJScode = '<script src="script.js"></script>';//добавить код JS

include 'newssetgenerator.html.php';
exit();