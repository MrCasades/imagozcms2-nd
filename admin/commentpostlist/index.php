<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

$title = 'Каталог комментариев к новостям | imagoz.ru';//Данные тега <title>
$headMain = 'Все комментарии к статьям';
$robots = 'noindex, follow';
$descr = 'В данном разделе отображаются все комментарии к статьям портала';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

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
	$sql = 'SELECT posts.id AS postsid, comments.id AS commentsid, author.id AS authorid, avatar, posttitle, authorname, comment, 
					commentdate, subcommentcount 
					FROM comments 
					INNER JOIN author ON idauthor = author.id 
					INNER JOIN posts ON idpost = posts.id 
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
	$postComments[] =  array ('id' => $row['commentsid'], 'idauthor' => $row['authorid'], 'text' => $row['comment'], 'posttitle' =>  $row['posttitle'], 
						'date' =>  $row['commentdate'], 'idposts' =>  $row['postsid'], 'authorname' =>  $row['authorname'], 'avatar' =>  $row['avatar'],
						'subcommentcount' =>  $row['subcommentcount'] );
}

/*Определение количества статей*/
try
{
	$sql = "SELECT count(*) AS all_articles FROM comments WHERE idpost IS NOT NULL";
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