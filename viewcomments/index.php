<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка содержимого статьи*/
if (isset ($_GET['idpost']))
{
	$idPost = $_GET['idpost'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idpost'] = $idPost;
	$select = 'SELECT * FROM posts WHERE id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPost;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Error table in mainpage' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['id'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 
							'postdate' => $row['postdate'], 'viewcount' => $row['viewcount'], 'averagenumber' => $row['averagenumber']);
	}	
	
	$title = 'Комментарии к '.$row['posttitle'];//Данные тега <title>
	$headMain = 'Комментарии к '.$row['posttitle'];
	$authorComment = '';
	
	/*Вывод комментариев*/
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 5;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	try
	{
		$sql = 'SELECT comments.id, comment, commentdate, authorname FROM comments 
		INNER JOIN author 
		ON idauthor = author.id 
		WHERE idpost = '.$idPost.' 
		ORDER BY comments.id DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Error table in mainpage' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$comments[] =  array ('id' => $row['id'], 'text' => $row['comment'], 'date' => $row['commentdate'], 'authorname' => $row['authorname']);
	}
	
	/*Определение количества статей*/
	$sql = "SELECT count(*) AS all_articles FROM comments WHERE idpost = ".$idPost;
	$result = $pdo->query($sql);
	
	foreach ($result as $row)
	{
			$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'viewcomments.html.php';
	exit();		
}
