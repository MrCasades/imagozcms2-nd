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
	$title = 'Настройки страницы | imagoz.ru';//Данные тега <title>
	$headMain = 'Настройки страницы';
	$robots = 'noindex, nofollow';
	$descr = 'Настройки страницы';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/admin/pagesettings/?blockfolder='.$_GET['blockfolder'].'&action=Настроить">Настройка страницы</a> ';//Для хлебных крошек

	/*Данные из формы и загрузка json*/

	$action = 'editform';
	$errorForm = '';
	$blockFolder = $_GET['blockfolder'];
	$button = "Обновить";

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/'.$blockFolder.'.json');
	$data = json_decode($json_object, true);
				
	include 'setting.html.php';
	exit();	
}

if (isset($_GET['editform']))
{
	/*Сохранение настроек в файл json */
	$array = array(
		"title" => $_POST['title'],
		"headMain"=> $_POST['header'],
		"robots"=> $_POST['robots'],
		"descr"=> $_POST['descr']
	);

	if (!empty($_POST['about']))
		$array["about"] = $_POST['about'];

	if (!empty($_POST['bread1']))
		$array["breadPart1"] = $_POST['bread1'];

	if (!empty($_POST['bread2']))
		$array["breadPart2"] = $_POST['bread2'];

	if (!empty($_POST['bread3']))
		$array["breadPart3"] = $_POST['bread3'];

	if ($_POST['blockfolder'] == 'mainpage')
	{
		if (!empty($_POST['newsblock']))
		{
			$array["newsblock"] = "on";
		}

		else
		{
			$array["newsblock"] = "off";
		}

		if (!empty($_POST['recommendations']))
		{
			$array["recommendations"] = "on";
		}

		else
		{
			$array["recommendations"] = "off";
		}

		if (!empty($_POST['video']))
		{
			$array["video"] = "on";
		}

		else
		{
			$array["video"] = "off";
		}

		if (!empty($_POST['blogpubs']))
		{
			$array["blogpubs"] = "on";
		}

		else
		{
			$array["blogpubs"] = "off";
		}

		if (!empty($_POST['promotion']))
		{
			$array["promotion"] = "on";
		}

		else
		{
			$array["promotion"] = "off";
		}

		if (!empty($_POST['posts']))
		{
			$array["posts"] = "on";
		}

		else
		{
			$array["posts"] = "off";
		}

		if (!empty($_POST['viewabout']))
		{
			$array["viewabout"] = "on";
		}

		else
		{
			$array["viewabout"] = "off";
		}

		if (!empty($_POST['shopcomponent']))
		{
			$array["shopcomponent"] = "on";
		}

		else
		{
			$array["shopcomponent"] = "off";
		}

		if (!empty($_POST['refday']))
		{
			$array["refday"] = "on";
		}

		else
		{
			$array["refday"] = "off";
		}

		/*Боковая панель */

		if (!empty($_POST['mp_difflinks']))
		{
			$array["mp_difflinks"] = "on";
		}

		else
		{
			$array["mp_difflinks"] = "off";
		}

		if (!empty($_POST['right_side']))
		{
			$array["right_side"] = "on";
		}

		else
		{
			$array["right_side"] = "off";
		}
	}

		
	$json = json_encode($array, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/'.$_POST['blockfolder'].'.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}


/*Общие настройки сайта, шапки и подвала */
if (isset ($_GET['common_action']) && $_GET['common_action'] == 'Общие настройки')
{
	$title = 'Настройки сайта';//Данные тега <title>
	$headMain = 'Настройки сайта';
	$robots = 'noindex, nofollow';
	$descr = 'Настройки сайта';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/admin/pagesettings">Настройка страницы</a> ';//Для хлебных крошек

	/*Данные из формы и загрузка json*/

	$action = 'editform_common';
	$errorForm = '';
	//$blockFolder = $_GET['blockfolder'];
	$button = "Обновить";

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/header.json');
	$data = json_decode($json_object, true);
				
	include 'commonsetting.html.php';
	exit();	
}

if (isset($_GET['editform_common']))
{
	/*Сохранение настроек в файл json */
	$array = array();

	if (!empty($_POST['difflinks']))
	{
		$array["difflinks"] = "on";
	}

	else
	{
		$array["difflinks"] = "off";
	}

	if (!empty($_POST['mainmenu']))
	{
		$array["mainmenu"] = "on";
	}

	else
	{
		$array["mainmenu"] = "off";
	}

	if (!empty($_POST['mainmenu_foot']))
	{
		$array["mainmenu_foot"] = "on";
	}

	else
	{
		$array["difflinks_foot"] = "off";
	}

	if (!empty($_POST['difflinks_foot']))
	{
		$array["difflinks_foot"] = "on";
	}

	else
	{
		$array["difflinks_foot"] = "off";
	}

	if (!empty($_POST['difflinks_foot_cont']))
		$array["difflinks_foot_cont"] = $_POST['difflinks_foot_cont'];
	
	$json = json_encode($array, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/header.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}