<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{

	$idBlog = $_GET['id'];

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
		$sql = 'SELECT 
					b.id as blogid
					,b.title
					,b.description
				FROM blogs b
				INNER JOIN author a ON b.idauthor = a.id 

				WHERE a.id = :blogid';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':blogid', $idBlog);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода информации о блоге';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
		
	$blogId = $row['blogid'];
	$authorId = $row['idauthor'];
	$blogTitle = $row['title'];
	$blogDescr = $row['description'];
	$imgHead = $row['imghead'];

	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(id) AS all_articles FROM posts WHERE premoderation = 'YES' AND zenpost = 'NO'";
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	$row = $s -> fetch();
		
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);

	$title = 'Каталог статей | imagoz.ru';//Данные тега <title>
	$headMain = 'Все статьи';
	$robots = 'noindex, follow';
	$descr = 'В данном разделе размещаются список всех статей портала';
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/viewallposts/">Все статьи</a> ';//Для хлебных крошек

	include 'blog.html.php';
	exit();
}