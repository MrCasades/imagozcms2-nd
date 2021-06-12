<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

$title = 'Обновление среднего рейтинга';//Данные тега <title>
$headMain = 'Обновление среднего рейтинга';
$robots = 'noindex, nofollow';
$descr = '';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
if (!loggedIn())
{
	include '//'.MAIN_URL.'/login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '//'.MAIN_URL.'/accessfail.html.php';
	exit();
}

/*Вывод списка авторов, редакторов и администраторов портала*/

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Формирование списка авторов*/
	
try
{
	$result = $pdo->query('SELECT author.id AS authorid, authorname, countposts, rating FROM role 
						  INNER JOIN authorrole ON role.id = idrole
				          INNER JOIN author ON idauthor = author.id
						  WHERE (role.id = "Автор" OR role.id = "Администратор") AND countposts > 0');
}
	
catch (PDOException $e)
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка формирования списка ролей '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}
	
foreach ($result as $row)
{
	$authors[] = array('id' => $row['authorid'], 'authorname' => $row['authorname'], 'countposts' => $row['countposts'],
					    'rating' => $row['rating']);
	
	//$authorID[] = (int) $row['authorid'];
	
	//$countPosts[] = (int) $row['countposts'];
}

//$authorID[] = $row['authorid'];//все id автора
	
include 'authorrating.html.php';

/*Обновить рейтинг*/
if (isset ($_GET['add']))
{
	$authorID = $_POST['authorid'];
	$countPosts = $_POST['countposts'];
	$rating = $_POST['points'];
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		/*Обновить счёт автора и счётчик статей*/
		$sql = 'UPDATE author 
				SET rating = '. (int)$countPosts.  '*'. (int)$rating.' WHERE id = '.(int)$authorID;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		/*Обновить оценку новостей*/
		$sql = 'UPDATE newsblock 
				SET articlerating = '. (int)$rating.' WHERE idauthor = '.(int)$authorID;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		/*Обновить оценку статей*/
		$sql = 'UPDATE posts 
				SET articlerating = '. (int)$rating.' WHERE idauthor = '.(int)$authorID;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$pdo->commit();//подтверждение транзакции	
	}
		
	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка транзакции при обновлении рейтинга'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
}

header ('Location: ..');//перенаправление обратно в контроллер index.php
exit();