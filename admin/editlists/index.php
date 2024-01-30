<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (!loggedIn())
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

$title = 'Редактирование списков';//Данные тега <title>
$headMain = 'Редактирование списков';
$robots = 'noindex, nofollow';
$descr = 'Редактирование списков';
		
include 'editlists.html.php';
exit();	