<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Подписка-отписка */

if (isset($_POST['val_subs']) && isset($_POST['idblog']) && $_POST['val_subs'] == 'addsubs')
{
    /*Обновление индексации блога*/
	include MAIN_FILE . '/includes/db.inc.php';

    try
		{
			$sql = 'INSERT INTO subscribers SET 
				idauthor = :idauthor, 
				idblog = :idblog';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
            $s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
            $s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
            $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		}
		catch (PDOException $e)
		{
			$error = 'Ошибка подписки';
			include MAIN_FILE . '/includes/error.inc.php';
		}
}

elseif (isset($_POST['val_subs']) && isset($_POST['idblog']) && $_POST['val_subs'] == 'delsubs')
{
    /*Обновление индексации блога*/
	include MAIN_FILE . '/includes/db.inc.php';

    try
	{
		$sql = 'DELETE FROM subscribers WHERE idauthor = :idauthor and idblog = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
		$s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка отписки';
		include MAIN_FILE . '/includes/error.inc.php';
	}
}

?>