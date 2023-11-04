<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Вывод текста о сотрудничестве*/

$title = 'Настройки главной страницы | imagoz.ru';//Данные тега <title>
$headMain = 'Настройки главной страницы';
$robots = 'noindex, nofollow';
$descr = 'Информация для желающих стать автором на портале imagoz.ru';

$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/pagesettings/mainpagesetting">Настройка главной страницы</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include MAIN_FILE.'/admin/accessfail.html.php';
	exit();
}

$errorForm = '';
$button = "Обновить";

$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/mainpage.json');
$data = json_decode($json_object, true);

				
include MAIN_FILE .'/pagesettings/setting.html.php';
exit();	