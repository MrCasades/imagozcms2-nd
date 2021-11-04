<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

if (isset($_POST["idfr"])) 
{ 
    /*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
					
	try
	{		
		$sql = 'INSERT INTO mainmessages SET 
			mainmessage = :mainmessage,
			mainmessagedate = SYSDATE(),
			idfrom = :idfr,
			idto = :idto';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':mainmessage', $_POST['text']);//отправка значения
        $s -> bindValue(':idfr', $_POST['idfr']);//отправка значения
        $s -> bindValue(':idto', $_POST['idto']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL	
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

    $idmessage_ind = $pdo->lastInsertId();
	
    /*Команда SELECT*/
	try
	{
	    $sql = $sql = 'SELECT mmess.mainmessage AS messtext, mmess.id AS messid, mmess.mainmessagedate AS messdate, mmess.imghead
                        FROM mainmessages AS mmess 
                        WHERE mmess.id=:id';
	    $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
        $s -> bindValue(':id', $idmessage_ind);//отправка значения
	    $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
	    $robots = 'noindex, nofollow';
	    $descr = '';
	    $error = 'Error select comment: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	    include 'error.html.php';
	    exit();
	}
	
	$row = $s -> fetch();

    // Формируем массив для JSON ответа
    $result = array(
    	'id' => $row['messid'],
    	'text' => $row['messtext'],
        'date' => $row['messdate']
    ); 

    // Переводим массив в JSON
    echo json_encode($result); 
}
?>