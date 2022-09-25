<?php

/*Изменить категорию автора*/
if (isset ($_POST['addcat']) && $_POST['addcat'] == 'Назначить категорию')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT * FROM authorcategory';
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора категории';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$categorys[] =  array ('id' => $row['id'], 
							'authcategoryname' => $row['authcategoryname'],
							'categorybonus' => $row['categorybonus'],
							);
	}

	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT idcategory FROM author WHERE author.id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id категории';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
		
	$title = 'Выбрать категорию';//Данные тега <title>
	$headMain = 'Выбрать категорию';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addauhcat';
	$idcategory = $row['idcategory'];
	$idauthor = $_POST['id'];
	$button = 'Назначить';
	$errorForm ='';
	
	include 'addcategoryform.html.php';
	exit();
}