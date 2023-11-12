<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

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

if (isset ($_GET['action']) && $_GET['action'] == 'Настроить')
{
	$title = 'Настройки главной страницы | imagoz.ru';//Данные тега <title>
	$headMain = 'Настройки главной страницы';
	$robots = 'noindex, nofollow';
	$descr = 'Информация для желающих стать автором на портале imagoz.ru';

	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/pagesettings/mainpagesetting">Настройка главной страницы</a> ';//Для хлебных крошек

	/*Данные из формы и загрузка json*/

	$action = 'editform';
	$errorForm = '';
	$blockFolder = $_GET['blockfolder'];
	$button = "Обновить";

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/mainpage.json');
	$data = json_decode($json_object, true);
				
	include MAIN_FILE .'/pagesettings/setting.html.php';
	exit();	
}

if (isset($_GET['editform']))
{
	/*Сохранение настроек в файл json */
	$array = array(
		"title" => $_POST['title'],
		"headMain"=> $_POST['header'],
		"robots"=> $_POST['robots'],
		"descr"=> $_POST['descr'],
		"about"=> $_POST['about']
	);

	$json = json_encode($array, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/mainpage.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}