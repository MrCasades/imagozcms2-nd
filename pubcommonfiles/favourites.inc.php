<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Добавление / удаление из избранного*/

/*Добавить в ибранное*/

/*Тип ID */
if ($_POST['pb_type'] == 'news')
	$articleIdType = 'idnews';
elseif ($_POST['pb_type'] == 'post')
	$articleIdType = 'idpost';

if (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'addfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	if ($_POST['pb_type'] == 'news')
		$favData = 'SELECT id, news, newstitle, newsdate, imghead, imgalt, idauthor, idcategory FROM newsblock WHERE id = '.$_POST['id'];//подготовка данных для избранного
	elseif ($_POST['pb_type'] == 'post')
		$favData = 'SELECT id, post, posttitle, postdate, imghead, imgalt, idauthor, idcategory FROM posts WHERE id = '.$_POST['id'];//подготовка данных для избранного
	
	
	/*Выбор материала для избранного*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
			
		$sql = $favData;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$row = $s -> fetch();
		
		
		if ($_POST['pb_type'] == 'news')
		{
			$post = implode(' ', array_slice(explode(' ', strip_tags($row['news'])), 0, 50));
			$postTitle = $row['newstitle'];
			$postDate = $row['newsdate'];
			$url = '//'.MAIN_URL.'/viewnews/?id='.$row['id'];
		}

		elseif ($_POST['pb_type'] == 'post')
		{
			$post = implode(' ', array_slice(explode(' ', strip_tags($row['post'])), 0, 50));
			$postTitle = $row['posttitle'];
			$postDate = $row['postdate'];
			$url = '//'.MAIN_URL.'/viewpost/?id='.$row['id'];
		}
		
		$imgHead = $row['imghead'];
		$imgAlt = $row['imgalt'];
		$idAuthorPost = $row['idauthor'];
		$idCategory = $row['idcategory'];
		
			
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
				'.$articleIdType.' = '.$_POST['id'].',
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

	if ($_POST['pb_type'] == 'news')
		$updateCount = 'UPDATE newsblock SET favouritescount = favouritescount + 1 WHERE id = ';
	elseif ($_POST['pb_type'] == 'post')
		$updateCount = 'UPDATE posts SET favouritescount = favouritescount + 1 WHERE id = ';

	try
	{
		$sql = $updateCount.$_POST['id'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка счётчика избранного';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore($_POST['idauthor'], 'add', 'favouritespoints');//если конкурс включен	
}
	
/*Удаление из избранного*/
elseif (isset($_POST['val_fav']) && isset($_POST['id']) && isset($_POST['idauthor']) && $_POST['val_fav'] == 'delfav')
{
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	$delFav = 'DELETE FROM favourites WHERE 
				idauthor = '.$_POST['idauthor'].' AND
				'.$articleIdType.' = '.$_POST['id'];
		
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

	if ($_POST['pb_type'] == 'news')
		$updateCount = 'UPDATE newsblock SET favouritescount = favouritescount - 1 WHERE id = ';
	elseif ($_POST['pb_type'] == 'post')
		$updateCount = 'UPDATE posts SET favouritescount = favouritescount - 1 WHERE id = ';

	try
	{
		$sql = $updateCount.$_POST['id'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка счётчика избранного';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	if (($contestOn == 'YES') && (!userRole('Автор')) && (!userRole('Администратор'))) delOrAddContestScore($_POST['idauthor'], 'del', 'favouritespoints');//если конкурс включен
}

?>