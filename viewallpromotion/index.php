<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

$title = 'Каталог промоушен-статей | imagoz.ru';//Данные тега <title>
$headMain = 'Все промоушен-статьи';
$robots = 'noindex, follow';
$descr = 'В данном разделе размещаются список всех промоушен-статей портала';
$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/viewallpromotion/">Весь промоушен</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

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
	$sql = 'SELECT pr.id AS promotionid, promotion, a.id AS authorid, promotiontitle, pr.www, imghead, imgalt, promotiondate, authorname, c.id AS categoryid, categoryname FROM promotion pr 
			INNER JOIN author a ON idauthor = a.id 
			INNER JOIN category c ON idcategory = c.id 
			WHERE premoderation = "YES" ORDER BY promotiondate DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
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
						'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'],
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(*) AS all_articles FROM promotion WHERE premoderation = 'YES'";
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$error = 'Ошибка подсчёта промоушена';
	include MAIN_FILE . '/includes/error.inc.php';
}
	
$row = $s -> fetch();
	
$countPosts = $row["all_articles"];
$pagesCount = ceil($countPosts / $onPage);

include 'viewallpromotion.html.php';
exit();
