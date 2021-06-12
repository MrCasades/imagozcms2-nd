<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка содержимого записи*/
if (isset ($_GET['id']))
{
	$idComment = $_GET['id'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idcomment'] = $idComment;
	
	$select = 'SELECT comments.id, author.id AS idauthor, comment, commentdate, imghead, imgalt, authorname FROM comments 
				INNER JOIN author 
				ON idauthor = author.id 
				WHERE comments.id = ';
				
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = $select.$idComment;
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода записи ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$comments[] =  array ('id' => $row['id'], 'idauthor' => $row['idauthor'], 'text' => $row['comment'], 'date' => $row['commentdate'], 
							  'authorname' => $row['authorname'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt']);
	}	
	
	$title = 'Запись пользователя '. $row['authorname'].' от '.$row['commentdate'].' | imagoz.ru';//Данные тега <title>
	$headMain = 'Запись пользователя '. $row['authorname'].' от '.$row['commentdate'];
	$robots = 'noindex, follow';;
	$descr = '';
	
	/*Вывод ответов*/
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	try
	{
		$sql = 'SELECT subcomments.id AS subid, author.id AS subidauthor, subcomment, subcommentdate, authorname AS subauthorname FROM subcomments 
		INNER JOIN author 
		ON idauthor = author.id 
		WHERE idcomment = '.$idComment.' LIMIT '.$shift.' ,'.$onPage;//Внизу самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error table in mainpage' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$subcomments[] =  array ('subid' => $row['subid'], 'text' => $row['subcomment'], 'date' => $row['subcommentdate'], 'subauthorname' => $row['subauthorname'],
								'subidauthor' => $row['subidauthor']);
	}
	
	/*Определение количества статей*/
	$sql = "SELECT count(*) AS all_articles FROM subcomments WHERE idcomment = ".$idComment;
	$result = $pdo->query($sql);
	
	foreach ($result as $row)
	{
			$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'viewwallpost.html.php';
	exit();
}

/*Добавление комментария*/
if (isset ($_GET['addcomment']))
{
	$title = 'Добавить ответ | imagoz.ru';//Данные тега <title>
	$headMain = 'Добавить ответ';
	$robots = 'noindex, follow';
	$descr = 'Напишите ответ';
	$padgeTitle = 'Новый ответ';// Переменные для формы "Новая статья"
	$action = 'addform';	
	$text = '';
	$idauthor = '';
	$id = '';
	$button = 'Добавить ответ';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="../js/jquery-1.min.js"></script>
					 <script src="../js/bootstrap-markdown.js"></script>
					 <script src="../js/bootstrap.min.js"></script>';//добавить код JS
	
	if (isset($_SESSION['loggIn']))
	{
		$authorComment = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		
		include 'subcommentform.html.php';
		exit();
	}	
	
	else
	{
		$title = 'Ошибка добавления ответа';//Данные тега <title>
		$headMain = 'Ошибка добавления ответа';
		$robots = 'noindex, follow';
		$descr = '';
		$commentError = '<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы написать ответ!';//Вывод сообщения в случае невхода в систему
		
		include 'commentfail.html.php';
		exit();
	}	
}

/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT * FROM subcomments  
		WHERE id = :idsubcomment';//Вверху самое последнее значение
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора ответа' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();	
	
	$title = 'Редактирование ответа | imagoz.ru';//Данные тега <title>
	$headMain = 'Редактирование ответа';
	$robots = 'noindex, follow';
	$descr = 'Форма редактирования ответа';
	$action = 'editform';	
	$text = $row['subcomment'];
	$id = $row['id'];
	$button = 'Обновить ответ';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="../js/jquery-1.min.js"></script>
					 <script src="../js/bootstrap-markdown.js"></script>
					 <script src="../js/bootstrap.min.js"></script>';//добавить код JS
	
	include 'subcommentform.html.php';
	exit();
}
	
/*команда INSERT  - добавление комментария в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	$selectComment = 'SELECT id FROM author WHERE authorname = ';//запрос, возвращающий id
	$authorComment = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		
	/*Возвращение id автора*/
	try
	{
		$sql = $selectComment.'"'.$authorComment.'"';
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора id ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$authorID[] =  array ('idauthor' => $row['id']);
	}	
		
	$selectedAuthor = (int)$row['id'];//id автора комментария
		
	try
	{
		$sql = 'INSERT INTO subcomments SET 
			subcomment = :subcomment,	
			subcommentdate = SYSDATE(),
			idauthor = '.$selectedAuthor.','.
			'idcomment = '.$_SESSION['idcomment'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':subcomment', $_POST['subcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Обновление счётчика ответов*/
	try
	{
		$sql = 'UPDATE comments SET 
			subcommentcount = subcommentcount + 1
			WHERE id = '.$_SESSION['idcomment'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':comment', $_POST['comment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации comment'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: ../viewwallpost/?id='.$_SESSION['idcomment']);//перенаправление обратно в контроллер index.php
	exit();	
}
	
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE subcomments SET 
			subcomment = :subcomment
			WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':subcomment', $_POST['subcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации subcomment'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	header ('Location: ../viewwallpost/?id='.$_SESSION['idcomment']);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление комментария*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')	
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id FROM subcomments WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора id и заголовка newsblock : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление ответа';//Данные тега <title>
	$headMain = 'Удаление ответа';
	$robots = 'noindex, follow';
	$descr = '';
	$action = 'delete';
	$posttitle = 'Ответ';
	$id = $row['id'];
	$button = 'Удалить';
	
	include 'delete.html.php';
}
	
if (isset ($_GET['delete']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM subcomments WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Обновление счётчика ответов*/
	try
	{
		$sql = 'UPDATE comments SET 
			subcommentcount = subcommentcount - 1
			WHERE id = '.$_SESSION['idcomment'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':comment', $_POST['comment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации comment'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: ../viewwallpost/?id='.$_SESSION['idcomment']);//перенаправление обратно в контроллер index.php
	exit();
}	