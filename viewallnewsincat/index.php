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

/*Вывод статей по категориям*/

if (isset ($_GET['id']))
{
		
	$idCategory = $_GET['id'];
	$selectNews = 'SELECT n.id AS newsid, a.id AS authorid,  news, newstitle, newsdate, imghead, imgalt, idauthor, idcategory, c.id AS categoryid, categoryname, authorname, imghead FROM newsblock n
			INNER JOIN category c
			ON n.idcategory = c.id
			INNER JOIN author a
			ON n.idauthor = a.id 
			WHERE premoderation = "YES" AND idcategory = ';
	$limit = ' ORDER BY newsdate DESC LIMIT ';		
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу
	
	try
	{
		$sql = $selectNews.$idCategory.$limit.$shift.', '.$onPage;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['authorid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}

	if (isset ($row['categoryname']))		//если статьи в рубрике есть!	
	{
		$title = $row['categoryname'].' | '.MAIN_URL;//Данные тега <title>
		$headMain = 'Все новости рубрики '. '"'.$row['categoryname'].'"';
		$robots = 'noindex, follow';
		$descr = 'В данном разделе публикуются все новости рубрики '.$row['categoryname'];
		$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
		$breadPart2 = '<a href="//'.MAIN_URL.'/viewcategory/?id='.$row['categoryid'].'">Материалы рубрики '.$row['categoryname'].'</a>  >>';//Для хлебных крошек
		$breadPart3 = '<a href="//'.MAIN_URL.'/viewallnewsincat/?id='.$row['categoryid'].'">Новости рубрики '.$row['categoryname'].'</a> ';//Для хлебных крошек
	}
	
	else		//если статьи отсутствуют!
	{
		$title = 'Новости в рубрике отсутствуют | '.MAIN_URL;//Данные тега <title>
		$headMain = 'Новости в рубрике отсутствуют';
		$robots = 'noindex, follow';
		$descr = '';
		$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	}	
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(n.id) AS all_articles FROM newsblock n
			INNER JOIN category c
			ON idcategory = c.id
			WHERE premoderation = 'YES' AND  idcategory = ".$idCategory;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'newsincat.html.php';
	exit();
}