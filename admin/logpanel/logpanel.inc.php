<?php 
/*Вывод панели после входа в систему*/

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка имени вошедшего пользователя и кнопки выхода из системы*/
if (isset($_SESSION['loggIn']))//если не выполнен вход в систему
{
	$authorInSystem = authorLogin ($_SESSION['email'], $_SESSION['password']);
	
	/*Возврат id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'SELECT count(unread) AS unreadcount FROM mainmessages WHERE unread = "YES" AND idto = :idto';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idto', $selectedAuthor);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка подсчёта сообщений ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	$unreadCount = $row['unreadcount'];//счётчик непрочитанных сообщений

	if(userRole('Автор') || userRole('Рекламодатель') || userRole('Администратор'))
	{
		try
		{
			$sql = 'SELECT score FROM author WHERE id = :id';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $selectedAuthor);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка подсчёта сообщений ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}

		$row = $s -> fetch();
			
		$scoreLp = '<i class="fa fa-money" aria-hidden="true" title="Размер счёта"></i>: '.$row['score'];//размер счёта автора

		$payForms = '<br/>
						<form action = "//'.MAIN_URL.'/admin/payment/" method = "post">
							<strong>'.$scoreLp.' | </strong>
							<input type = "hidden" name = "id" value = "'.$selectedAuthor.'">
							<button name = "action" class="btn_2" value = "Вывести средства"><strong><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Вывести</strong></button> |
							<button name = "action" class="btn_2" value = "Пополнить счёт"><strong><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Пополнить</strong></button>
						</form>';
	}

	else
	{
		$scoreLp= '';
		$payForms = '';
	}

	/*Вывод ссылки на рабочую панель*/
	
	if (userRole('Автор'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель автора</strong></button></a> ';
	}
	elseif(userRole('Рекламодатель'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель рекламодателя</strong></button></a> ';
	}
	elseif(userRole('Администратор'))
	{
		$panel = '| <a href="//'.MAIN_URL.'/admin/panels"><button type="button" class="btn_2"><strong><i class="fa fa-cog" aria-hidden="true"></i> Панель Администратора</strong></button></a> ';
	}
	else
	{
		$panel='';
	}

	/*Подсчёт количества отклонённых материалов и материалов в премодерации*/
	if (userRole('Автор') || userRole('Администратор'))
	{
		try
		{
			$pdo->beginTransaction();//инициация транзакции
			
			$sql = "SELECT count(*) AS mypremodpost FROM posts WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$row = $s -> fetch();
			
			$premodPosts = $row['mypremodpost'];//статьи в премодерации
			
			$sql = "SELECT count(*) AS mypremodnews FROM newsblock WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$row = $s -> fetch();
			
			$premodNews = $row['mypremodnews'];//новости в премодерации
			
			$pdo->commit();//подтверждение транзакции
		}

		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции
			
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка подсчёта материалов ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
			
		$allPosts = $premodPosts + $premodNews;//общее количество
		$allPosts ='<i class="fa fa-copyright" aria-hidden="true"></i>: '.$allPosts;

		try
		{
			$pdo->beginTransaction();//инициация транзакции
			
			$sql = "SELECT count(*) AS myrefusedpost FROM posts WHERE refused = 'YES' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$row = $s -> fetch();
			
			$refusedPosts = $row['myrefusedpost'];//отклонённые статьи
			
			$sql = "SELECT count(*) AS myrefusednews FROM newsblock WHERE refused = 'YES' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$row = $s -> fetch();
			
			$refusedNews = $row['myrefusednews'];//отклонённые новости
			
			$pdo->commit();//подтверждение транзакции
		}

		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции
			
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка подсчёта материалов ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
			
		$allRefused = '<i class="fa fa-thumbs-down" aria-hidden="true"></i>: '.($refusedPosts + $refusedNews);//общее количество


	}

	elseif(userRole('Рекламодатель'))
	{
		try
		{
			$sql = "SELECT count(*) AS mypremodpromotions FROM promotion WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка подсчёта материалов ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
			
		$row = $s -> fetch();
			
		$allPosts = '<i class="fa fa-thumbs-down" aria-hidden="true"></i>: '.$row['mypremodpromotions'];//статьи в премодерации

		try
		{
			$sql = "SELECT count(*) AS myrefusedpromotions FROM promotion WHERE refused = 'YES' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка подсчёта материалов ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
			
		$row = $s -> fetch();
			
		$allRefused = '<i class="fa fa-thumbs-down" aria-hidden="true"></i>: '.$row['myrefusedpromotions'];//статьи в премодерации
	}

	else
	{
		$allPosts = '';
		$allRefused = '';
	}
}

else
{
	$_SESSION['email'] ='';
}

include 'logpanel.html.php';
