<?php 
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Вывод всех статей автора*/

if (isset ($_GET['id']))
{
	$idAuthor = $_GET['id'];
	$selectPosts = 'SELECT posts.id AS postid, author.id AS authorid, post, posttitle, postdate, imghead, imgalt, idauthor, idcategory, category.id AS categoryid, categoryname, authorname, imghead FROM posts
			INNER JOIN author
			ON author.id = idauthor
			INNER JOIN category
			ON idcategory = category.id
			WHERE premoderation = "YES" AND zenpost = "NO" AND idauthor = ';
	$limit = ' ORDER BY postdate DESC LIMIT ';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу
	
	try
	{
		$sql = $selectPosts.$idAuthor.$limit.$shift.', '.$onPage;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора всех статей автора';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['authorid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
	
	if (isset ($row['post']))		//если статьи в рубрике есть!	
	{
		$title = 'Все статьи автора ' . $row['authorname'].' | imagoz.ru';//Данные тега <title>
		$headMain = 'Все статьи автора ' . $row['authorname'];
		$robots = 'noindex, follow';
		$descr = 'В данном разделе публикуются все статьи автора '.$row['authorname'];
		$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
		$breadPart2 = '<a href="//'.MAIN_URL.'/account/?id='.$idAuthor.'">Профиль пользователя</a> >> ';//Для хлебных крошек
		$breadPart3 = '<a href="//'.MAIN_URL.'/account/allauthorpost/?id='.$idAuthor.'">Статьи автора</a> ';//Для хлебных крошек
	}
	
	else		//если статьи отсутствуют!
	{
		$title = 'Статьи отсутствуют | ImagozCMS';//Данные тега <title>
		$headMain = 'Статьи отсутствуют';
		$robots = 'noindex, follow';
		$descr = '';
	}	
	
	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles FROM posts
				WHERE premoderation = 'YES' AND zenpost = 'NO' AND idauthor = ". $idAuthor;
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$numPosts[] = array('all_articles' => $row['all_articles']);
	}
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'allauthorpost.html.php';
	exit();
}