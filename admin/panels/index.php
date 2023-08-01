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
if (!userRole('Администратор') && !userRole('Автор') && !userRole('Рекламодатель'))
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

$title = 'Управление публикациями';//Данные тега <title>
$headMain = 'Управление публикациями';
$robots = 'noindex, follow';
$descr = '';

$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора 

if (userRole('Администратор'))
{
	/*Подсчёт количества непрочитанных сообщений обратной связи*/
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = "SELECT count(*) AS unread FROM adminmail WHERE viewcount = 0 AND adminnews = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта сообщений';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$unread = $row['unread'];

	/*Подсчёт количества материалов в премодерации и заявки на выплату*/
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = "SELECT count(*) AS mypremodpost FROM posts WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodPosts = $row['mypremodpost'];//статьи в премодерации
		
		$sql = "SELECT count(*) AS mypremodnews FROM newsblock WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodNews = $row['mypremodnews'];//новости в премодерации
		
		$sql = "SELECT count(*) AS mypremodpromotion FROM promotion WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodPromotion = $row['mypremodpromotion'];//новости в премодерации

		$sql = "SELECT count(*) AS mypremodvideo FROM video WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodVideo = $row['mypremodvideo'];//новости в премодерации

		$sql = "SELECT count(*) AS mypremodpubs FROM publication WHERE premoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodPubs = $row['mypremodpubs'];//публикации блога в премодерации

		$sql = "SELECT count(*) AS mypremodpubsec FROM publication WHERE secondpremoderation = 'NO' AND refused = 'NO' AND draft = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodPubsSec = $row['mypremodpubsec'];//публикации блога в повторной премодерации

		$sql = "SELECT count(*) AS mypremodblogs FROM blogs WHERE blogpremoderation = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$premodBlogs = $row['mypremodblogs'];//блоги в премодерации
		
		$sql = "SELECT count(*) AS payments FROM payments WHERE paymentstatus = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$paymentsCount = $row['payments'];//новости в премодерации
		
		$pdo->commit();//подтверждение транзакции
	}

	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции

		$error = 'Ошибка подсчёта материалов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$allDraft = '';
	$allRefusedMP = '';
	$myrefusedPromotions = '';
	
}

elseif (userRole('Автор'))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	if (userRole('Супер-автор'))
	{
		/*Режим супер-автора*/
		try
		{
			$sql = 'SELECT pubtime FROM superuserpubtime WHERE idauthor = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора времени публикации для суперавтора';
			include MAIN_FILE . '/includes/error.inc.php';
		}
			
		$row = $s -> fetch();

		$pubtTime = $row['pubtime'];

		if ($pubtTime != '')
		{
			$timer = ($row['pubtime'] + 60 * 60) - time();//остаток до завершения 
			
			if ($timer <= 0)
			{
				$viewTimer = '<h3>Вы можете совершить публикацию!</h3>';
			}
			
			else
			{
				/*Конвертируем секунды в часы и минуты*/
				$hour = floor($timer/3600);
				$min  = floor(($timer/3600 - $hour) * 60);
				
				$viewTimer = '<h3>Вы сможете совершить следующую публикацию через '.$hour.' часов '.$min.' мин!</h3>';
			}
		}

		else
		{
			$viewTimer = '<h3>Вы можете совершить публикацию!</h3>';
		}
	}
	
	/*Счётчики*/

	/*Подсчёт количества заданий*/
	try
	{
		$sql = "SELECT count(*) AS mytasks FROM task WHERE taskstatus = 'YES' AND readystatus = 'NO' AND idauthor = ".$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта заданий';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$myTasks = $row['mytasks'];
	
	/*Подсчёт количества материалов в премодерации*/
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

	/*Подсчёт количества материалов в черновике*/
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = "SELECT count(*) AS newsdraft FROM newsblock WHERE draft = 'YES' AND idauthor = ".$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$newsDraft = $row['newsdraft'];// статьи в черновике
		
		$sql = "SELECT count(*) AS postdraft FROM posts WHERE draft = 'YES' AND idauthor = ".$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$postsDraft = $row['postdraft'];// новости в черновике
		$pdo->commit();//подтверждение транзакции
	}

	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции

		$error = 'Ошибка подсчёта материалов';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$allDraft = $newsDraft + $postsDraft;
	
	/*Подсчёт количества отклонённых материалов*/
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
		
	$allRefusedMP = $refusedPosts + $refusedNews;//общее количество
}

elseif (userRole('Рекламодатель'))
{
	/*Счётчики*/

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Подсчёт количества материалов в черновике*/
	try
	{
		$sql = "SELECT count(*) AS promotiondraft FROM promotion WHERE draft = 'YES' AND idauthor = ".$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$allDraft = $row['promotiondraft'];// статьи в черновике
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта материалов';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Подсчёт количества отклонённых материалов*/
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
		
	$allRefusedMP = $row['myrefusedpromotions'];//статьи в премодерации
}

include 'panels.html.php';
exit();