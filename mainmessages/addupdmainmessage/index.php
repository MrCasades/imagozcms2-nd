<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
loggedIn();

if (!loggedIn())
{
	$error = 'Для того, чтобы отправлять сообщения пользователю Вам нужно <a href="//'.MAIN_URL.'/admin/registration/?log">авторизироваться</a> в системе или пройти 
						<a href="//'.MAIN_URL.'/admin/registration/?reg">регистрацию</a>!';
	include MAIN_FILE . '/includes/error.inc.php';
}


/*Добавление сообщения*/
if (isset ($_POST['action']) && $_POST['action'] == 'Написать сообщение')
{
	$title = 'Написать сообщение';//Данные тега <title>
	$headMain = 'Написать сообщение';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$text = '';
	$idauthor = '';
	$idto = $_POST['idto'];
	$id = '';
	$button = 'Отправить';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS


	include 'addupdform.html.php';
	exit();	
}

/*команда INSERT  - добавление в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма
{	
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
			
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if ($_POST['text'] == '')
	{
		$title = 'Написать сообщение';//Данные тега <title>
		$headMain = 'Написать сообщение';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addform';
		$text = '';
		$idauthor = '';
		$idto = $_POST('id');
		$id = '';
		$button = 'Отправить';
		$errorForm = '';
		$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
		include 'addupdform.html.php';
		exit();
	}
	
	/*INSERT - добавление информации в базу данных*/
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = 'INSERT INTO mainmessages SET 
			mainmessage = :mainmessage,
			mainmessagedate = SYSDATE(),		
			idfrom = :idfrom,
			idto = :idto';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':mainmessage', $_POST['text']);//отправка значения
		$s -> bindValue(':idfrom', $selectedAuthor);//отправка значения
		$s -> bindValue(':idto', $_POST['idto']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$idmessage_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO mainmessages - в данном случае)
		
		$sql = 'SELECT count(idfrom) AS idfrom_count, count(idto) AS idto_count FROM mainmessages 
																				WHERE (idfrom = :idfrom AND idto = :idto) OR 
																				(idto = :idfrom AND idfrom = :idto)';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idfrom', $selectedAuthor);//отправка значения
		$s -> bindValue(':idto', $_POST['idto']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$row = $s -> fetch();
		
		$idFromCount = $row['idfrom_count'];
		$idtoCount = $row['idto_count'];

		$pdo->commit();//подтверждение транзакции		
	}
	
	catch (PDOException $e)
	{		
		$pdo->rollBack();//отмена транзакции

		$error = 'Ошибка добавления сообщения';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Присвоение статуса первого сообщения*/
	if (($idFromCount == 1) && ($idtoCount == 1))
	{
		try
		{
			$sql = 'UPDATE mainmessages SET firstmessage  = "YES" WHERE id = :id';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $idmessage_ind);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка обновления статуса первого сообщения';
			include MAIN_FILE . '/includes/error.inc.php';	
		}
	}
	
	$title = 'Ваше сообщение отправлено';//Данные тега <title>
	$headMain = 'Ваше сообщение отправлено';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include 'messagesucc.html.php';
	exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'X')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	// try
	// {
	// 	$sql = 'SELECT firstmessage FROM mainmessages WHERE id = :idmainmessage';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> bindValue(':idmainmessage', $_POST['idmessage']);//отправка значения
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$error = 'Ошибка выбора первого сообщения';
	// 	include MAIN_FILE . '/includes/error.inc.php';	
	// }
	
	// $row = $s -> fetch();
	
	// $firstMess = $row['firstmessage'];
	
	// if ($firstMess == 'YES')
	// {
	// 	$error = '<p class="for-info-txt">Нельзя удалить первое сообщение в диалоге!</p>';
	// 	include MAIN_FILE . '/includes/error.inc.php';
	// }
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, idfrom, idto, imghead, firstmessage FROM mainmessages WHERE id = :idmainmessage';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idmainmessage', $_POST['idmessage']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора сообщения';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление сообщения';//Данные тега <title>
	$headMain = 'Удаление сообщения';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$idAuthor = $_POST['idauthor'];
	$id = $row['id'];
	$button = 'Удалить';
	
	include 'delete.html.php';
}

if (isset ($_GET['delete']))
{		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'DELETE FROM mainmessages WHERE id = :idmainmessage';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idmainmessage', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации mainmessages';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: //'.MAIN_URL.'/mainmessages/viewmainmessages/?id='.$_POST['idauthor']);//перенаправление обратно в контроллер index.php
	exit();
}	
