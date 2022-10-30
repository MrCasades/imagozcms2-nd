<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка статей по тематике*/
if (isset ($_GET['metaid']))
{
	$idMeta = $_GET['metaid'];
			
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
	
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	try
	{
		$sql = 'SELECT newsblock.id AS newsid, author.id AS authorid, news, newstitle, imghead, imgalt, newsdate, authorname, category.id AS categoryid, categoryname, metaname FROM meta 
				INNER JOIN metapost	ON meta.id = idmeta
				INNER JOIN newsblock ON newsblock.id = idnews 
				INNER JOIN author ON author.id = idauthor 
				INNER JOIN category ON category.id = idcategory WHERE premoderation = "YES" AND meta.id = '.$idMeta. ' ORDER BY newsdate DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas_1[] =  array ('id' => $row['newsid'], 'idauthor' => $row['authorid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'],
							'metaname' => $row['metaname']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	if (isset($metas_1))
	{
		$title = $row['metaname'].' | imagoz.ru';//Данные тега <title>
		$headMain = 'Новости по тегу '. '"'.$row['metaname'].'"';
		$robots = 'noindex, follow';
		$descr = 'В даном разделе отображаются все новости, помеченные тегом '.$row['metaname'];		
	}
	
	else
	{
		$title = 'Новости отсутствуют';//Данные тега <title>
		$headMain = 'Новости отсутствуют';
		$robots = 'noindex, follow';
		$descr = ' ';
	}

	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/viewallmetas/?metaid='.$idMeta.'">Материалы по тегу '.$row['metaname'].'</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/viewmetanews/?metaid='.$idMeta.'">Новости по тегу '.$row['metaname'].'</a>';//Для хлебных крошек
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles FROM meta INNER JOIN metapost ON meta.id = idmeta
				INNER JOIN newsblock ON newsblock.id = idnews INNER JOIN author ON author.id = idauthor WHERE premoderation = 'YES' AND meta.id = ".$idMeta;
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'metanews.html.php';
	exit();		

}	
	