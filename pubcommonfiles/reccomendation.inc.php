<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Команда SELECT выбор цены промоушена*/
try
{
	$sql = 'SELECT promotionprice FROM promotionprice WHERE id = 2';
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'ошибка выбора цены рекомендации: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
	}
	
	$row = $s -> fetch();
	
	$recommendationPrice = $row['promotionprice'];
	
	/*Команда SELECT выбор счёа автора для сравнения*/
	try
	{
		$sql = 'SELECT score FROM author WHERE id = '.$_POST['idauthor'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
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
	
	$score = $row['score'];
	
	if ($recommendationPrice > $score)//Если на счету нет достаточной суммы для написания статьи.
	{
		$err = json_encode(array(err => $err_php = 'Недостаточно средств на счету!'));
		echo $err;
	}
	
	else
	{
		if($_POST['pb_type'] == 'post')
			$select = 'UPDATE posts SET recommendationdate = SYSDATE() WHERE id = ';
		elseif ($_POST['pb_type'] == 'promotion')
			$select = 'UPDATE promotion SET recommendationdate = SYSDATE() WHERE id = ';

		/*Рекомендация статьи на главной*/
		try
		{
			$pdo->beginTransaction();//инициация транзакции

			$sql = $select.$_POST['id'];
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			//$s -> bindValue(':idpost', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE author SET score  = score - '.$recommendationPrice.'
									  WHERE id = '.$_POST['idauthor'];
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}

		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка обновления информации о рекомендации';
			include MAIN_FILE . '/includes/error.inc.php';
		}	
	}

?>