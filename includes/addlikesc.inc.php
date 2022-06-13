<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

if (empty($_POST['idauthor']) || $_POST['idauthor'] == -1)
{
	// Формируем массив для JSON ответа
    $result = array('res' => '<div class="m-content">Только для зарегестрированных пользователей!</div>'); 

    // Переводим массив в JSON
    echo json_encode($result); 
}

else
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Выбор лайков-дислайков*/
	try
	{			
		$sql = 'SELECT isdislike, islike FROM subcommentlikes WHERE idauthor = :idauthor AND idsubcomment = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
		$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();

	if($row)
	{
		$isLikeSc = $row['islike'];
		$isDisLikeSc = $row['isdislike'];
	}

	else
	{
		$isLikeSc = '';
		$isDisLikeSc = '';
	}

	if($_POST['type-like'] === 'like' && $isLikeSc == '')
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'INSERT INTO subcommentlikes SET 
				isdislike = 0,	
				islike = 1,
				idauthor = :idauthor,
				idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				likescount = likescount + 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 1-1';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}

	elseif ($_POST['type-like'] === 'like' && $isLikeSc == 0)
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'DELETE FROM subcommentlikes WHERE idauthor = :idauthor AND idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', (int)$_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', (int)$_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'INSERT INTO subcommentlikes SET 
				isdislike = 0,	
				islike = 1,
				idauthor = :idauthor,
				idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				likescount = likescount + 1,
				dislikescount = dislikescount - 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 2-1';
			include MAIN_FILE . '/includes/error.inc.php';
		}

	}

	elseif ($_POST['type-like'] === 'like' && $isLikeSc == 1)
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'DELETE FROM subcommentlikes WHERE idauthor = :idauthor AND idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', (int)$_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', (int)$_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				likescount = likescount - 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 3-1';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}

	elseif ($_POST['type-like'] === 'dislike' && $isDisLikeSc === '')
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'INSERT INTO subcommentlikes SET 
				isdislike = 1,	
				islike = 0,
				idauthor = :idauthor,
				idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				dislikescount = dislikescount + 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 1-2';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}

	elseif ($_POST['type-like'] === 'dislike' && $isDisLikeSc == 0)
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'DELETE FROM subcommentlikes WHERE idauthor = :idauthor AND idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'INSERT INTO subcommentlikes SET 
				isdislike = 1,	
				islike = 0,
				idauthor = :idauthor,
				idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				likescount = likescount - 1,
				dislikescount = dislikescount + 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 2-2';
			include MAIN_FILE . '/includes/error.inc.php';
		}

	}

	elseif ($_POST['type-like'] === 'dislike' && $isDisLikeSc == 1)
	{
		try
		{	
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'DELETE FROM subcommentlikes WHERE idauthor = :idauthor AND idsubcomment = :idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE subcomments SET 
				dislikescount = dislikescount - 1
				WHERE subcomments.id=:idsubcomment';
				
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idsubcomment', $_POST['idsubcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции
		}
		
		catch (PDOException $e)
		{
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка добавления лайка 3-2';
			include MAIN_FILE . '/includes/error.inc.php';
		}

	}
	// Формируем массив для JSON ответа
    $result = array('res' => ''); 

    // Переводим массив в JSON
    echo json_encode($result); 
}

?>