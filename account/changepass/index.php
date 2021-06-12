<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Смена пароля*/

if (isset ($_POST['action']) && $_POST['action'] === 'Изменить пароль')
{
	$title = 'Введите старый пароль!';//Данные тега <title>
	$headMain = 'Введите старый пароль';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addnewpass';
	$errLog ='';
	$password = '';
	$button = 'Ввод';
	
	include 'oldpass.html.php';
}
	
if (isset ($_GET['addnewpass']))
{	
	if ($_POST['password'] != '')
	{
		$password = md5($_POST['password'] . 'fgtn');
	}
	
	/*Если старый пароль не совпадает*/
	if ($password != $_SESSION['password'])
	{
		$title = 'Введите старый пароль!';//Данные тега <title>
		$headMain = 'Введите старый пароль';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addnewpass';
		$errLog ='Пароли не совпадают';
		$password = '';
		$button = 'Ввод';
		
		include 'oldpass.html.php';
	}	
	
	else
	{
		$title = 'Введите новый пароль!';//Данные тега <title>
		$headMain = 'Введите новый пароль';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'changepass';
		$errLog ='';
		$password1 = '111';
		$password2 = '';
		$button = 'Ввод';
		
		include 'newpass.html.php';
	}
}

if (isset ($_GET['changepass']))
{
	if (($_POST['password'] != $_POST['password2']) || ($_POST['password'] == ''))
	{
		$title = 'Введите новый пароль!';//Данные тега <title>
		$headMain = 'Введите новый пароль';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'changepass';
		$errLog ='Пароли должны совпадать или поле не должно быть пустым';
		$password1 = ' ';
		$password2 = '';
		$button = 'Ввод';
		
		include 'newpass.html.php';
	}
	
	elseif ($_POST['password'] != '')
	{
		/*Обновление пароля*/
		/*Подключение к базе данных*/
		
		include MAIN_FILE . '/includes/db.inc.php';
	
		$password = md5($_POST['password'] . 'fgtn');
		
		try
		{
			$sql = 'UPDATE author SET password = :password WHERE id = :id';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':password', $password);//отправка значения
			$s -> bindValue(':id', $_SESSION['idAuthor']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка назначения пароля '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}	

		try
		{
			$sql = 'SELECT password FROM author WHERE id = :id';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $_SESSION['idAuthor']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка назначения пароля '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
		
		$row = $s -> fetch();
			
		$_SESSION['password'] = $row['password'];
		
		$title = 'Смена пароля прошла успешно';//Данные тега <title>
		$headMain = 'Смена пароля прошла успешно!';
		$robots = 'noindex, nofollow';
		$descr = 'Сообщение об успешной смене пароля';
		$loggood = 'Вы успешно сменили пароль!';
	
		include MAIN_FILE.'/admin/accessgood.html.php';
		exit();
	}
}