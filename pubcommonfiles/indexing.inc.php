<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Индексация блога*/

if (isset($_POST['val_bl_ind']) && isset($_POST['idblog']) && $_POST['val_bl_ind'] == 'addindex')
{
    /*Обновление индексации блога*/
	include MAIN_FILE . '/includes/db.inc.php';

    try
    {
        $sql = 'UPDATE blogs SET indexing = "all" WHERE id = :idblog';
        $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
        $s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
        $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка индексации блога';
        include MAIN_FILE . '/includes/error.inc.php';
    }
}

elseif (isset($_POST['val_bl_ind']) && isset($_POST['idblog']) && $_POST['val_bl_ind'] == 'delindex')
{
    /*Обновление индексации блога*/
	include MAIN_FILE . '/includes/db.inc.php';

    try
    {
        $sql = 'UPDATE blogs SET indexing = "noindex, nofollow" WHERE id = :idblog';
        $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
        $s -> bindValue(':idblog', $_POST['idblog']);//отправка значения
        $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка индексации publication';
        include MAIN_FILE . '/includes/error.inc.php';
    }
}

?>