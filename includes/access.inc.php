<?php

/*Функция loggedIn возвращает TRUE, если пользователь вошёл в систему, проверяет правильность логина-пароля, а также отменяет аутентификацию*/
function loggedIn()
{
	/*Обработка входа в систему*/
	if (isset ($_POST['action']) && $_POST['action'] == 'login')
	{
		/*Проверка отправки данных для входа*/
		if (!isset ($_POST['email']) || $_POST['email'] == '' || !isset ($_POST['password']) || $_POST['password'] == '')
		{
			$GLOBALS['loginError'] = 'Заполните оба поля';
			return FALSE;
		}
		
		$password = md5($_POST['password'] . 'fgtn');
		
		if (authorInDataBase($_POST['email'], $password))
		{
			session_start();
			$_SESSION['loggIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;
			return TRUE;
		}
		
		else
		{
			session_start();
			unset ($_SESSION['loggIn']);
			unset ($_SESSION['email']);
			unset ($_SESSION['password']);
			$GLOBALS['loginError'] = 'Указан неверный E-mail или пароль';
			return FALSE;
		}
	}
	
	/*Обработка выхода из системы*/
	if (isset ($_POST['action']) && $_POST['action'] == 'logout')
	{
		session_start();
		unset ($_SESSION['loggIn']);
		unset ($_SESSION['email']);
		unset ($_SESSION['password']);
		header ('Location: ' . $_POST['goto']);
		exit();
	}
	
	/*Проверка нахождения пользователя в системе*/
	if(!isset($_SESSION))
		session_start();
	
	if (isset($_SESSION['loggIn']))
	{
		return authorInDataBase ($_SESSION['email'], $_SESSION['password']);
	}
}

/*Функция поиска записи об авторе*/
function authorInDataBase ($email, $password)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT COUNT(*) FROM author
				WHERE email = :email AND password = :password';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':email', $email);//отправка значения
		$s -> bindValue(':password', $password);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка поиска автора: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s-> fetch();
	
	if ($row[0] > 0)
	{
		return TRUE;
	}
	
	else
	{
		return FALSE;
	}
}

/*Функция определяющая роль автора*/
function userRole($role)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT COUNT(*) FROM author 
		INNER JOIN authorrole ON author.id = idauthor
		INNER JOIN role ON idrole = role.id
		WHERE email = :email AND role.id = :idrole';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':email', $_SESSION['email']);//отправка значения
		$s -> bindValue(':idrole', $role);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка поиска роли автора: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s-> fetch();
	
	if ($row[0] > 0)
	{
		return TRUE;
	}
	
	else
	{
		return FALSE;
	}
}

/*Функция возвращающая имя автора*/
function authorLogin ($email, $password)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT authorname FROM author
				WHERE email = :email AND password = :password';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':email', $email);//отправка значения
		$s -> bindValue(':password', $password);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка поиска автора: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}

	$row = $s-> fetch();

	$authorName = $row['authorname'];
	
	return $authorName;
}

/*Функция возвращающая id Автора*/

function authorID ($email, $password)
{
	$authorName = authorLogin ($email, $password);
	
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT id FROM author
				WHERE authorname = '.' "'.$authorName.'"';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка поиска ID автора: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$authorID = $row['id'];
	
	return $authorID;
}

/*Отправка сообщений обратной связи*/
function toEmail_1($title, $message)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	$authorID = (int)(authorID($_SESSION['email'], $_SESSION['password']));
	
	/*Возврат email автора*/
	try
	{
		$s = $pdo -> query ('SELECT email FROM author WHERE id = '.$authorID);
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора email: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$email = $row['email'];
	
	$headers = 'Content-type: text/html; charset=utf-8' . "\r\n".
			   'From: Информация о публикации<admin@imagoz.ru>' . "\r\n" .
    		   'Reply-To: admin@imagoz.ru' . "\r\n" .
    		   'X-Mailer: PHP/' . phpversion();
	
	mail($email, $title, $message.'<br>Письмо сформировано автоматически, отвечать на него не нужно!', $headers);//отправка письма
}

