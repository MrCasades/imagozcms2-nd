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

if (isset ($_POST['action']) && $_POST['action'] == 'Премодерация NO')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE blogs SET 
					blogpremoderation = "YES"
				WHERE id = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL.'/blog/?id='.$_POST['idblog']);//перенаправление обратно в контроллер index.php
	exit();
}	

if (isset ($_POST['action']) && $_POST['action'] == 'Премодерация YES')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE blogs SET 
					blogpremoderation = "NO"
				WHERE id = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}