<?php 
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Вывод всех новостей автора*/

if (isset ($_GET['id']))
{
	$idAuthor = $_GET['id'];
	$selectNews = 'SELECT newsblock.id AS newsid, author.id AS authorid, news, newstitle, newsdate, imghead, imgalt, idauthor, idcategory, category.id AS categoryid, categoryname, authorname, imghead FROM newsblock
			INNER JOIN author
			ON author.id = idauthor
			INNER JOIN category
			ON idcategory = category.id
			WHERE premoderation = "YES" AND idauthor = ';
	$limit = ' ORDER BY newsdate DESC LIMIT ';
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу
	
	try
	{
		$sql = $selectNews.$idAuthor.$limit.$shift.', '.$onPage;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора всех новостей автора';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['authorid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
	
	if (isset ($row['news']))		//если статьи в рубрике есть!	
	{
		$title = 'Все новости автора ' . $row['authorname'].' | imagoz.ru';//Данные тега <title>
		$headMain = 'Все новости автора ' . $row['authorname'];
		$robots = 'noindex, follow';
		$descr = 'В данном разделе публикуются все новости автора '.$row['authorname'];
		$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
		$breadPart2 = '<a href="//'.MAIN_URL.'/account/?id='.$idAuthor.'">Профиль пользователя</a> >> ';//Для хлебных крошек
		$breadPart3 = '<a href="//'.MAIN_URL.'/account/allauthornews/?id='.$idAuthor.'">Новости автора</a> ';//Для хлебных крошек
	}
	
	else		//если статьи отсутствуют!
	{
		$title = 'Новости отсутствуют | ImagozCMS';//Данные тега <title>
		$headMain = 'Новости отсутствуют';
		$robots = 'noindex, follow';
		$descr = '';
	}	
	
	/*Определение количества новостей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles FROM newsblock
				WHERE premoderation = 'YES' AND idauthor = ". $idAuthor;
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
	$previousPage = $page - 1;
	$nextPage = $page + 1;
	$secondLast = $pagesCount -1;
	$additData = '&id='.$idAuthor;
	
	include 'allauthornews.html.php';
	exit();
}