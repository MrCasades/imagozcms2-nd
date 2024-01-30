<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

$title = 'Каталог комментариев к новостям | imagoz.ru';//Данные тега <title>
$headMain = 'Все комментарии к промоушен-статьям';
$robots = 'noindex, follow';
$descr = 'В данном разделе отображаются все комментарии к промоушен-статьям портала';

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

/*Вывод комментариев к новостям*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT promotion.id AS promotionid, comments.id AS commentsid, author.id AS authorid, avatar, promotiontitle, authorname, comment, 
					commentdate, subcommentcount 
					FROM comments 
					INNER JOIN author ON idauthor = author.id 
					INNER JOIN promotion ON idpromotion = promotion.id 
					ORDER BY commentdate DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода комментариев';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$promotionComments[] =  array ('id' => $row['commentsid'], 'idauthor' => $row['authorid'], 'text' => $row['comment'], 'promotiontitle' =>  $row['promotiontitle'], 
						'date' =>  $row['commentdate'], 'idpromotion' =>  $row['promotionid'], 'authorname' =>  $row['authorname'], 'avatar' =>  $row['avatar'],
						'subcommentcount' =>  $row['subcommentcount'] );
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(*) AS all_articles FROM comments WHERE idpromotion IS NOT NULL";
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка подсчёта комментариев';
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

include 'viewcomments.html.php';
exit();