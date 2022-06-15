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
		$sql = 'SELECT id, videotitle, imghead FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Публикация статьи';//Данные тега <title>
	$headMain = 'Публикация статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'premodyes';
	$premodYes = 'Опубликовать материал ';
	$posttitle = $row['videotitle'];
	$id = $row['id'];
	$button = 'Опубликовать';
	
	include 'premodstatus.html.php';
}

if (isset ($_GET['premodyes']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Скрипт списания со счёта автора и изменение ранга*/
	/*Выбор цены  и id автора*/
	try
	{
		$sql = 'SELECT idauthor, paymentstatus FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статуса оплаты';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$idAuthor = (int) $row['idauthor'];
	$paymentStatus = $row['paymentstatus'];
	
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
		$error = 'Ошибка выбора ранга';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$lastNumber = $row['lastnumber'];
	
	if ($paymentStatus == 'NO')//Если публикация подтверждается в первый раз, а не после предварительного снятия с публикации, происходит обновление ранга
	{
	
		try
		{
			$pdo->beginTransaction();//инициация транзакции
		
			/*Обновить счёт автора и счётчик статей*/
			$sql = 'UPDATE author SET countposts = countposts + 1,
					rating = rating + 100 WHERE id = '.$idAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
			/*Обновить ранг автора*/
			$sql = 'UPDATE author 
					SET idrang = idrang + 1
					WHERE id = '.$idAuthor. ' AND countposts > '.$lastNumber;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			/*Обновить статус оплаты во избежании повторной оплаты*/
			$sql = 'UPDATE video SET paymentstatus = "YES",
						   videodate = SYSDATE() WHERE id = :idvideo';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
			$pdo->commit();//подтверждение транзакции	
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции
			$error = 'Ошибка транзакции при обновлении ранга';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}
	
	try
	{
		$sql = 'UPDATE video SET premoderation = "YES" WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления статуса премодерации';
		include MAIN_FILE . '/includes/error.inc.php';
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
		$sql = 'SELECT id, videotitle, imghead FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Снятие с публикации видео ';//Данные тега <title>
	$headMain = 'Снятие с публикации видео';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'premodno';
	$premodYes = 'Снять с публикации материал ';
	$posttitle = $row['videotitle'];
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
		$sql = 'UPDATE video SET premoderation = "NO" WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка снятия с публикаци';
		include MAIN_FILE . '/includes/error.inc.php';
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
		$sql = 'SELECT id, videotitle, idauthor FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Отклонить видео';//Данные тега <title>
	$headMain = 'Отклонить видео';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'refusedyes';
	$premodYes = 'Отклонить материал ';
	$posttitle = $row['videotitle'];
	$idAuthor = $row['idauthor'];
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
	
	/*Команда SELECT выбор цены промоушена*/
	// try
	// {
	// 	$sql = 'SELECT pricetext FROM promotion WHERE id = :idpromotion';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$robots = 'noindex, nofollow';
	// 	$descr = '';
	// 	$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	// 	include 'error.html.php';
	// 	exit();
	// }
	
	// $row = $s -> fetch();
	
	// $promotionPrice = $row['pricetext'];
	
	/*Команда SELECT выбор id автора промоушена*/
	// try
	// {
	// 	$sql = 'SELECT idauthor FROM promotion WHERE id = :idpromotion';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$robots = 'noindex, nofollow';
	// 	$descr = '';
	// 	$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	// 	include 'error.html.php';
	// 	exit();
	// }
	
	// $row = $s -> fetch();
	
	// $idAuthor = $row['idauthor'];
	
	// try
	// {
	// 	$pdo->beginTransaction();//инициация транзакции
		
	// 	$sql = 'UPDATE author SET score = score + '.$promotionPrice.' WHERE id = '.$idAuthor;//Возврат денег на счёт
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
	// 	$sql = 'UPDATE promotion SET refused = "YES" WHERE id = :idpromotion';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
	// 	$sql = 'UPDATE promotion SET reasonrefusal = :reasonrefusal WHERE id = :idpromotion';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
	// 	$s -> bindValue(':reasonrefusal', $_POST['reasonrefusal']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
				
	// 	$pdo->commit();//подтверждение транзакции	
	// }
	// catch (PDOException $e)
	// {
	// 	$pdo->rollBack();//отмена транзакции
		
	// 	$robots = 'noindex, nofollow';
	// 	$descr = '';
	// 	$error = 'Ошибка отклонения публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	// 	include 'error.html.php';
	// 	exit();
	// }

	/*Команда SELECT выбор id автора промоушена*/
	try
	{
		$sql = 'UPDATE video 
				SET refused = "YES"
					,reasonrefusal = :reasonrefusal
				WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> bindValue(':reasonrefusal', $_POST['reasonrefusal']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка изменения статуса отказа';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$posttitle = $_POST['posttitle'];
	$titleMessage = 'Ваш материал "'. $posttitle.'" отклонён.';
	$mailMessage = 'Ваш материал "'. $posttitle.'" отклонён модератором по причине: <br>***'.$_POST['reasonrefusal'].'***';
	
	toEmail_2($titleMessage, $mailMessage, $idAuthor);//отправка письма
		
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	
