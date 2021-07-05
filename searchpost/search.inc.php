<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Формирование запроса SELECT*/
	
/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

if ($_GET['article_type'] == 'posts')
{
	/*Переменные для выражения SELECT*/
	$select = 'SELECT posts.id AS postid, post, posttitle, imghead, imgalt, postdate, authorname, author.id AS authorid, category.id AS categoryid, categoryname';
	$from = ' FROM posts 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id';
	$where = ' WHERE TRUE AND premoderation = "YES" AND zenpost = "NO"';
}

elseif ($_GET['article_type'] == 'promotions')
{
	/*Переменные для выражения SELECT*/
	$select = 'SELECT promotion.id AS promotionid, promotion, promotiontitle, imghead, imgalt, promotion.www, promotiondate, author.id AS authorid, authorname, category.id AS categoryid, categoryname';
	$from = ' FROM promotion 
			  INNER JOIN author ON idauthor = author.id 
			  INNER JOIN category ON idcategory = category.id';
	$where = ' WHERE TRUE AND premoderation = "YES"';
}

elseif ($_GET['article_type'] == 'news')
{
	/*Переменные для выражения SELECT*/
	$select = 'SELECT newsblock.id AS newsid, news, newstitle, imghead, imgalt, newsdate, authorname, author.id AS authorid, category.id AS categoryid, categoryname';
	$from = ' FROM newsblock 
			  INNER JOIN author ON idauthor = author.id 
			  INNER JOIN category ON idcategory = category.id';
	$where = ' WHERE TRUE AND premoderation = "YES"';

}
	
$forSearch = array();//массив заполнения запроса
		
/*Выбор автора*/
/*
if ($_GET['author'] != '')//Если выбран автор
{
	$where .= " AND idauthor = :idauthor";
	$forSearch[':idauthor'] = $_GET['author'];
}
*/
		
/*Выбор рубрики*/
if ($_GET['category'] != '')//Если выбрана рубрика
{
	$where .= " AND idcategory = :idcategory";
	$forSearch[':idcategory'] = $_GET['category'];
}
		
/*Выбор тематики*/
/*
if ($_GET['meta'] != '')//Если выбрана тематика
{
	$from .= ' INNER JOIN metapost ON posts.id = idpost';
	$where .= " AND metapost.idmeta = :idmeta";
	$forSearch[':idmeta'] = $_GET['meta'];
}
*/
		
/*Поле строки*/
if ($_GET['text'] != '')//Если выбрана какая-то строка
{
	$where .= " AND post LIKE :post OR posttitle LIKE :posttitle";
	$forSearch[':post'] = '%'. $_GET['text']. '%';	
    $forSearch[':posttitle'] = '%'. $_GET['text']. '%';
}
		
/*Объеденение переменных в запрос*/
try
{
	$sql = $select.$from.$where;
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute($forSearch);// метод дает инструкцию PDO отправить запрос MySQL. Т. к. массив $forSearch хранит значение всех псевдопеременных 
								  // не нужно указывать их по отдельности с помощью bindValue									
}

catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка поиска : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}

foreach ($s as $row)
{
	if ($_GET['article_type'] == 'posts')
	{
		$posts[] =  array ('id' => $row['postid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
					'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 'idauthor' =>  $row['authorid'],
					'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
		
	}

	elseif ($_GET['article_type'] == 'promotions')
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'], 'idauthor' =>  $row['authorid'],
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}

	elseif ($_GET['article_type'] == 'news')
	{
		$newsIn[] = array('id' => $row['newsid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 'idauthor' =>  $row['authorid'],
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}
			
include 'searchpost.html.php';
exit();

/*Если нужен поиск по авторам
try
{
	$result = $pdo -> query ('SELECT id, authorname FROM author');
}
catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка вывода author '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}
	
foreach ($result as $row)
{
	$authors[] = array('id' => $row['id'], 'authorname' => $row['authorname']);
}
*/
	

	
/*Если нужен поиск по тегам
try
{
	$result = $pdo -> query ('SELECT id, metaname FROM meta');
}
catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка вывода meta '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}
	
foreach ($result as $row)
{
	$metas[] = array('id' => $row['id'], 'metaname' => $row['metaname']);
}
*/