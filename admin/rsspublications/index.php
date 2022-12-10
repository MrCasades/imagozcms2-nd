<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$error = 'Доступ запрещён';
	include MAIN_FILE . '/includes/error.inc.php';
}

$title = 'Обновление rss-лент';//Данные тега <title>
$headMain = 'Обновление rss-лент';
$robots = 'noindex, nofollow';
$descr = 'Обновление rss-лент';
$scriptJScode = '<script src="script.js"></script>';//добавить код JS
		
include 'rsspublications.html.php';
exit();	