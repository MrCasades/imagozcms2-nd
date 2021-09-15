<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

if (isset($_POST["tags"])) 
{ 
    /*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'INSERT INTO meta SET metaname = :tags';// псевдопеременная получающая значение из формы
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':tags', $_POST['tags']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации в таблицу "Тематика" '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

    /*Команда SELECT*/
	try
	{
	    $sql = 'SELECT id, metaname FROM meta WHERE id=(SELECT max(id) FROM meta)';
	    $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	    //$s -> bindValue(':idmeta', $_POST['idmeta']);//отправка значения
	    $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
	    $robots = 'noindex, nofollow';
	    $descr = '';
	    $error = 'Error select : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	    include 'error.html.php';
	    exit();
	}
	
	$row = $s -> fetch();

    // Формируем массив для JSON ответа
    $result = array(
    	'id' => $row['id'],
    	'name' => $row['metaname']
    ); 

    // Переводим массив в JSON
    echo json_encode($result); 
}
?>