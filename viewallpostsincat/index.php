<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

/*Вывод статей по категориям*/

if (isset ($_GET['id']))
{
		
	$idCategory = $_GET['id'];
	$selectPost = 'SELECT p.id AS postid, a.id AS authorid, post, posttitle, imghead, imgalt, postdate, authorname, c.id AS categoryid, categoryname FROM posts p
			INNER JOIN author a ON p.idauthor = a.id 
			INNER JOIN category c ON p.idcategory = c.id 
			WHERE premoderation = "YES" AND zenpost = "NO" AND idcategory = ';
	$limit = ' ORDER BY postdate DESC LIMIT ';		
			
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 15;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу
	
	try
	{
		$sql = $selectPost.$idCategory.$limit.$shift.' ,'.$onPage;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['authorid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}	
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Загрузка настроек раздела*/
	$blockFolder = 'viewallpostsincat';
	include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(p.id) AS all_articles FROM posts p
				INNER JOIN category c
				ON idcategory = c.id
				INNER JOIN author a
				ON idauthor = a.id 
				WHERE premoderation = 'YES' AND zenpost = 'NO' AND idcategory = ".$idCategory;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	$previousPage = $page - 1;
	$nextPage = $page + 1;
	$secondLast = $pagesCount -1;
	$additData = '&id='.$idCategory;
	
	include 'postsincat.html.php';
	exit();
}