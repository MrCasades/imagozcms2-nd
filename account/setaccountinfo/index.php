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

/*Обновление информации профиля*/

/*Обновление информации о профиле*/
if (isset ($_POST['action']) && $_POST['action'] === 'Обновить информацию профиля')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, authorname, email, www, accountinfo FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора информации аккаунта';
		include MAIN_FILE . '/includes/error.inc.php';
	}	

	$row = $s -> fetch();
	
	$title = 'Редактирование профиля';//Данные тега <title>
	$headMain = 'Редактировать профиль пользователя '.$row['authorname'];
	$robots = 'noindex, nofollow';
	$descr = '';
	$padgeTitle = 'Редактировать данные пользователя';// Переменные для формы "Новый автор"
	$action = 'updacc';
	$authorname = $row['authorname'];
	$email = $row['email'];
	$www = $row['www'];
	$accountinfo = $row['accountinfo'];
	$idauthor = $row['id'];
	$button = 'Обновить информацию об авторе';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'form.html.php';
	exit();
	
}

	/*Команда UPDATE*/
if (isset ($_GET['updacc']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE author SET www = :www, accountinfo = :accountinfo WHERE id = :id';// псевдопеременная получающая значение из формы
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> bindValue(':www', $_POST['www']);//отправка значения
		$s -> bindValue(':accountinfo', $_POST['accountinfo']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации аккаунта';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: ..'.'/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}
