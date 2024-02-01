<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if ((!userRole('Администратор')) && (!userRole('Автор')))
{	
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Публикация статьи*/

if (isset ($_POST['action']) && $_POST['action'] == 'Взять задание')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, tasktitle FROM task WHERE id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора информации о задании';			
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Взять задание';//Данные тега <title>
	$headMain = 'Получение задания';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'taskyes';
	$taskYes = 'Вы хотите взять задание ';
	$tasktitle = $row['tasktitle'];
	$id = $row['id'];
	$button = 'Да!';
	
	include 'taskstatus.html.php';
}

if (isset ($_GET['taskyes']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Выбор статуса задания для предотвращения повторного взятия*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT taskstatus FROM task WHERE id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статуса задания';			
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$taskstatus = $row['taskstatus'];
	
	if ($taskstatus == 'YES')//если статус задания 'YES' значит его взял другой пользователь
	{
		$error = 'Данное задание взял другой пользователь. Попробуйте выбрать другое';			
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	else
	{
		/*Скрипт получения задания*/
		
		/*возврат ID автора*/
		$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));;//id автора
		
		/*Подключение к базе данных*/
		include MAIN_FILE . '/includes/db.inc.php';
		
		/*Получение значения счётчика заданий*/
		/*Команда SELECT*/
		try
		{
			$sql = 'SELECT taskcount FROM author WHERE id = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора информации числе взятых заданий автора';			
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		$taskcount = (int)$row['taskcount'];
		
		if ($taskcount > 4)
		{
			$error = 'Вы не можете взять более '.$taskcount.' заданий!';			
			include MAIN_FILE . '/includes/error.inc.php';
		}	
		
		else
		{
		
			try
			{
				$pdo->beginTransaction();//инициация транзакции
				
				/*Обновить статус задания*/
				$sql = 'UPDATE task SET taskstatus = "YES", 
									idauthor = '.$selectedAuthor.
									', takingdate = SYSDATE()
									WHERE id = :idtask';
				$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
				$s -> bindValue(':idtask', $_POST['id']);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
				
				/*Обновить счётчик заданий автора*/
				$sql = 'UPDATE author SET taskcount =  taskcount + 1 WHERE id = '.$selectedAuthor;
				$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
				
				$pdo->commit();//подтверждение транзакции
			}

			catch (PDOException $e)
			{
				$pdo->rollBack();//отмена транзакции

				$error = 'Ошибка взятия задания!';			
				include MAIN_FILE . '/includes/error.inc.php';
			}
		}
	}
	
	$title = 'Задание успешно взято!';//Данные тега <title>
	$headMain = 'Задание успешно взято!';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include 'tasksucc.html.php';
	exit();
}		