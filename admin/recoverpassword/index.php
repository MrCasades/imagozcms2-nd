<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Форма ввода E-mail*/
if (isset ($_GET['send']))
{	
	$title = 'Восстановление пароля | imagoz.ru';//Данные тега <title>
	$headMain = 'Восстановление пароля';
	$robots = 'noindex, nofollow';
	$descr = 'Восстановление пароля';

	if (loggedIn())
	{
		/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
	}

	$errLog = '';
	$email = '';
	$action = 'sendmessage';
	$button = 'Отправка';

	include 'enteremailform.html.php';
	exit();	
}
/*Формирование сообщения для восстановления пароля*/
if (isset ($_GET['sendmessage']))
{
	$email = $_POST['email'];
	$tiKey = time() + rand(0, 9);//Временной ключ
	$reKey = rand (1001, 9999);//recovery-key
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT Выбор старого пароля*/
	try
	{
		$sql = 'SELECT password FROM author WHERE email = '.'"'.$email.'"';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора старого пароля';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$oldPassword = $row['password'];//Выбор старого пароля
	
	if (!isset ($oldPassword))
	{
		$error = 'Данный E-mail отсутствует в системе!';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*INSERT - вставка данных в таблицу recoverypasword*/
	
	try
	{
		$sql = 'INSERT INTO recoverypassword SET 
			timekey = '.$tiKey.',
			recoverykey = '.$reKey.',
			email = "'.$email.'",
			oldpassword = "'.$oldPassword.'"';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации в recoverypassword';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$title ='Смена пароля для сайта imagoz.ru';
	
	$message = '<p>Для того, чтобы изменить пароль, перейдите по ссылке <a href="//'.MAIN_URL.'/admin/recoverpassword/?tikey='.$tiKey.'">//'.MAIN_URL.'/admin/recoverpassword/?tikey='.$tiKey.'</a> и в форме введите код '.$reKey.
				'. Cсылка действительна 10 часов. <br>Письмо сформировано автоматически, отвечать на него не нужно!</p>';
	
	$headers = 'Content-type: text/html; charset=utf-8' . "\r\n".
			   'From: Служба восстановления пароля <admin@imagoz.ru>' . "\r\n" .
    		   'Reply-To: admin@imagoz.ru' . "\r\n" .
    		   'X-Mailer: PHP/' . phpversion();
	
	mail($email, $title, $message, $headers);//отправка письма
	
	$title = 'Письмо отправлено';//Данные тега <title>
	$headMain = 'Письмо отправлено';
	$robots = 'noindex, nofollow';
	$descr = 'Письмо отправлено';
	
	$mailSucc = 'По указанному адресу отправлено письмо с дальнейшими инструкциями. Оно действительно 10 часов. Если сообщение не пришло, проверьте в папке "Спам"';
	
	//include 'test.html.php';
	include 'mailsucc.html.php';
	exit();	
}

/*Форма подтверждени смены пароля*/
if (isset($_GET['tikey']))
{
	$tiKey = $_GET['tikey'];
	$time = time();
	
	if ($tiKey+60*60*10 < $time)//Если прошло более 10 часов - ссылка недействительна!
	{
		$error = 'Эта ссылка больше недействительна так как 10 часов истекло. Попробуйте восстановить пароль снова!';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	else
	{
		$title = 'Подтверждение смены пароля';//Данные тега <title>
		$headMain = 'Подтверждение смены пароля';
		$robots = 'noindex, nofollow';
		$descr = 'Подтверждение смены пароля';
		
		$errLog = '';
		$reKey = '';
		$action = 'confrecover';
		$button = 'Подтвердить';
		
		include 'confirmrecoverform.html.php';
		exit();	
	}
}

/*Смена пароля*/
if (isset($_GET['confrecover']))
{
	$tiKey = $_POST['tikey'];//Временной ключ
	$reKey_1 = $_POST['rekey'];//Ключ восстановления
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT Выбор ключа восстановления*/
	try
	{
		$sql = 'SELECT recoverykey, email FROM recoverypassword WHERE timekey = '.$tiKey;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора старого пароля';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$reKey_2 = $row['recoverykey'];//Выбор ключа восстановления из БД
	$email = $row['email'];//Выбор email из БД
	
	if(($reKey_1 != $reKey_2) || ($reKey_1 == ''))
	{
		$title = 'Подтверждение смены пароля';//Данные тега <title>
		$headMain = 'Подтверждение смены пароля';
		$robots = 'noindex, nofollow';
		$descr = 'Подтверждение смены пароля';
		
		$errLog = 'Вы ввели неправильный ключ!';
		$reKey = '';
		$action = 'confrecover';
		$button = 'Подтвердить';
		
		include 'confirmrecoverform.html.php';
		exit();	
	}
	
	elseif ($reKey_1 == $reKey_2)
	{
		$title = 'Смена пароля';//Данные тега <title$
		$headMain = 'Смена пароля';
		$robots = 'noindex, nofollow';
		$descr = 'Смена пароля';
		
		$errLog = '';
		$password = '';
		$password2= '';
		$action = 'recover';
		$button = 'Сменить пароль';
		
		include 'newpass.html.php';			
	}
}

/*Процесс смены пароля*/
if (isset($_GET['recover']))
{
	if (($_POST['password'] != $_POST['password2']) || ($_POST['password'] == ''))
	{
		$title = 'Смена пароля!';//Данные тега <title>
		$headMain = 'Смена пароля';
		$robots = 'noindex, nofollow';
		$descr = 'Смена пароля';
		$email = $_POST['email'];
		$action = 'recover';
		$errLog ='Пароли должны совпадать или поле не должно быть пустым!';
		$password1 = '';
		$password2 = '';
		$button = 'Ввод';
		
		include 'newpass.html.php';
	}
	
	elseif ($_POST['password'] != '')
	{
		/*Обновление пароля*/
		/*Подключение к базе данных*/
		
		include MAIN_FILE . '/includes/db.inc.php';
		
		$email = $_POST['email'];
		$password = md5($_POST['password'] . 'fgtn');
		
		try
		{
			$sql = 'UPDATE author SET password = :password WHERE email = "'.$email.'"';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':password', $password);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$error = 'Ошибка назначения пароля';
			include MAIN_FILE . '/includes/error.inc.php';
		}	
		
		$title = 'Смена пароля прошла успешно';//Данные тега <title>
		$headMain = 'Смена пароля прошла успешно!';
		$robots = 'noindex, nofollow';
		$descr = 'Сообщение об успешной смене пароля';
		$loggood = 'Вы успешно сменили пароль! Теперь можно войти в свою учётную запись с новыми данными!';
	
		include MAIN_FILE.'/admin/accessgood.html.php';
		exit();
	}
}