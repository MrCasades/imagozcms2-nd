<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Оценка статьи*/
if (isset($_GET['vote']))
{
	$vote = $_GET['vote'];//значение оценки
	$averageNumber = 0;//среднее значение
		
	$updateVoteCount = 'UPDATE publication SET votecount = votecount + 1 WHERE id = '.$_POST['id'];//обновление числа проголосовавших
	$updateTotalNumber = 'UPDATE publication SET totalnumber = totalnumber + '.$vote.' WHERE id = '.$_POST['id'];//обновление общего числа
	$updateAverageNumber = 'UPDATE publication SET averagenumber = totalnumber/votecount WHERE id = '.$_POST['id'];//обновление среднего значения в БД
	$insertToVotedAuthor ='INSERT INTO votedauthor SET idpromotion = 0, idnews = 0, idvideo = 0, idpost = 0, idpublication = '.$_POST['id'].', idauthor = '.$_POST['idauthor'].', vote = '.$vote;//обновление таблицы проголосовавшего автора
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
							
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$pdo->beginTransaction();//инициация транзакции
			
		$sql = $updateVoteCount;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$sql = $updateTotalNumber;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$sql = $updateAverageNumber;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$sql = $insertToVotedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$sql = $SELECTCONTEST;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$row = $s -> fetch();
		
		$contestOn = $row['conteston'];//проверка на включение конкурса
			
		$pdo->commit();//подтверждение транзакции			
	}
		
	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции

		$error = 'Error transaction при голосовании';
		include MAIN_FILE . '/includes/error.inc.php';	
	}
		
	/*Добавление конкурсных очков автору*/
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore('add', 'votingpoints');//если конкурс включен
	}
?>