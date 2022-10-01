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
		$error = 'Ошибка подсчёта сообщений';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$unreadCount = $row['unreadcount'];//счётчик непрочитанных сообщений

	try
	{
		$sql = 'SELECT avatar FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $selectedAuthor);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора аватара';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
		
	$avatarPB = $row['avatar'];

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
			$error = 'Ошибка вывода счёта';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();
			
		$scoreLp = '<i class="fa fa-money" aria-hidden="true" title="Размер счёта"></i>: '.$row['score'];//размер счёта автора

		$payForms = '
						<form class="profile-menu-payform" action = "//'.MAIN_URL.'/admin/payment/" method = "post">
							<strong>'.$scoreLp.'</strong>
							<input type = "hidden" name = "id" value = "'.$selectedAuthor.'">
							<br><button name = "action" value = "Вывести средства"><strong><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Вывести</strong></button>
							<br><button name = "action" value = "Пополнить счёт"><strong><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> Пополнить</strong></button>
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
		$panel = '<a href="//'.MAIN_URL.'/admin/panels"><i class="fa fa-cog" aria-hidden="true"></i> Панель автора</a> ';
	}
	elseif(userRole('Рекламодатель'))
	{
		$panel = '<a href="//'.MAIN_URL.'/admin/panels"><i class="fa fa-cog" aria-hidden="true"></i> Панель рекламодателя</a> ';
	}
	elseif(userRole('Администратор'))
	{
		$panel = '<a href="//'.MAIN_URL.'/admin/panels"><i class="fa fa-cog" aria-hidden="true"></i> Панель Администратора</a> ';
	}
	else
	{
		$panel='';
	}

	/*Подсчёт количества отклонённых материалов и материалов в премодерации*/
	if (userRole('Автор'))
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

			$error = 'Ошибка подсчёта материалов';
			include MAIN_FILE . '/includes/error.inc.php';
		}
			
		$allPosts ='<a href="//'.MAIN_URL.'/admin/authorpremoderation/#bottom"><i class="fa fa-copyright" aria-hidden="true" title="Материалы в премодерации"></i>: '.($premodPosts + $premodNews).'</a>';

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
			
			$error = 'Ошибка подсчёта материалов';
			include MAIN_FILE . '/includes/error.inc.php';
		}
			
		$allRefused = '<a href="//'.MAIN_URL.'/admin/refused/#bottom"><i class="fa fa-thumbs-down" aria-hidden="true" title="Отклонённые материалы"></i>: '.($refusedPosts + $refusedNews).'</a>';//общее количество


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
			$error = 'Ошибка подсчёта материалов';
			include MAIN_FILE . '/includes/error.inc.php';
		}
			
		$row = $s -> fetch();
			
		$allPosts = '<a href="//'.MAIN_URL.'/admin/authorpremoderation/#bottom"><i class="fa fa-copyright" aria-hidden="true" title="Материалы в премодерации"></i>: '.$row['mypremodpromotions'].'</a>';//статьи в премодерации

		try
		{
			$sql = "SELECT count(*) AS myrefusedpromotions FROM promotion WHERE refused = 'YES' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка подсчёта материалов';
			include MAIN_FILE . '/includes/error.inc.php';
		}
			
		$row = $s -> fetch();
			
		$allRefused = '<a href="//'.MAIN_URL.'/admin/refused/#bottom"><i class="fa fa-thumbs-down" aria-hidden="true" title="Отклонённые материалы"></i>: '.$row['myrefusedpromotions'].'</a>';//статьи в премодерации
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
