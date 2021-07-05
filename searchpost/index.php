<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Вывод информации для формы поиска*/

$title = 'Поиск публикаций | imagoz.ru';
$headMain = 'Поиск публикаций';
$robots = 'noindex, follow';
$descr = 'В данном разделе осуществляется поиск информации';
$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

try
{
	$result = $pdo -> query ('SELECT id, categoryname FROM category');
}

catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка вывода category '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}
	
foreach ($result as $row)
{
	$categorys[] = array('id' => $row['id'], 'categoryname' => $row['categoryname']);
}

include 'searchform.html.php';
exit();
	
	