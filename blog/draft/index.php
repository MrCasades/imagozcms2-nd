<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	include '../login.html.php';
	exit();
}

/*возврат ID автора*/
$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

/*Черновик блога*/
if (isset ($_GET['blid']))
{

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_GET['blid']);

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
					b.title as blogtitle,
					c.id AS categoryid, 
					c.categoryname 
                FROM publication p 
				INNER JOIN author a ON p.idauthor = a.id 
				INNER JOIN blogs b ON p.idblog = b.id 
				INNER JOIN category c ON p.idcategory = c.id
				WHERE p.premoderation = "NO" AND p.draft = "YES" AND p.idauthor = '.$selectedAuthor.' AND p.idblog = '.$_GET['blid'].' LIMIT 10';//Вверху самое последнее значение
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
		$pubs[] =  array ('pubid' => $row['pubid'], 'authorid' => $row['authorid'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'blogtitle'  => $row['blogtitle'],
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}

	$title = 'Черновик блога';//Данные тега <title>
	$headMain = 'Черновик блога';
	$robots = 'noindex, nofollow';
	$descr = 'В данном разделе выводятся материалы которые находятся в черновике';

    include 'draft.html.php';
	exit();
}