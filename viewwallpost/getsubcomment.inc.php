<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка содержимого записи*/
if (isset ($_GET['id']))
{
    /*Подключение к базе данных*/
    include MAIN_FILE . '/includes/db.inc.php';

	$idComment = $_GET['id'];

	$selectedAuthor = $_GET['selauthid'];
	
	/*Вывод ответов*/
	
	try
	{
		$sql = 'SELECT 
			scm.id, 
			a.id AS subidauthor, 
			scm.subcomment, 
			scm.subcommentdate, 
			scm.likescount,
			scm.dislikescount, 
			a.authorname AS subauthorname,
			a.avatar AS subavatar,
			scml.islike, 
			scml.isdislike 
		FROM subcomments scm
		INNER JOIN author a
		ON scm.idauthor = a.id 
		LEFT JOIN 
			(SELECT idauthor AS idauthorlk, idsubcomment, islike, isdislike
			FROM subcommentlikes WHERE idauthor = '.$selectedAuthor.') scml
		ON scm.id = scml.idsubcomment
		WHERE scm.idcomment = '.$idComment.' ORDER BY scm.subcommentdate DESC LIMIT 5';//Внизу самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error table in mainpage' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$subcomments[] =  array ('id' => $row['id'], 'text' => $row['subcomment'], 'date' => $row['subcommentdate'], 'subauthorname' => $row['subauthorname'],
								'subavatar' => $row['subavatar'], 'subidauthor' => $row['subidauthor'], 'likescount' => $row['likescount'], 'dislikescount' => $row['dislikescount'], 
								'islike' => $row['islike'],	'isdislike' => $row['isdislike']);
	}
	
	include 'subcomment.html.php';
	exit();
}