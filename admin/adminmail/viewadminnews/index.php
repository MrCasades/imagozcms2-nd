<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

$title = 'Новости администрации';//Данные тега <title>
$headMain = 'Новости администрации';
$robots = 'noindex, nofollow';
$descr = '';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка формы входа*/
if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if ((!userRole('Администратор')) && (!userRole('Автор')))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Вывод всех сообщений*/

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Постраничный вывод информации*/
		
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
$onPage = 10;// количество статей на страницу
$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

/*Команда SELECT*/
try
{
	$sql = 'SELECT adminmail.id AS adminmailid, author.id AS idauthor, message, messagetitle, messagedate, email, authorname FROM adminmail 
			INNER JOIN author ON idauthor = author.id 
			WHERE adminnews = "YES"
			ORDER BY adminmail.id DESC LIMIT 10';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода сообщений формы обратной связи';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$messages[] =  array ('id' => $row['adminmailid'], 'idauthor' => $row['idauthor'], 'text' => $row['message'], 'messagetitle' =>  $row['messagetitle'], 
						'messagedate' =>  $row['messagedate'], 'authorname' =>  $row['authorname'], 'email' =>  $row['email']);
}

/*Определение количества сообщений*/
try
{
	$sql = "SELECT count(*) AS all_articles FROM adminmail WHERE adminnews = 'YES'";
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка подсчёта сообщений';
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
$additData = '';

include 'alladminnews.html.php';
exit();