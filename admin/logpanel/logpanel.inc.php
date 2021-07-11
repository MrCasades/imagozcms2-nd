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
		$sql = 'SELECT count(unread) AS unreadcount FROM mainmessages WHERE unread = "YES" AND idto = :idto';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idto', $selectedAuthor);//отправка значения
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

	if(userRole('Автор') || userRole('Рекламодатель') || userRole('Администратор'))
	{
		try
		{
			$sql = 'SELECT score FROM author WHERE id = :id';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $selectedAuthor);//отправка значения
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
			
		$scoreLp = '<i class="fa fa-money" aria-hidden="true" title="Размер счёта"></i>: '.$row['score'];//размер счёта автора

		$payForms = '<br/>
						<form action = "//'.MAIN_URL.'/admin/payment/" method = "post">
							<strong>'.$scoreLp.' | </strong>
							<input type = "hidden" name = "id" value = "'.$selectedAuthor.'">
							<button name = "action" class="btn_2" value = "Вывести средства"><strong><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Вывести</strong></button> |
							<button name = "action" class="btn_2" value = "Пополнить счёт"><strong><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Пополнить</strong></button>
						</form>';
	}

	else
	{
		$scoreLp= '';
		$payForms = '';
	}

	/*Вывод ссылки на рабочую панель*/
	
	if (userRole('Автор'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель автора</strong></button></a> ';
	}
	elseif(userRole('Рекламодатель'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель рекламодателя</strong></button></a> ';
	}
	elseif(userRole('Администратор'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель Администратора</strong></button></a> ';
	}
	else
	{
		$panel='';
	}
}

else
{
	$_SESSION['email'] ='';
}

include 'logpanel.html.php';
