<?php 
/*Вывод панели после входа в систему*/

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка имени вошедшего пользователя и кнопки выхода из системы*/
if (isset($_SESSION['loggIn']))//если не выполнен вход в систему
{
	$authorInSystem = authorLogin ($_SESSION['email'], $_SESSION['password']);
	
	/*Возврат id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'SELECT count(unread) AS unreadcount FROM mainmessages WHERE unread = "YES" AND idto = '.$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка подсчёта сообщений ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	$unreadCount = $row['unreadcount'];//счётчик непрочитанных сообщений
	
	// $logPanel = '<form action = " " method = "post">
	// 				<strong>Профиль:</strong> <a href="//'.MAIN_URL.'/account/?id='.$selectedAuthor.'"><strong>'.$_POST['author'].'</strong></a> | <a href="//'.MAIN_URL.'/mainmessages/#bottom" class="btn btn-info btn-sm"><strong>СООБЩЕНИЯ <span id = "countcolor">'.$unreadCount.'</span></strong></a>
	// 				<input type = "hidden" name = "action" value = "logout">
	// 				<input type = "hidden" name = "goto" value = "//'.MAIN_URL.'">
	// 				<input class="btn btn-primary btn-sm" type="submit" value="Exit">
	// 		     </form>';
}

else
{
	$_SESSION['email'] ='';
}

include 'logpanel.html.php';
