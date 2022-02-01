<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

$title = 'Список категорий автора';//Данные тега <title>
$headMain = 'Авторские категории в базе данных';
$robots = 'noindex, nofollow';
$descr = '';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Добавление информации в таблицу category*/
	
$padgeTitle = 'Новая авторская категория';// Переменные для формы "Категория"
$action = 'addform';
$categoryname = '';
$bonus = '';
$idcategory = '';
$button = 'Добавить категорию';

if (isset ($_GET['addform']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'INSERT INTO authorcategory 
					SET authcategoryname = :authcategoryname,
						categorybonus = :categorybonus';// псевдопеременная получающая значение из формы
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':authcategoryname', $_POST['authcategoryname']);//отправка значения
		$s -> bindValue(':categorybonus', $_POST['categorybonus']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: .');//перенаправление обратно в контроллер index.php
	exit();
}	

/*Редактирование информации в таблице category*/

if (isset ($_POST['action']) && ($_POST['action'] == 'Upd'))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT 
					id, 
					authcategoryname, 
					categorybonus
				FROM authorcategory 
				WHERE id = :idcategory';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcategory', $_POST['idcategory']);//отправка значения
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
	
	$padgeTitle = 'Редактировать рубрику';// Переменные для формы "Рубрика"
	$action = 'editform';
	$categoryname = $row['authcategoryname'];
	$bonus = $row['categorybonus'];
	$idcategory = $row['id'];
	$button = 'Обновить информацию';
	
	include 'form.html.php';
	exit();
	
}
	/*Команда UPDATE*/
if (isset ($_GET['editform']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE authorcategory 
					SET authcategoryname = :authcategoryname,
						categorybonus = :categorybonus	 
				WHERE id = :idcategory';// псевдопеременная получающая значение из формы
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcategory', $_POST['idcategory']);//отправка значения
		$s -> bindValue(':authcategoryname', $_POST['authcategoryname']);//отправка значения
		$s -> bindValue(':categorybonus', $_POST['categorybonus']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error Update: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: .');//перенаправление обратно в контроллер index.php
	exit();
}	

/*Удаление из таблици category*/

if (isset ($_POST['action']) && ($_POST['action'] == 'Del'))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	
	{
		$sql = 'DELETE FROM authorcategory WHERE id = :idcategory';// - псевдопеременная получающая значение из формы
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcategory', $_POST['idcategory']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: .');//перенаправление обратно в контроллер index.php
	exit();
}

/*Назначение бонусов и премий*/
if (isset ($_POST['addcat']) && $_POST['addcat'] == 'Назначить категорию')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT * FROM authorcategory';
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора категории: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$categorys[] =  array ('id' => $row['id'], 
							'authcategoryname' => $row['authcategoryname'],
							'categorybonus' => $row['categorybonus'],
							);
	}

	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT idauthcategory FROM author WHERE author.id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора информации о бонусе : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
		
	$title = 'Выбрать категорию';//Данные тега <title>
	$headMain = 'Выбрать категорию';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addauhcat';
	$idcategory = $row['idauthcategory'];
	$idauthor = $_POST['id'];
	$button = 'Назначить';
	$errorForm ='';
	
	include 'addcategoryform.html.php';
	exit();
}

/*Обновить бонус или назначить премию*/
if (isset($_GET['addauhcat']))//Если есть переменная editpayment выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE author SET 
			idauthcategory = :category
			WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':category', $_POST['category']);//отправка значения
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации о бонусе или счёте'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: //'.MAIN_URL.'/account/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();
}

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Команда SELECT*/
try
{
	$sql = 'SELECT * FROM authorcategory';
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка выбора категории: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$categorys[] =  array ('id' => $row['id'], 
						   'authcategoryname' => $row['authcategoryname'],
						   'categorybonus' => $row['categorybonus'],
						);
}

include 'authorcaegory.html.php';
exit();
