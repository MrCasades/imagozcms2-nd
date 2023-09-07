<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Вывод публикаций*/
try
{
	$sql = 'SELECT 
				p.id AS pubid, 
				p.text, 
				a.id AS authorid, 
				p.title, 
				p.imghead, 
				p.imgalt, 
				p.date, 
				a.authorname, 
				c.id AS categoryid, 
				c.categoryname,
				b.id as blogid,
				b.title as blogtitle 
			FROM publication p 
			INNER JOIN author a ON p.idauthor = a.id 
			INNER JOIN category c ON p.idcategory = c.id 
			INNER JOIN blogs b ON p.idblog = b.id
			WHERE p.premoderation = "YES" ORDER BY p.date DESC LIMIT 17';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода публикаций';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$pubs[] =  array ('id' => $row['pubid'], 'idauthor' => $row['authorid'], 'text' => $row['text'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 
							'blogtitle' =>  $row['blogtitle'], 'categoryid' => $row['categoryid']);
}

/*Вывод блогов */

try
{
	$sql = 'SELECT 
				b.id AS blogid, 
				a.id AS authorid, 
				b.title, 
				b.avatar, 
				a.authorname
			FROM blogs b 
			INNER JOIN author a ON b.idauthor = a.id 
			WHERE b.blogpremoderation = "YES" LIMIT 17';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода блогов';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$blogs[] =  array ('id' => $row['blogid'], 'idauthor' => $row['authorid'], 'title' =>  $row['title'], 'avatar' =>  $row['avatar'], 
							'authorname' =>  $row['authorname']);
}

$title = 'Блоги | imagoz.ru';//Данные тега <title>
$headMain = 'Блоги';
$robots = 'all';
$descr = 'Делитесь мнением, пишите интересные заметки в нашем сервисе блогов!';
$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/blogs/">Блоги</a>';//Для хлебных крошек
$scriptJScode = '<script src="script.js"></script>';//добавить код JS
//$breadPart3 = '<a href="//'.MAIN_URL.'/viewnews/?id='.$idPublication.'">'.$row['newstitle'].'</a> ';//Для хлебных крошек

include 'blogs.html.php';
exit();			