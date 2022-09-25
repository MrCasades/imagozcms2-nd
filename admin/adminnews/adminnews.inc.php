<?php 
/*Вывод панели после входа в систему*/

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (isset($_SESSION['loggIn']))//если не выполнен вход в систему
{
    if ((userRole('Автор') || userRole('Администратор')))
    {
        try
        {
            $sql = 'SELECT * FROM adminmail WHERE adminnews = "YES" ORDER BY id DESC LIMIT 1';
            $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
            $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
        }

        catch (PDOException $e)
        {
            $error = 'Ошибка вывода новости администрации';
		    include MAIN_FILE . '/includes/error.inc.php';
        }

        $row = $s -> fetch();

        $messageTitle = $row['messagetitle'];
        $messageDate = $row['messagedate'];
        $messageText = $row['message'];
        $idnews = $row['id'];

        include 'adminnews.html.php';
    }
}

