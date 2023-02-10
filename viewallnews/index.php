<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

$title = 'Каталог новостей | imagoz.ru';//Данные тега <title>
$headMain = 'Все новости';
$robots = 'noindex, follow';
$descr = 'В данном разделе отображаются все новости портала';
$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/viewallnews/">Все новости</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Постраничный вывод информации*/
		
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
$onPage = 10;// количество статей на страницу
$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод новостей*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT n.id AS newsid, news, a.id AS authorid, newstitle, imghead, imgalt, newsdate, authorname, c.id AS categoryid, categoryname FROM newsblock n 
			INNER JOIN author a ON idauthor = a.id 
			INNER JOIN category c ON idcategory = c.id 
			WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['authorid'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
						'newsdate' =>  $row['newsdate'], 'authorname' =>  $row['authorname'], 
						'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(id) AS all_articles FROM newsblock WHERE premoderation = 'YES'";
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$error = 'Ошибка подсчёта новостей';
	include MAIN_FILE . '/includes/error.inc.php';
}

$row = $s -> fetch();

$countPosts = $row['all_articles'];			
$pagesCount = ceil($countPosts / $onPage);

include 'viewallnews.html.php';
exit();
