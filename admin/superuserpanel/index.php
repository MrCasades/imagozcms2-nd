<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Вывод текста о сотрудничестве*/

$title = 'Меню супер-автора | imagoz.ru';//Данные тега <title>
$headMain = 'Меню супер-автора';
$robots = 'noindex, nofollow';
$descr = '';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка сообщения об ошибке входа*/
if ((!userRole('Администратор')) && (!userRole('Супер-автор')))
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Вывод таймера до окончания паузы между публикациями*/
/*Команда SELECT*/

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

try
{
	$sql = 'SELECT pubtime FROM superuserpubtime WHERE idauthor = '.authorID($_SESSION['email'], $_SESSION['password']);
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка выбора информации о задании: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}
	
$row = $s -> fetch();

$pubtTime = $row['pubtime'];

if ($pubtTime != '')
{
	$timer = ($row['pubtime'] + 60 * 60 * 24 * 2) - time();//остаток до завершения 
	
	if ($timer <= 0)
	{
		$viewTimer = '<h3>Вы можете совершить публикацию!</h3>';
	}
	
	else
	{
		/*Конвертируем секунды в часы и минуты*/
		$hour = floor($timer/3600);
		$min  = floor(($timer/3600 - $hour) * 60);
		
		$viewTimer = '<h3>Вы сможете совершить следующую публикацию через '.$hour.' часов '.$min.' мин!</h3>';
	}
}

else
{
	$viewTimer = '<h3>Вы можете совершить публикацию!</h3>';
}

	
/*Текст о сотрудничестве*/

$superUserPanel = "<p align='center'><a href='../../admin/addupdpost/?add' class='btn btn-primary btn-sm'>Добавить статью</a> | 
	<a href='../../admin/addupdnews/?add' class='btn btn-primary btn-sm'>Добавить новость</a>";
	
include 'superuserpanel.html.php';
exit();	