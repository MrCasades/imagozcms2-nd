<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Добавление / удаление из избранного*/

/*Добавить в ибранное*/

if (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'addfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	$favData = 'SELECT id, post, videotitle, videodate, imghead, imgalt, idauthor, idcategory FROM posts WHERE id = '.$_POST['id'];//подготовка данных для избранного
		
	/*Выбор материала для избранного*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$pdo->beginTransaction();//инициация транзакции
			
		$sql = $favData;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$row = $s -> fetch();
		
		$post = implode(' ', array_slice(explode(' ', strip_tags($row['post'])), 0, 50));
		$postTitle = $row['posttitle'];
		$postDate = $row['postdate'];
		$imgHead = $row['imghead'];
		$imgAlt = $row['imgalt'];
		$idAuthorPost = $row['idauthor'];
		$idCategory = $row['idcategory'];
		$url = '//'.MAIN_URL.'/viewpost/?id='.$row['id'];

			
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

		$error = 'Ошибка выбора данных для избранного';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вставка материала для избранного*/
	try
	{
		$sql = 'INSERT favourites SET 
				idauthor = '.$_POST['idauthor'].',
				idpost = '.$_POST['id'].',
				post = \''.$post.'\',
				title = \''.$postTitle.'\',
				date = \''.$postDate.'\',
				imghead = \''.$imgHead.'\',
				imgalt = \''.$imgAlt.'\',
				idauthorpost = '.$idAuthorPost.',
				idcategory = '.$idCategory.',
				adddate = SYSDATE(),
				url = \''.$url.'\'';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка добавления избранного';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	/*Обновление значения счётчика избранного*/

	$updateCount = 'UPDATE video SET favouritescount = favouritescount + 1 WHERE id = ';

	try
	{
		$sql = $updateCount.$_POST['id'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка счётчика';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore('add', 'favouritespoints');//если конкурс включен
}

/*Удаление из избранного*/
elseif (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'delfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	$delFav = 'DELETE FROM favourites WHERE 
			   idauthor = '.$_POST['idauthor'].' AND
			   idvideo = '.$_POST['id'];
		
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$pdo->beginTransaction();//инициация транзакции
			
		$sql = $delFav;
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

		$error = 'Ошибка удаления избранного';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	/*Обновление значения счётчика избранного*/

	$updateCount = 'UPDATE posts SET favouritescount = favouritescount - 1 WHERE id = ';

	try
	{
		$sql = $updateCount.$_POST['id'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка счётчика ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore('del', 'favouritespoints');//если конкурс включен
}

?>