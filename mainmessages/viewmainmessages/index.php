<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
loggedIn();


if (!loggedIn())
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	include MAIN_FILE .'/admin/login.html.php';
	exit();
}

/*Вывод диалога*/
if (isset($_GET['id']))
{
	/*Возвращение id автора для вызова функции изменения пароля*/

	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	$toDialog = $_GET['id'];//id первого сообщения
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT mmess.mainmessage, mmess.id AS mainmessageid, mmess.mainmessagedate, mmess.imghead, authorfrom.authorname AS afr, authorfrom.id AS idfr,  authorto.id AS idt, authorto.authorname AS ato 
													FROM mainmessages AS mmess 
													INNER JOIN author AS authorfrom ON mmess.idfrom = authorfrom.id 
													INNER JOIN author AS authorto ON mmess.idto = authorto.id 		
		WHERE (idfrom = '.$selectedAuthor.' AND idto = '.$toDialog.') OR (idto = '.$selectedAuthor.' AND idfrom = '.$toDialog.') ORDER BY mainmessagedate';
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора сообщений';
		include MAIN_FILE . '/includes/error.inc.php';	
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$mainmessages[] =  array ('mainmessage' => $row['mainmessage'], 'idmess' => $row['mainmessageid'], 'mainmessagedate' => $row['mainmessagedate'], 'imghead' => $row['imghead'],
								 'authorfrom' => $row['afr'], 'authorto' => $row['ato'], 'idfrom' => $row['idfr'], 'idto' => $row['idt'],);
	}
	
	if ($row['ato'] != $selectedAuthor)
	{
		/*Обновить статус непрочитанных сообщений*/
		try
		{
			$sql = 'UPDATE mainmessages SET unread = "NO"		
			WHERE idto = '.$selectedAuthor.' AND idfrom = '.$toDialog;
			$result = $pdo->query($sql);
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка обновления статуса непрочитанных сообщений';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}

	/*Имя для заголовка диалога*/

	try
	{
		$sql = 'SELECT authorname FROM author WHERE id = '.$toDialog;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();

		$dialogAuthor = $row['authorname'];
	}
	
	catch (PDOException $e)
	{	
		$error = 'Ошибка добавления сообщения';
		include MAIN_FILE . '/includes/error.inc.php';	
	}

	$title = 'Диалог';//Данные тега <title>
	$headMain = 'Диалог c '.'<a href="../../account/?id='.$toDialog.'">'.$dialogAuthor.'</a>';
	$robots = 'noindex, nofollow';
	$descr = '';
	$text = '';
	$button = 'Ответить';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'viewmainmessages.html.php';
	exit();
}
