<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

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
if ((!userRole('Администратор')) && (!userRole('Автор')))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Вывод ссылок на разделы администрирования списков*/
if (userRole('Администратор'))
{
	$addAuthor = '<a href="/admin/authorlist/">Редактировать список авторов</a>';
	$addCatigorys = '<a href="/admin/categorylist/">Редактировать рубрики</a>';
	$addMetas = '| <a href="/admin/metalist/" class="btn btn-primary-sm">Редактировать список тегов</a>';
}

else
{
	$addAuthor = '';
	$addCatigorys = '';
	$addMetas = '';
}

/*Добавление информации о статье*/
if (isset($_GET['preview']))//Если есть переменная add выводится форма
{
}