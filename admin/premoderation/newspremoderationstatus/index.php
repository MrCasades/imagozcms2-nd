<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

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

/*Публикация статьи*/

if (isset ($_POST['action']) && $_POST['action'] == 'Опубликовать')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT newsblock.id, newstitle, pricetext, authorname FROM newsblock 
				INNER JOIN author ON author.id = idauthor WHERE newsblock.id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора данных статьи: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Публикация новости';//Данные тега <title>
	$headMain = 'Публикация новости';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'premodyes';
	$premodYes = 'Опубликовать материал ';
	$posttitle = $row['newstitle'];
	$pricetext = $row['pricetext'];
	$author = $row['authorname'];
	$editorcomment = '';
	$id = $row['id'];
	$button = 'Опубликовать';
	$scriptJScode = '<script src="script.js"></script>';
	
	include 'premodstatus.html.php';
}

if (isset ($_GET['premodyes']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Скрипт пополнения счёта автора и изменение ранга*/
	/*Выбор цены  и id автора*/
	try
	{
		$sql = 'SELECT pricetext, idauthor, paymentstatus FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора цены новости: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$price = $row['pricetext'];
	$idAuthor = (int) $row['idauthor'];
	$paymentStatus = $row['paymentstatus'];
	$editorBonus = (float) $_POST['editbonus'];//получение бонуса / вычета редактора
	
	$rating = (int) $_POST['points'];//получение оценки редактора
	
	/*Сообщение о превышении размера бонуса-вычета*/
	
	if ($editorBonus < -($price*0.25))
	{
		$title = 'Размер вычета превышен!';//Данные тега <title>
		$headMain = 'Размер вычета превышен!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Вычет не может быть больше 25% от начального гонорара!';// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	elseif ($editorBonus > $price*0.25)
	{
		$title = 'Размер бонуса превышен!';//Данные тега <title>
		$headMain = 'Размер бонуса превышен!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Бонус не может быть больше 25% от начального гонорара!';// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Выбор счётчика статей и номера ранга для сравнения*/
	try
	{
		$sql = 'SELECT lastnumber FROM author
				INNER JOIN rang ON idrang = rang.id 
				WHERE author.id = '.$idAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора цены новости: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$lastNumber = $row['lastnumber'];
	
	if ($paymentStatus == 'NO')//Если публикация подтверждается в первый раз, а не после предварительного снятия с публикации, происходит обновление счёта и ранга
	{
	
		try
		{
			$pdo->beginTransaction();//инициация транзакции
		
			/*Обновить счёт автора и счётчик статей*/
			$sql = 'UPDATE author 
					SET score = score + '.($price + $editorBonus).',
					countposts = countposts + 1,
					rating = rating + '.$rating.' WHERE id = '.$idAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
			/*Обновить ранг автора*/
			$sql = 'UPDATE author 
					SET idrang = idrang + 1
					WHERE id = '.$idAuthor. ' AND countposts > '.$lastNumber;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			/*Обновить статус оплаты во избежании повторной оплаты*/
			$sql = 'UPDATE newsblock SET paymentstatus = "YES", 
										 newsdate = SYSDATE(),
										 editorbonus = '.$editorBonus.',
										 editorcomment = :editorcomment,
										 articlerating = articlerating + '.$rating.' WHERE id = :idnews';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idnews', $_POST['id']);//отправка значения
			$s -> bindValue(':editorcomment', $_POST['editorcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
			$pdo->commit();//подтверждение транзакции	
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка транзакции при обновлении счёта и ранга'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
	}
	
	try
	{
		$sql = 'UPDATE newsblock SET premoderation = "YES" WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}

/*Снятие с публикации статьи*/

if (isset ($_POST['action']) && $_POST['action'] == 'Снять с публикации')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, newstitle FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора новости: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Снятие с публикации новости ';//Данные тега <title>
	$headMain = 'Снятие с публикации новости';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'premodno';
	$pointPanel = '';
	$premodYes = 'Снять с публикации материал ';
	$posttitle = $row['newstitle'];
	$id = $row['id'];
	$button = 'Снять с публикации';
	
	include 'premodstatus.html.php';
}

if (isset ($_GET['premodno']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE newsblock SET premoderation = "NO" WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка снятия с публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}		

/*Отклонить материал*/

if (isset ($_POST['action']) && $_POST['action'] == 'Отклонить')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, newstitle, imghead FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Отклонить новость';//Данные тега <title>
	$headMain = 'Отклонить новость';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'refusedyes';
	$premodYes = 'Отклонить материал ';
	$posttitle = $row['newstitle'];
	$reasonrefusal = '';
	$id = $row['id'];
	$button = 'Отклонить';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'refusalform.html.php';

}

if (isset ($_GET['refusedyes']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = 'UPDATE newsblock SET refused = "YES" WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$sql = 'UPDATE newsblock SET reasonrefusal = :reasonrefusal WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> bindValue(':reasonrefusal', $_POST['reasonrefusal']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$pdo->commit();//подтверждение транзакции
	}
	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции
		
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка отклонения публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	
