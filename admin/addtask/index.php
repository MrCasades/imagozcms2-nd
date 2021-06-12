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
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}


/*Добавление информации о задании*/
if (isset($_GET['add']))//Если есть переменная add выводится форма
{
	$errorForm = '';
	$title = 'Добавить новое задание';//Данные тега <title>
	$headMain = 'Добавить новое задание';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$tasktitle = '';
	$description = '';
	$idtasktype = '';
	$idrang = 1;
	$id = '';
	$button = 'Добавить задание';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	@session_start();//Открытие сессии для сохранения id автора
	
	$_SESSION['authorname'] = $authorPost;
	
	/*Вывод информации для формы добавления*/

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Список типов*/
	try
	{
		$result = $pdo -> query ('SELECT id, tasktypename FROM tasktype');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода tasktype '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$tasktypes_1[] = array('idtasktype' => $row['id'], 'tasktypename' => $row['tasktypename']);
	}
	
	/*Список рангов*/
	try
	{
		$result = $pdo -> query ('SELECT id, rangname FROM rang');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода rang '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$rangs_1[] = array('idrang' => $row['id'], 'rangname' => $row['rangname']);
	}
	
	include 'addtask.html.php';
	exit();
	
}

/*Обновление информации о статье*/
if (isset ($_POST['action']) && $_POST['action'] == 'Upd')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, description, tasktitle, idcreator, idtasktype, idrang FROM task WHERE id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора задания: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление задания';//Данные тега <title>
	$headMain = 'Обновление задания';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$tasktitle = $row['tasktitle'];
	$tasktitle = $row['tasktitle'];
	$description = $row['description'];
	$idtasktype = $row['idtasktype'];
	$idrang = $row['idrang'];
	$id = $row['id'];
	$button = 'Обновить информацию о задании';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM newsblock INNER JOIN author ON idauthor = author.id WHERE newsblock.id = '.$id);
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода author '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$authors_1[] = array('authorname' => $row['authorname']);
	}
	
	$authorPost = $row['authorname'];//возвращает имя автора
	
	/*Список рубрик*/
	try
	{
		$result = $pdo -> query ('SELECT id, tasktypename FROM tasktype');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода tasktype '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$tasktypes_1[] = array('idtasktype' => $row['id'], 'tasktypename' => $row['tasktypename']);
	}
	
	/*Список рангов*/
	try
	{
		$result = $pdo -> query ('SELECT id, rangname FROM rang');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода rang '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$rangs_1[] = array('idrang' => $row['id'], 'rangname' => $row['rangname']);
	}
	
	include 'addtask.html.php';
	exit();
}

/*команда INSERT  - добавление в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма

{
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if (($_POST['idtasktype'] == '') || ($_POST['description'] == '') || ($_POST['tasktitle'] == ''))
	{
		$title = 'В форме есть незаполненные поля!';//Данные тега <title>
		$headMain = 'В форме есть незаполненные поля!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Введите недостающую информацию';
		
		include 'error.html.php';
		exit();
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'INSERT INTO task SET 
			tasktitle = :tasktitle,
			description = :description,		
			taskdate = SYSDATE(),
			idcreator = '.$selectedAuthor.','.
			'idtasktype = :idtasktype,
			idrang = :idrang';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':tasktitle', $_POST['tasktitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':idtasktype', $_POST['idtasktype']);//отправка значения
		$s -> bindValue(':idrang', $_POST['idrang']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	
	$title = 'Задание добавлено';//Данные тега <title>
	$headMain = 'Задание добавлено';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include 'tasksucc.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if (($_POST['idtasktype'] == '') || ($_POST['description'] == '') || ($_POST['tasktitle'] == ''))
	{
		$title = 'В форме есть незаполненные поля!';//Данные тега <title>
		$headMain = 'В форме есть незаполненные поля!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Введите недостающую информацию';
		
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'UPDATE task SET 
				tasktitle = :tasktitle,	
				description = :description,
				idtasktype = :idtasktype,
				idrang = :idrang
				WHERE id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $_POST['id']);//отправка значения
		$s -> bindValue(':tasktitle', $_POST['tasktitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':idtasktype', $_POST['idtasktype']);//отправка значения
		$s -> bindValue(':idrang', $_POST['idrang']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации task'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')
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
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора id и заголовка task : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление задания';//Данные тега <title>
	$headMain = 'Удаление задания';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['tasktitle'];
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
		$sql = 'DELETE FROM task WHERE id = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idtask', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации newsblock '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	