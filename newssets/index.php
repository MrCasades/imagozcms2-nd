<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

$title = 'Новостные дайджесты | imagoz.ru';//Данные тега <title>
$headMain = 'Новостные дайджесты';
$robots = 'noindex, nofollow';
$descr = 'Подборки новостей для RSS';
$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/newssets/">Все новостные дайджесты</a> ';//Для хлебных крошек

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
	$sql = 'SELECT 
				id, 
				title, 
				imghead, 
				date, 
				categoryname 
			FROM newsset 
			
			ORDER BY date DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода дайджестов';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$newssets[] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'],
						'date' =>  $row['date'], 'categoryname' =>  $row['categoryname']);
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(id) AS all_articles FROM newsset";
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
$previousPage = $page - 1;
$nextPage = $page + 1;
$secondLast = $pagesCount -1;
$additData = '';

include 'viewallnewssets.html.php';
exit();
