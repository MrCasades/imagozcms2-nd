<?php

/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Обновление информации о статье*/
if (isset ($_POST['action']) && $_POST['action'] == 'Upd')
{

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, text, title, imgalt, description, authorname FROM newsset WHERE id = :idset';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idset', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора дайджеста';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление дайджеста';//Данные тега <title>
	$headMain = 'Обновление дайджеста';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$text = $row['text'];
	$articletitle = $row['title'];
	$description = $row['description'];
	$imgalt = $row['imgalt'];
	$id = $row['id'];
    $authorPost = $row['authorname'];//возвращает имя автора
	$button = 'Обновить информацию о дайджесте';
	$errorForm = '';
	$scriptJScode = '<script src="../commonfiles/addarticlescripts.js"></script>';//добавить код JS

	include 'form.html.php';
	exit();
}

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time();//имя файла новости/статьи
	$filePathScript = '/images/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'newsset', $_POST['id']);
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'UPDATE newsset SET 
					text = :text,
					title = :articletitle,	
					description = :description,
					imgalt = :imgalt,	
					imghead = :imghead
				WHERE id = :idset';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idset', $_POST['id']);//отправка значения
		$s -> bindValue(':text', $_POST['articletext']);//отправка значения
		$s -> bindValue(':articletitle', $_POST['articletitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации newsset';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$idpost_ind = $_POST['id'];//id материала

	header ('Location: //'.MAIN_URL.'/viewnewsset/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, title, imghead FROM newsset WHERE id = :idset';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idset', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id и заголовка newsset';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление дайджеста';//Данные тега <title>
	$headMain = 'Удаление дайджеста';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['title'];
	$id = $row['id'];
	$button = 'Удалить';
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	
	include '../commonfiles/delete.html.php';
}

if (isset ($_GET['delete']))
{
	/*Удаление изображения заголовка*/
	$fileName = $_SESSION['imghead'];
	$delFile = MAIN_FILE . '/images/'.$fileName;//путь к файлу для удаления
	unlink($delFile);//удаление файла
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM newsset WHERE id = :idset';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idset', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации newsset';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	