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
	$selectPost = 'SELECT pr.id AS promotionid, a.id AS authorid,  promotion, promotiontitle, promotiondate, imghead, imgalt, pr.www, idauthor, idcategory, c.id AS categoryid, categoryname, authorname FROM promotion pr
			INNER JOIN category c
			ON pr.idcategory = c.id
			INNER JOIN author a
			ON pr.idauthor = a.id 
			WHERE premoderation = "YES" AND idcategory = ';
	$limit = ' ORDER BY promotiondate DESC LIMIT ';		
			
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
		$error = 'Ошибка выбора промоушена';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'promotiondate' => $row['promotiondate'],
						'categoryname' => $row['categoryname'], 'authorname' => $row['authorname'],'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'], 'www' =>  $row['www'],
						'categoryid' => $row['categoryid']);
	}	
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Загрузка настроек раздела*/
	$blockFolder = 'viewallpromotionincat';
	include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(pr.id) AS all_articles FROM promotion pr
				INNER JOIN category c
				ON idcategory = c.id
				INNER JOIN author a
				ON idauthor = a.id 
				WHERE premoderation = 'YES' AND idcategory = ".$idCategory;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта промоушена';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	$previousPage = $page - 1;
	$nextPage = $page + 1;
	$secondLast = $pagesCount -1;
	$additData = '&id='.$idCategory;
	
	include 'promotionincat.html.php';
	exit();
}