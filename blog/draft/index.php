<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*возврат ID автора*/
$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

/*Черновик блога*/
if (isset ($_GET['blid']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

    try
	{
		$sql = 'SELECT 
                    p.id AS pubid,  
                    a.id AS authorid, 
                    p.title, 
                    p.imghead,  
                    p.date, 
                    a.authorname, 
					c.id AS categoryid, 
					c.categoryname 
                FROM publication p 
				INNER JOIN author a ON p.idauthor = a.id 
				INNER JOIN blogs b ON p.idblog = b.id 
				INNER JOIN category c ON p.idcategory = c.id
				WHERE p.premoderation = "NO" AND p.draft = "YES" AND p.idauthor = '.$selectedAuthor.' LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

    catch (PDOException $e)
	{
		$error = 'Ошибка вывода новостей в черновике';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$pubs[] =  array ('pubid' => $row['pubid'], 'authorid' => $row['authorid'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}

    include 'draft.html.php';
	exit();
}