<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	include '../login.html.php';
	exit();
}

$time = time();

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Проверка, есть ли пользователь в базе бана */
/*Команда SELECT*/
try
{
    $sql = 'SELECT idauthor FROM blockedauthor WHERE idauthor = :idauthor';
    $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
    $s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
    $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
    $error = 'Ошибка выбора информации аккаунта';
    include MAIN_FILE . '/includes/error.inc.php';
}	

$row = $s -> fetch();

if ($row['idauthor'] != '')
{
    try
    {
        $sql = 'UPDATE blockedauthor SET 
                    currtime = :currtime,
                    term = :term,
                    bandate = SYSDATE()
                WHERE idauthor = :idauthor';
        $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
        $s -> bindValue(':currtime', $time);//отправка значения
        $s -> bindValue(':term', $_POST['banterm']);//отправка значения
        $s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
        $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка обновления бана';
        include MAIN_FILE . '/includes/error.inc.php';
    }
}

else
{
    try
    {
        $sql = 'INSERT INTO blockedauthor SET 
                    idauthor = :idauthor,
                    currtime = :currtime,
                    term = :term,
                    bandate = SYSDATE()';
        $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
        $s -> bindValue(':currtime', $time);//отправка значения
        $s -> bindValue(':term', $_POST['banterm']);//отправка значения
        $s -> bindValue(':idauthor', $_POST['idauthor']);//отправка значения
        $s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка добавления бана';
        include MAIN_FILE . '/includes/error.inc.php';
    }
}

header ('Location: //'.MAIN_URL.'/account/?id='.$_POST['idauthor']);//перенаправление обратно в контроллер index.php
exit();