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
	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_POST['id']);

	// (int) $idBlog = $_POST['id'];

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT avatar FROM blogs WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $idBlog);//отправка значения
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
	(int) $idBlog = $_POST['id'];
	$button = 'Обновить аватар';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

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
	$filePathScriptAva = '/blog/avatars/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScriptAva, 'upd', 'blogsAVA', $_POST['id']);
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE blogs SET avatar = :filename WHERE id = :id';
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
	
	header ('Location: //'.MAIN_URL.'/blog/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}

/*Обновить аватар*/

if (isset ($_POST['action']) && $_POST['action'] === 'Обновить шапку')
{
	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_POST['id']);

	// (int) $idBlog = $_POST['id'];

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT imghead FROM blogs WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $idBlog);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора данных аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление шапки';//Данные тега <title>
	$headMain = 'Обновление шапки';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'updimg';
	$imgHead = $row['imghead'];
	(int) $idBlog = $_POST['id'];
	$button = 'Обновить шапку';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS

	$_GLOBALS['imghead'] = $row['imghead'];
	
	include 'updavatar.html.php';
	exit();
}

if (isset($_GET['updimg']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'hd-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScript = '/blog/headersimages/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'blogs', $_POST['id']);

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE blogs SET imghead = :filename WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':filename', $fileName);//отправка значения
		$s -> bindValue(':id', (int)$_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления шапки';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL.'/blog/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
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
		$sql = 'SELECT avatar FROM blogs WHERE id = :id';
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
	$filePathScriptAva = '/blog/avatars/';//папка с изображениями для новости/статьи
	unlink($delFile);//удаление 
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE blogs SET 
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
	
	header ('Location: //'.MAIN_URL.'/blog/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}