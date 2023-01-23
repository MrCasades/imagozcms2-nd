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

/*Обновить аватар*/

if (isset ($_POST['action']) && $_POST['action'] === 'Обновить аватар')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT avatar FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора данных аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление аватара';//Данные тега <title>
	$headMain = 'Обновление аватара';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'updavatar';
	$avatar = $row['avatar'];
	$idAuthor = $_POST['id'];
	$button = 'Обновить аватар';
	$errorForm = '';

	$_GLOBALS['avatar'] = $row['avatar'];
	
	include 'updavatar.html.php';
	exit();
}

/*UPDATE - обновление аватара*/

if (isset($_GET['updavatar']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'ava-'. time();//имя файла новости/статьи
	$filePathScript = '/avatars/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'author', $_POST['id']);

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE author SET avatar = :filename WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':filename', $fileName);//отправка значения
		$s -> bindValue(':id', (int)$_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL.'/account/setaccount/');//перенаправление обратно в контроллер index.php
	exit();
}

/*Удаление аватара*/
if (isset ($_POST['action']) && $_POST['action'] === 'Удалить аватар')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT avatar FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', (int)$_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	if ($row['avatar'] == "")
	{
		$title = 'Удаление аватара';//Данные тега <title>
		$headMain = 'Удаление аватара';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Нельзя удалить аватар по умолчанию!';
	
		include 'error.html.php';
	}
	
	else
	{
		
		$title = 'Удаление аватара';//Данные тега <title>
		$headMain = 'Удаление аватара';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'delava';
		$posttitle = 'Аватар';
		$button = 'Удалить';
		$id = (int)$_POST['id'];
		
		$_GLOBALS['avatar'] = $row['avatar'];
	
		include 'delete.html.php';
	}
}

if (isset ($_GET['delava']))
{
	
	/*Удаление аватара*/
	$fileName = $avatar;//из $_GLOBALS['avatar'] 
	$delFile = MAIN_FILE . '/avatars/'.$fileName;//путь к файлу для удаления
	unlink($delFile);//удаление 
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE author SET 
			avatar = "" WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', (int)$_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL.'/account/setaccount/');//перенаправление обратно в контроллер index.php
	exit();
}