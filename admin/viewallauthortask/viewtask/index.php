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
	$select = 'SELECT task.id AS taskid, description, author.id AS authorid, tasktitle, taskdate, authorname, tasktype.id AS tasktypeid, tasktypename FROM task 
			   INNER JOIN author ON idcreator = author.id 
			   INNER JOIN tasktype ON idtasktype = tasktype.id  
			   WHERE taskstatus = "YES" AND task.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idTask;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода содержимого задания ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$tasks[] =  array ('id' => $row['taskid'], 'idauthor' => $row['authorid'], 'text' => $row['description'], 'tasktitle' =>  $row['tasktitle'],
							'taskdate' =>  $row['taskdate'], 'authorname' =>  $row['authorname'], 
							'tasktypename' =>  $row['tasktypename'], 'tasktypeid' => $row['tasktypeid']);
	}	

	$title = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;//Данные тега <title>
	$headMain = 'Техническое задание #'.$row['taskid'].' "'.$row['tasktitle'].'"' ;	
	$robots = 'noindex, nofollow';
	$descr = '';
	
	if ($row['tasktypename'] == 'Новость')
	{
		$performTask = '<form action = "../../../admin/addupdnews/?add" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$idTask.'">
									<input type = "submit" name = "action" class="btn_2" value = "Выполнить задание">
								</div>
							</form>';
	}
	
	elseif ($row['tasktypename'] == 'Статья')
	{
		$performTask = '<form action = "../../../admin/addupdpost/?add" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$idTask.'">
									<input type = "submit" name = "action" class="btn_2" value = "Выполнить задание">
								</div>
							</form>';
	}
	
	/*Отказаться от задания*/
	$refuse = '<form action = "../../../admin/viewalltask/taskstatus/" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$idTask.'">
									<input type = "submit" name = "action" class="btn_1" value = "Отказаться">
								</div>
							</form>';
	
	include 'task.html.php';
}
