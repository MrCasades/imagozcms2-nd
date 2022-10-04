<?php
    /*Загрузка главного пути*/
    include_once '../includes/path.inc.php';

    if (isset($_POST["idd"])) 
    { 
        /*Подключение к базе данных*/
        include MAIN_FILE . '/includes/db.inc.php';
            
        /*Загрузка функций для формы входа*/
        require_once MAIN_FILE . '/includes/access.inc.php';

        try
        {
            $sql = 'DELETE FROM mainmessages WHERE (idfrom = :idfrom_1 AND idto = :idto_1) OR (idfrom = :idfrom_2 AND idto = :idto_2)';
            $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
            $s -> bindValue(':idfrom_1', $_POST['idauthor']);//отправка значения
            $s -> bindValue(':idto_1', $_POST['idd']);//отправка значения
            $s -> bindValue(':idfrom_2', $_POST['idd']);//отправка значения
            $s -> bindValue(':idto_2', $_POST['idauthor']);//отправка значения
            $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка удаления информации mainmessages';
		    include MAIN_FILE . '/includes/error.inc.php';
        }
            
    }
?>