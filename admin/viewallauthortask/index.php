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

/*Загрузка сообщения об ошибке входа*/
if ((!userRole('Администратор')) && (!userRole('Автор')))
{	
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Вывод всех сообщений автора*/

/*возврат ID автора*/
$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
		
/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Команда SELECT*/
try
{
	$sql = 'SELECT task.id AS taskid, description, idcreator, author.id AS authorid, tasktitle, taskdate, authorname, tasktype.id AS tasktypeid, tasktypename, takingdate FROM author 
			INNER JOIN task ON idauthor = author.id 
			INNER JOIN tasktype ON idtasktype = tasktype.id 
			WHERE author.id = '.$selectedAuthor.' AND taskstatus = "YES" AND readystatus = "NO" ORDER BY task.id DESC' ;//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода заданий';			
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$tasks[] =  array ('id' => $row['taskid'], 'idauthor' => $row['authorid'], 'text' => $row['description'], 'tasktitle' =>  $row['tasktitle'],
						'taskdate' =>  $row['taskdate'], 'authorname' =>  $row['authorname'], 
						'tasktypename' =>  $row['tasktypename'], 'tasktypeid' => $row['tasktypeid'], 'takingdate' => $row['takingdate'], 'idcreator' => $row['idcreator']);
}	

/*Возврат имени автора для заголовка*/
if (isset($row['authorname'])) 
{
	$authorName = $row['authorname'];//имя автора для заголовка
}

else
{
	$authorName = '';
}

/*Выбор имени создателя задания*/
if (isset($tasks))
{
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT authorname AS creator FROM author WHERE id = '.$row['idcreator'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора имени создателя новости';			
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();

	$creator = $row['creator'];
}

$title = 'Список заданий автора '.$authorName.' | imagoz.ru';//Данные тега <title>
$headMain = 'Все задания автора '.$authorName;
$robots = 'noindex, nofollow';
$descr = 'В данном разделе размещаются список всех технических заданий';

include 'allauthortask.html.php';
exit();