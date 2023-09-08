<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка статей по тематике*/
if (isset ($_GET['metaid']))
{
	$idMeta = $_GET['metaid'];
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT p.id AS pubid, text, p.title, a.id AS authorid, p.imghead, p.imgalt, p.date, a.authorname, m.metaname, b.id as blogid, b.title as blogtitle FROM meta m
				INNER JOIN metapost mp	ON m.id = mp.idmeta
				INNER JOIN publication p ON p.id = mp.idpublication 
				INNER JOIN author a ON a.id = p.idauthor 
				INNER JOIN blogs b ON p.idblog = b.id 
				WHERE p.premoderation = "YES" AND m.id = '.$idMeta.' ORDER BY p.date DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора публикаций';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas_1[] =  array ('id' => $row['pubid'], 'idauthor' => $row['authorid'], 'text' => $row['text'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 'metaname' => $row['metaname'], 'blogtitle' =>  $row['blogtitle'], 'blogid' => $row['blogid']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Загрузка настроек раздела*/
	$blockFolder = 'viewmetablogpublication';
	include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles FROM meta m INNER JOIN metapost mp ON m.id = mp.idmeta
				INNER JOIN publication p ON p.id = mp.idpublication INNER JOIN author a ON a.id = p.idauthor WHERE p.premoderation = 'YES' AND m.id = ".$idMeta;
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта публикаций';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
		
	include 'metapublication.html.php';
	exit();		

}	
	