/*Отправка сообщений обратной связи*/
function toEmail_2($title, $message, $idAuthor)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	/*Возврат email автора*/
	try
	{
		$s = $pdo -> query ('SELECT email FROM author WHERE id = '.$idAuthor);
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора email: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$email = $row['email'];
	
	$headers = 'Content-type: text/html; charset=utf-8' . "\r\n".
			   'From: Информация о публикации<admin@imagoz.ru>' . "\r\n" .
    		   'Reply-To: admin@imagoz.ru' . "\r\n" .
    		   'X-Mailer: PHP/' . phpversion();
	
	mail($email, $title, $message.'<br>Письмо сформировано автоматически, отвечать на него не нужно!', $headers);//отправка письма
}


function accessForWritingArticles()
{
	/*Определение нахождения пользователя в системе*/
	if (!loggedIn())
	{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		include '../login.html.php';
		exit();
	}

	/*Загрузка сообщения об ошибке входа*/
	if ((!userRole('Администратор')) && (!userRole('Автор')))
	{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Доступ запрещен';
		include '../accessfail.html.php';
		exit();
	}

	/*Ошибка доступа, если автор не взял задание  и он не супер-автор*/
	if ((userRole('Автор')) && (!isset ($_POST['id'])))
	{
		if (!userRole('Супер-автор'))
		{
			$title = 'Ошибка доступа';//Данные тега <title>
			$headMain = 'Ошибка доступа';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Сначала необходимо получить задание!';
			include '../accessfail.html.php';
			exit();
		}
		
		else
		{
			/*С рангом Супер-автор происходит проверка времени публикации последнего задания*/
			/*Подключение к базе данных*/
			include MAIN_FILE . '/includes/db.inc.php';
			
			try
			{
				$sql = 'SELECT pubtime FROM superuserpubtime WHERE idauthor = '.(int)(authorID($_SESSION['email'], $_SESSION['password']));
				$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}

			catch (PDOException $e)
			{
				$error = 'Ошибка выбора времени последней публикации ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
				include 'error.inc.php';
			}
		
			$row = $s -> fetch();
			
			$lastPubTime = $row['pubtime'];	
		}
	}

	if (empty ($lastPubTime)) $lastPubTime = '';//если переменная не объявлена

	/*Суточный лимит публикаций в качестве Супер-автора*/
	if ((userRole('Супер-автор')) && ($lastPubTime != '') && (time() < $lastPubTime + 60 * 60))
	{
			$title = 'Ошибка доступа';//Данные тега <title>
			$headMain = 'Ошибка доступа';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Можно делать только 1 публикацию в течении часа в качестве Супер-автора!';
			include '../accessfail.html.php';
			exit();
	}

	/*Вывод ссылок на разделы администрирования списков*/
	if (userRole('Администратор'))
	{
		$GLOBALS['addAuthor'] = '<a href="//'.MAIN_URL.'/admin/authorlist/">Редактировать список авторов</a>';
		$GLOBALS['addCatigorys'] = '<a href="//'.MAIN_URL.'/admin/categorylist/">Редактировать рубрики</a>';
		$GLOBALS['addMetas'] = '| <a href="//'.MAIN_URL.'/admin/metalist/" class="btn btn-primary-sm">Редактировать список тегов</a>';
	}

	else
	{
		$GLOBALS['addAuthor'] = '';
		$GLOBALS['addCatigorys'] = '';
		$GLOBALS['addMetas'] = '';
	}
}

/*Проверка бана пользователя*/
function checkBlockedAuthor($idAuthor)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT currtime, term FROM blockedauthor
				WHERE idauthor = :idauthor';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idauthor', $idAuthor);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка проверки бана' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}

	$row = $s -> fetch();

	if (!empty($row))
	{
		if ($row['term'] == 'alltime')
			return true;
		elseif (time() < $row['currtime'] + 60*60*24*(int)$row['term'])
			return true;
		else
			return false;
	}

	else
		return false;
}

/*Блокировка страницы*/ 
function blockedAuthorPage()
{

	$title = 'Страница заблокирована';//Данные тега <title>
	$headMain = 'Страница заблокирована';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Страница пользователя заблокирована за нарушения';
	include '../admin/accessfail.html.php';
	exit();
}