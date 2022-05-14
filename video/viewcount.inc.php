<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Обновление значения счётчика*/
	
$updateCount = 'UPDATE video SET viewcount = viewcount + 1 WHERE id = :id';
	
try
{
	$sql = $updateCount;
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
    $s -> bindValue(':id', $_GET['id']);//отправка значения
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}
	
catch (PDOException $e)
{
	$error = 'Ошибка счётчика ';
	include MAIN_FILE . '/includes/error.inc.php';
}

?>