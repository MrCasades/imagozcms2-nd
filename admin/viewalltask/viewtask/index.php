<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
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

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	$idTask = $_GET['id'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idtask'] = $idTask;
	$select = 'SELECT task.id AS taskid, description, author.id AS authorid, tasktitle, taskdate, authorname, task.idrang AS rangid, tasktype.id AS tasktypeid, rangname, tasktypename FROM task 
			   INNER JOIN author ON idcreator = author.id 
			   INNER JOIN tasktype ON idtasktype = tasktype.id  
			   INNER JOIN rang ON task.idrang = rang.id
			   WHERE taskstatus = "NO" AND task.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idTask;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода содержимого задания';			
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
		
	$taskId = $row['taskid'];
	$authorId = $row['authorid'];
	$text = $row['description'];
	$date = $row['taskdate'];
	$nameAuthor = $row['authorname'];
	$taskTitle = $row['tasktitle'];
	$tasktypeName = $row['tasktypename'];
	$tasktypeId = $row['tasktypeid'];
	$taskRangName = $row['rangname'];
	$taskRang = $row['rangid'];

	$title = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;//Данные тега <title>
	$headMain = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;	
	$robots = 'noindex, nofollow';
	$descr = '';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Выбор id ранга автора*/
	try
	{
		$sql = 'SELECT idrang FROM author WHERE id = '.(int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id ранга автора';			
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$authorRang = $row['idrang'];
	
	/*Вывод кнопок "Обновить" | "Удалить" | "Опубликовать"*/
	
	if ((isset($_SESSION['loggIn'])) && (userRole('Администратор')))
	{
		$delAndUpd = "<form action = '../../../admin/addtask/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idtask']."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_2'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_1'>
					  </form>";
	}	
	
	else
	{
		$delAndUpd = '';
	}
	
	if ((userRole('Автор')) || (userRole('Администратор')))
	{
		if ($authorRang >= $taskRang)
		{
			$changeTaskStatus = "<form action = '../../../admin/viewalltask/taskstatus/' method = 'post'>
									<input type = 'hidden' name = 'id' value = '".$_SESSION['idtask']."'>
									<input type = 'submit' name = 'action' value = 'Взять задание' class='btn_1'>
									<a href='#' onclick='history.back();'><button type='button' class='btn_2'>Назад</button></a>
								 </form>";	
		}
		
		else
		{
			$changeTaskStatus = "<strong>Вы не можете взять это задание, так как Ваш ранг ниже необходимого!</strong>";
		}
	}
	
	include 'task.html.php';
}
