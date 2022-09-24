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
	$selectPosts = 'SELECT post, title, date, imghead, imgalt, idauthorpost, idcategory, url, authorname, categoryname FROM favourites 
						 INNER JOIN author ON idauthorpost = author.id 
			   			 INNER JOIN category ON idcategory = category.id WHERE idauthor = ';
	$limit = ' ORDER BY adddate DESC LIMIT ';
	
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
		$error = 'Ошибка выбора всего избранного автора';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$favourites[] =  array ('post' => $row['post'], 'authorname' => $row['authorname'], 'title' => $row['title'],
							'date' => $row['date'], 'imghead' => $row['imghead'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt'],
							'idauthorpost' => $row['idauthorpost'], 'idcategory' => $row['idcategory'], 'url' => $row['url'],
							'categoryname' => $row['categoryname']);
	}	
	
	if (isset ($row['post']))		//если статьи в рубрике есть!	
	{
		//Выбор имени в заголовок
		try
		{
			$sql = 'SELECT authorname AS accname FROM author WHERE id = '.$idAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора имени автора';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();
		
		$title = 'Все избранные материалы пользователя ' . $row['accname'].' | imagoz.ru';//Данные тега <title>
		$headMain = 'Все избранные материалы пользователя ' . $row['accname'];
		$robots = 'noindex, follow';
		$descr = 'В данном разделе публикуются все статьи пользователя '.$row['accname'];
		$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
		$breadPart2 = '<a href="//'.MAIN_URL.'/account/?id='.$idAuthor.'">Профиль пользователя</a> >> ';//Для хлебных крошек
		$breadPart3 = '<a href="//'.MAIN_URL.'/account/viewallfavourites/?id='.$idAuthor.'">Всё избранное автора</a> ';//Для хлебных крошек
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
		$sql = "SELECT count(*) AS all_articles FROM favourites
				WHERE idauthor = ". $idAuthor;
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
	
	include 'viewallfavourites.html.php';
	exit();
}