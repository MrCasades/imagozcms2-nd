<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Оценка статьи*/
if (isset($_GET['vote']))
{
	$vote = $_GET['vote'];//значение оценки
	$averageNumber = 0;//среднее значение

	if($_POST['pb_type'] == 'news')
	{
		$updateVoteCount = 'UPDATE newsblock SET votecount = votecount + 1 WHERE id = '.$_POST['id'];//обновление числа проголосовавших
		$updateTotalNumber = 'UPDATE newsblock SET totalnumber = totalnumber + '.$vote.' WHERE id = '.$_POST['id'];//обновление общего числа
		$updateAverageNumber = 'UPDATE newsblock SET averagenumber = totalnumber/votecount WHERE id = '.$_POST['id'];//обновление среднего значения в БД
		$insertToVotedAuthor ='INSERT INTO votedauthor SET idpromotion = 0, idpost = 0, idvideo = 0, idnews = '.$_POST['id'].', idauthor = '.$_POST['idauthor'].', vote = '.$vote;//обновление таблицы проголосовавшего автора
		$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	}

	elseif($_POST['pb_type'] == 'post')
	{
		$updateVoteCount = 'UPDATE posts SET votecount = votecount + 1 WHERE id = '.$_POST['id'];//обновление числа проголосовавших
		$updateTotalNumber = 'UPDATE posts SET totalnumber = totalnumber + '.$vote.' WHERE id = '.$_POST['id'];//обновление общего числа
		$updateAverageNumber = 'UPDATE posts SET averagenumber = totalnumber/votecount WHERE id = '.$_POST['id'];//обновление среднего значения в БД
		$insertToVotedAuthor ='INSERT INTO votedauthor SET idpromotion = 0, idnews = 0, idvideo = 0, idpost = '.$_POST['id'].', idauthor = '.$_POST['idauthor'].', vote = '.$vote;//обновление таблицы проголосовавшего автора
		$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	}

	elseif($_POST['pb_type'] == 'promotion')
	{
		$updateVoteCount = 'UPDATE promotion SET votecount = votecount + 1 WHERE id = '.$_POST['id'];//обновление числа проголосовавших
		$updateTotalNumber = 'UPDATE promotion SET totalnumber = totalnumber + '.$vote.' WHERE id = '.$_POST['id'];//обновление общего числа
		$updateAverageNumber = 'UPDATE promotion SET averagenumber = totalnumber/votecount WHERE id = '.$_POST['id'];//обновление среднего значения в БД
		$insertToVotedAuthor ='INSERT INTO votedauthor SET idpost = 0, idnews = 0, idvideo = 0, idpromotion = '.$_POST['id'].', idauthor = '.$_POST['idauthor'].', vote = '.$vote;//обновление таблицы проголосовавшего автора
		$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	}
								
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

		$error = 'Ошибка оценки '.$_POST['pb_type'];
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	/*Добавление конкурсных очков автору*/
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore('add', 'votingpoints');//если конкурс включен
}
?>