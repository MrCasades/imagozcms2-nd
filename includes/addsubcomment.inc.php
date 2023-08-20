<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

if (isset($_POST["idcomment"])) 
{ 
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';

	$isBlocked = checkBlockedAuthor($_POST['idauthor']);//Проверка пользователя на бан

	if (!$isBlocked)
	{
	
		/*команда INSERT  - добавление комментария в базу данных*/

		/*Подключение к базе данных*/
		include MAIN_FILE . '/includes/db.inc.php';
				
		try
		{
			$sql = 'INSERT INTO subcomments SET 
				subcomment = :subcomment,	
				subcommentdate = SYSDATE(),
				idauthor = :idauthor,'.
				'idcomment = :idcomment';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':subcomment', $_POST['subcomment']);//отправка значения
			$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
			$s -> bindValue(':idcomment', $_POST['idcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$error = 'Ошибка добавления информации';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
		/*Обновление счётчика ответов*/
		try
		{
			$sql = 'UPDATE comments SET 
				subcommentcount = subcommentcount + 1
				WHERE id=:idcomment';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idcomment', $_POST['idcomment']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
			
		catch (PDOException $e)
		{
			$error = 'Ошибка обновления информации comment';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
		/*Команда SELECT*/
		try
		{
			$sql = 'SELECT subcomments.id AS subid, author.id AS subidauthor, subcomment, subcommentdate, authorname AS subauthorname, avatar AS subavatar FROM subcomments 
			INNER JOIN author 
			ON idauthor = author.id 
			WHERE subcomments.id =(SELECT max(id) FROM subcomments)';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			//$s -> bindValue(':idmeta', $_POST['idmeta']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора добавленного ответа';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
		$row = $s -> fetch();

		// Формируем массив для JSON ответа
		$result = array(
			'id' => $row['subid'],
			'text' => $row['subcomment'],
			'date' => $row['subcommentdate'],
			'idauthor' => $row['subidauthor'],
			'authorname' => $row['subauthorname'],
			'avatar' => $row['subavatar'],
			'idcomment' => $_POST['idcomment'],
		//  'subcommentcount' => $row['subcommentcount']
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