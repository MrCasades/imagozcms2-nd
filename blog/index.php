<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Флаг, указывающий, что открыт блог*/
$itIsBlog = true;

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{

	(int) $idBlog = $_GET['id'];

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Постраничный вывод информации*/
			
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	/*Вывод блога*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT 
					b.id as blogid
					,b.title
					,b.description
					,b.imghead
					,b.avatar
					,b.indexing
					,b.idauthor
					,a.authorname
				FROM blogs b
				INNER JOIN author a ON b.idauthor = a.id 
				WHERE b.id = :blogid';
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
	$avatar = $row['avatar'];
	$indexing = $row['indexing'];
	$nameAuthor = $row['authorname'];

	/*Определение количества статей*/
	// try
	// {
	// 	$sql = "SELECT count(id) AS all_articles FROM posts WHERE premoderation = 'YES' AND zenpost = 'NO'";
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$error = 'Ошибка подсчёта статей';
	// 	include MAIN_FILE . '/includes/error.inc.php';
	// }
		
	// $row = $s -> fetch();
		
	// $countPosts = $row["all_articles"];
	// $pagesCount = ceil($countPosts / $onPage);

	$selectedAuthor = (isset($_SESSION['loggIn'])) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : '';//id автора

	if ($selectedAuthor == $authorId) 
	{
		$editBlog = "<form action = '../blog/addupdblog/' method = 'post'>
						<input type = 'hidden' name = 'id' value = '".$idBlog."'>
						<button name = 'action' class='btn_1 addit-btn' value='Настройка'>Настройка</button>
					  </form>";
	}

	else
	{
		$editBlog = '';
	}

	

	$title = $blogTitle.' | imagoz.ru';//Данные тега <title>
	$headMain = 'Все статьи';
	$robots = $indexing;
	$descr = 'Блог пользователя '.$nameAuthor;
	//$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	//$breadPart2 = '<a href="//'.MAIN_URL.'/blog/">Все статьи</a> ';//Для хлебных крошек

	include 'blog.html.php';
	exit();
}