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

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'SELECT task.id AS taskid, description, author.id AS authorid, tasktitle, taskdate, authorname, task.idrang AS rangid, tasktype.id AS tasktypeid, rangname, tasktypename FROM task 
					INNER JOIN author ON idcreator = author.id 
					INNER JOIN tasktype ON idtasktype = tasktype.id  
					INNER JOIN rang ON task.idrang = rang.id
				WHERE task.id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $idTask);//отправка значения
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
		
	$taskRang = $row['rangid'];
	$title = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;//Данные тега <title>
	$headMain = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;	
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include 'task.html.php';
}
