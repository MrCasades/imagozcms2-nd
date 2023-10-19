<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

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
		$sql = 'SELECT v.id AS videoid, v.videotitle, a.id AS authorid, v.imghead, v.imgalt, v.videodate, a.authorname, c.id AS categoryid, c.categoryname, m.metaname FROM meta m
				INNER JOIN metapost mp	ON m.id = mp.idmeta
				INNER JOIN video v ON v.id = mp.idvideo
				INNER JOIN author a ON a.id = v.idauthor 
				INNER JOIN category c ON v.idcategory = c.id 
				WHERE v.premoderation = "YES" AND m.id = '.$idMeta.' ORDER BY videodate DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas_1[] =  array ('id' => $row['videoid'], 'idauthor' => $row['authorid'], 'videotitle' =>  $row['videotitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'videodate' =>  $row['videodate'], 'authorname' =>  $row['authorname'],
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'],
							'metaname' => $row['metaname']);
	}
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Загрузка настроек раздела*/
	$blockFolder = 'viewmetavideo';
	include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles FROM meta m INNER JOIN metapost mp ON m.id = mp.idmeta
				INNER JOIN video v ON v.id = mp.idvideo INNER JOIN author a ON a.id = v.idauthor WHERE v.premoderation = 'YES' AND m.id = ".$idMeta;
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	$previousPage = $page - 1;
	$nextPage = $page + 1;
	$secondLast = $pagesCount -1;
	$additData = '&metaid='.$idMeta;
		
	include 'metavideo.html.php';
	exit();		

}	
	