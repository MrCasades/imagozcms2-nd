<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

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

/*Обновить аватар*/

if (isset ($_GET['main']))
{
	$title = 'Обновление логотипа';//Данные тега <title>
	$headMain = 'Обновление логотипа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'updlogo';
	//$avatar = $row['avatar'];
	$button = 'Обновить логотип';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	//$_GLOBALS['avatar'] = $row['avatar'];
	
	include 'updlogo.html.php';
	exit();
}

/*UPDATE - обновление аватара*/

if (isset($_GET['updlogo']))//Если есть переменная editform выводится форма
{
	/*Получение данных логотипа */

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/logo.json');
	$dataLogo = json_decode($json_object, true);

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'logo-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScript = '/decoration/';//папка с изображениями для новости/статьи

	$fileName = uploadSiteLogo ($fileNameScript, $filePathScript);

	/*Сохранение в json */
	$dataLogo["logomain"] = $fileName;

	$json = json_encode($dataLogo, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/logo.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}

/*Обновление адаптивного лого */

if (isset ($_GET['adpt']))
{
	
	$title = 'Обновление логотипа';//Данные тега <title>
	$headMain = 'Обновление логотипа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'updlogoadpt';
	//$avatar = $row['avatar'];
	$button = 'Обновить логотип';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	//$_GLOBALS['avatar'] = $row['avatar'];
	
	include 'updlogo.html.php';
	exit();
}

/*UPDATE - обновление аватара*/

if (isset($_GET['updlogoadpt']))//Если есть переменная editform выводится форма
{
	/*Получение данных логотипа */

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/logo.json');
	$dataLogo = json_decode($json_object, true);

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'logo-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScript = '/decoration/';//папка с изображениями для новости/статьи

	$fileName = uploadSiteLogo ($fileNameScript, $filePathScript);

	/*Сохранение в json */
	$dataLogo["logoadpt"] = $fileName;

	$json = json_encode($dataLogo, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/logo.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}

/*Обновить описание лого */

if (isset ($_GET['descr']))
{
	
	$title = 'Обновление оисания лого';//Данные тега <title>
	$headMain = 'Обновление оисания лого';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'upddescr';
	//$avatar = $row['avatar'];
	$button = 'Обновить описание';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	//$_GLOBALS['avatar'] = $row['avatar'];
	
	include 'upddescr.html.php';
	exit();
}

/*UPDATE - обновление описания*/

if (isset($_GET['upddescr']))//Если есть переменная editform выводится форма
{
	/*Получение данных логотипа */

	$json_object = file_get_contents(MAIN_FILE.'/includes/blocksettings/logo.json');
	$dataLogo = json_decode($json_object, true);

	/*Сохранение в json */
	$dataLogo["altTxt"] = $_POST['altTxt'];
	$dataLogo["titleLogo"] = $_POST['titleLogo'];

	$json = json_encode($dataLogo, JSON_UNESCAPED_UNICODE);

	$jsonPath = MAIN_FILE .'/includes/blocksettings/logo.json';

	file_put_contents($jsonPath, $json);

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}