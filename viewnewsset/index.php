<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	$idSet = $_GET['id'];
	
	$select = 'SELECT 
					id, 
					title, 
					imghead, 
					imgalt,
					date,
					intervalofset, 
					text,
					categoryname, 
					authorname,
					description 
				FROM newsset WHERE id = ';
	
	/*Канонический адрес*/
	if(!empty($_GET['utm_referrer']) || !empty($_GET['page']))
	{
		$canonicalURL = '<link rel="canonical" href="//'.MAIN_URL.'/viewnewsset/?id='.$idSet.'"/>';
	}

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$sql = $select.$idSet;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select news ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['id'];
	$articleText = $row['text'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['date'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$period = $row['intervalofset'];


	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	
	$title = $row['title'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['title'];
	$robots = 'noindex, nofollow';
	$descr = $row['description'];
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/newssets/">Все новостные дайджесты</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/viewnewsset/?id='.$idSet.'">'.$row['title'].'</a> ';//Для хлебных крошек
	$authorComment = '';
	//$jQuery = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	/*Вывод кнопок "Обновить" | "Удалить"*/
	
	if ((isset($_SESSION['loggIn'])) && (userRole('Администратор')))
	{
		$delAndUpd = "<form action = '../admin/updnewsset/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$idSet."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_1'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_2'>
					  </form>";					  
	}
	
	else
	{
		$delAndUpd = '';
	}

	include 'viewnewsset.html.php';
	exit();		
}
