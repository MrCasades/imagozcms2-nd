<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

if (isset($_POST["idarticle"])) 
{ 
    /*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
		
	/*Возврат id автора*/
	
	//$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

	$isBlocked = checkBlockedAuthor($_POST['idauthart']);//Проверка пользователя на бан

	if (!$isBlocked)
	{
	
		$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
		

		if ($_POST["articletype"] === 'post')
		{
			$idType = 'idpost = ';
		}

		elseif ($_POST["articletype"] === 'news')
		{
			$idType = 'idnews = ';
		}

		elseif ($_POST["articletype"] === 'promotion')
		{
			$idType = 'idpromotion = ';
		}

		elseif ($_POST["articletype"] === 'account')
		{
			$idType = 'idaccount = ';
		}

		elseif ($_POST["articletype"] === 'video')
		{
			$idType = 'idvideo = ';
		}

		elseif ($_POST["articletype"] === 'publication')
		{
			$idType = 'idpublication = ';
		}
			
		try
		{
			$pdo->beginTransaction();//инициация транзакции
			
			$sql = 'INSERT INTO comments SET 
				comment = :comment,	
				commentdate = SYSDATE(),
				idauthor = '.$_POST['idauthart'].','.
				$idType.$_POST['idarticle'];
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':comment', $_POST['comment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$sql = $SELECTCONTEST;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
				
			//$row = $s -> fetch();
			
			//$contestOn = $row['conteston'];//проверка на включение конкурса
			
			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления информации';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
		/*Если конкурс включён, происходит изменение конкурсного счёта*/	
		//if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore('add', 'commentpoints');//если конкурс включен

		/*Команда SELECT*/
		try
		{
			$sql = 'SELECT comments.id, comment, commentdate, subcommentcount, authorname, avatar, author.id AS idauthor, idpost FROM comments 
			INNER JOIN author 
			ON idauthor = author.id 
			WHERE comments.id=(SELECT max(id) FROM comments)';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			//$s -> bindValue(':idmeta', $_POST['idmeta']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора добавленного комментария';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
		$row = $s -> fetch();

		// Формируем массив для JSON ответа
		$result = array(
			'id' => $row['id'],
			'text' => $row['comment'],
			'date' => $row['commentdate'],
			'idauthor' => $row['idauthor'],
			'authorname' => $row['authorname'],
			'subcommentcount' => $row['subcommentcount'],
			'avatar' => $row['avatar'],
			'idarticle' => $row['idpost']
		); 		
	}

	else
	{
		$result = 'ban';
	}

	// Переводим массив в JSON
	echo json_encode($result); 
}
?>