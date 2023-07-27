<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

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

/*Добавление информации о задании*/
if (isset ($_POST['action']) && $_POST['action'] == 'Создать блог')//Если есть переменная add выводится форма
{
	$errorForm = '';
	$title = 'Создать блог';//Данные тега <title>
	$headMain = 'Создать блог';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$blogtitle = '';
	$description = '';
	// $idtasktype = '';
	// $idrang = 1;
	// $id = '';
	$button = 'Создать блог';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'addupdblog.html.php';
	exit();
	
}

/*Обновление информации о статье*/
if (isset ($_POST['action']) && $_POST['action'] == 'Настройка')
{
	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_POST['id']);
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT 
					b.id as blogid
					,b.title
					,b.description
					,b.imghead
					,b.indexing
					,b.idauthor
					,a.authorname
				FROM blogs b
				INNER JOIN author a ON b.idauthor = a.id 
				WHERE b.id = :blogid';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':blogid', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода информации о блоге';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление блога';//Данные тега <title>
	$headMain = 'Обновление блога';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$blogtitle = $row['title'];
	$description = $row['description'];
	// $idtasktype = $row['idtasktype'];
	// $idrang = $row['idrang'];
	$id = $row['blogid'];
	$button = 'Обновить информацию';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'addupdblog.html.php';
	exit();
}

/*команда INSERT  - добавление в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма

{
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if ($_POST['description'] == '' || $_POST['blogtitle'] == '')
	{
		$error = 'Введите недостающую информацию';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$fileNameScript = 'hd-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScript = '/blog/headersimages/';//папка с изображениями для новости/статьи

	$fileNameHead = uploadImgHeadFull ($fileNameScript, $filePathScript);

	
	$fileNameScriptAva = 'ava-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScriptAva = '/blog/avatars/';//папка с изображениями для новости/статьи

	$fileNameAva = uploadImgHeadFull ($fileNameScriptAva, $filePathScriptAva, 'add', '', '', 'uploadavatar');
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'INSERT INTO blogs SET 
			title = :blogtitle,
			imghead = :imghead,
			avatar = :avatar,
			description = :description,		
			date = SYSDATE(),
			idauthor = :idauthor';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':blogtitle', $_POST['blogtitle']);//отправка значения
		$s -> bindValue(':imghead', $fileNameHead);//отправка значения
		$s -> bindValue(':avatar', $fileNameAva);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':idauthor', $selectedAuthor);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации о блоге';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	
	$title = 'Блог добавлен';//Данные тега <title>
	$headMain = 'Блог добавлен';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include 'blogsucc.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	if ($_POST['description'] == '' || $_POST['blogtitle'] == '')
	{
		$error = 'Введите недостающую информацию';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$fileNameScript = 'hd-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScript = '/blog/headersimages/';//папка с изображениями для новости/статьи

	$fileNameHead = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'blogs', $_POST['id']);

	$fileNameScriptAva = 'ava-'. time().rand(100, 999);//имя файла новости/статьи
	$filePathScriptAva = '/blog/avatars/';//папка с изображениями для новости/статьи

	$fileNameAva = uploadImgHeadFull ($fileNameScriptAva, $filePathScriptAva, 'upd', 'blogsAVA', $_POST['id'], 'uploadavatar');

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if ($_POST['description'] == '' || $_POST['blogtitle'] == '')
	{
		$error = 'Введите недостающую информацию';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'UPDATE blogs SET 
				title = :blogtitle,	
				imghead = :imghead,
				avatar = :avatar,
				description = :description,
				upddate = SYSDATE(),
				blogpremoderation = "NO"
				WHERE id = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['id']);//отправка значения
		$s -> bindValue(':imghead', $fileNameHead);//отправка значения
		$s -> bindValue(':avatar', $fileNameAva);//отправка значения
		$s -> bindValue(':blogtitle', $_POST['blogtitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$title = 'Блог обновлён';//Данные тега <title>
	$headMain = 'Блог обновлён';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	header ('Location: //'.MAIN_URL.'/blog/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'Удалить блог')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, title FROM blogs WHERE id = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id и заголовка blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление блога';//Данные тега <title>
	$headMain = 'Удаление блога';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['title'];
	$id = $row['id'];
	$button = 'Удалить';
	
	include '../../pubcommonfiles/delete.html.php';
}

if (isset ($_GET['delete']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM blogs WHERE id = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	try
	{
		$sql = 'DELETE FROM publication WHERE idblog = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации publication';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	