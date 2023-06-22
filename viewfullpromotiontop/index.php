<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка настроек раздела*/
$blockFolder = 'viewfullpromotiontop';
include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Постраничный вывод информации*/
		
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
$onPage = 10;// количество статей на страницу
$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

/*Вывод стаей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT promotion.id AS promotionid, promotion, author.id AS authorid, promotiontitle, promotion.www, imghead, imgalt, promotiondate, authorname, viewcount, averagenumber, category.id AS categoryid, categoryname FROM promotion 
			INNER JOIN author ON idauthor = author.id 
			INNER JOIN category ON idcategory = category.id 
			WHERE premoderation = "YES" AND votecount > 1 ORDER BY averagenumber DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода промоушена';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['authorid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'], 'viewcount' =>  $row['viewcount'], 'averagenumber' =>  $row['averagenumber'],
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(*) AS all_articles FROM promotion WHERE premoderation = 'YES' AND votecount > 1";
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка подсчёта промоушена';
	include MAIN_FILE . '/includes/error.inc.php';
}
	
foreach ($result as $row)
{
	$numPosts[] = array('all_articles' => $row['all_articles']);
}
	
$countPosts = $row["all_articles"];
$pagesCount = ceil($countPosts / $onPage);

include 'viewfullpromotiontop.html.php';
exit();
