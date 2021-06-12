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

else
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	
	include '../../admin/login.html.php';
	exit();
}

$idAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

$title = 'Настройка аккаунта';//Данные тега <title>
$headMain = 'Настройка аккаунта';
$robots = 'noindex, follow';
$descr = '';

include MAIN_FILE . '/includes/db.inc.php';
	
/*Выбор аватара для изменения*/
try
{
	$sql = 'SELECT avatar, authorname FROM author WHERE id = :id';
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> bindValue(':id', $idAuthor);//отправка значения
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}
	
catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка вывода аккаунта ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}

$row = $s -> fetch();
		
$avatar = $row['avatar'];	
$authorName = $row['authorname'];

/*Если установлен аватар по умолчанию, то его нельзя удалить*/
$delAva = $avatar === "ava-def.jpg" ? '' : '<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Удалить аватар">';

if ((userRole('Администратор')) || (userRole('Автор')) || (userRole('Рекламодатель')))
{
	$payForm = '
					<div class = "titles_main_padge"><h4 align="center">Обновить платёжные реквизиты</h4></div>
					<div class ="post" align="center">
					<p>Обновите платёжные реквизиты, чтобы получить возможность создавать заявки на вывод средств.</p>
					  <form action = "../../admin/payment/" method = "post">
							<input type = "hidden" name = "id" value = "'.$idAuthor.'">
							<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Вывести средства">
							<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Обновить платёжные реквизиты">
					  </form>
					 </div>';// вывод средств и обновление реквизитов
		
	/*История платежей на будущее
	$payFormIn = '	<div class = "titles_main_padge"><h4 align="center">История платежей</div>
					<p>Обновите платёжные реквизиты, чтобы получить возможность создавать заявки на вывод средств.</p>
					<div class = "titles_main_padge"><h4 align="center">Добавить / изменить дополнительную информацию профиля</h4></div>
					<form action = "../admin/payment/" method = "post">
								<div>
									<input type = "hidden" name = "id" value = "'.$idAuthor.'">
									<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "Пополнить счёт">
									<input type = "submit" name = "action" class="btn btn-primary btn-sm" value = "История платежей">
								</div>
							</form>';// перечислить средства на счёт*/
}

else
{
	$payForm = '';
}

include 'setaccount.html.php';
exit();