<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';



try
{
    $sql = 'UPDATE video SET 
                duration = :duration
            WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':duration', $_POST['duration']);//отправка значения
        $s -> bindValue(':id', $_POST['idvideo']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка генерации дайджеста';
		include MAIN_FILE . '/includes/error.inc.php';
	}

    // Формируем массив для JSON ответа
    $result = array('res' => 'generated');

    // Переводим массив в JSON
    echo json_encode($result);
?>