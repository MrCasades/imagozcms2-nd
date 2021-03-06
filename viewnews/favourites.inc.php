<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Добавление / удаление из избранного*/

/*Добавить в ибранное*/

if (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'addfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	$favData = 'SELECT id, news, newstitle, newsdate, imghead, imgalt, idauthor, idcategory FROM newsblock WHERE id = '.$_POST['id'];//подготовка данных для избранного
	
	/*Выбор материала для избранного*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
			
		$sql = $favData;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$row = $s -> fetch();
		
		$post = implode(' ', array_slice(explode(' ', strip_tags($row['news'])), 0, 50));
		$postTitle = $row['newstitle'];
		$postDate = $row['newsdate'];
		$imgHead = $row['imghead'];
		$imgAlt = $row['imgalt'];
		$idAuthorPost = $row['idauthor'];
		$idCategory = $row['idcategory'];
		$url = '//'.MAIN_URL.'/viewnews/?id='.$row['id'];
			
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
			
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора данных для избранного ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вставка материала для избранного*/
	try
	{
		$sql = 'INSERT favourites SET 
				idauthor = '.$_POST['idauthor'].',
				idnews = '.$_POST['id'].',
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
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления избранного'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();

	}
		
	/*Обновление значения счётчика избранного*/

	$updateCount = 'UPDATE newsblock SET favouritescount = favouritescount + 1 WHERE id = ';

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
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore($_POST['idauthor'], 'add', 'favouritespoints');//если конкурс включен	
}
	
/*Удаление из избранного*/
elseif (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'delfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	$delFav = 'DELETE FROM favourites WHERE 
				idauthor = '.$_POST['idauthor'].' AND
				idnews = '.$_POST['id'];
		
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
			
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления избранного'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();

	}
		
	/*Обновление значения счётчика избранного*/

	$updateCount = 'UPDATE newsblock SET favouritescount = favouritescount - 1 WHERE id = ';

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
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore($_POST['idauthor'], 'del', 'favouritespoints');//если конкурс включен
}

?>