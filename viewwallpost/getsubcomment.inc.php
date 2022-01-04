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
		$sql = 'SELECT subcomments.id AS subid, author.id AS subidauthor, subcomment, subcommentdate, authorname AS subauthorname FROM subcomments 
		INNER JOIN author 
		ON idauthor = author.id 
		WHERE idcomment = '.$idComment.' ORDER BY subcommentdate DESC LIMIT 10';//Внизу самое последнее значение
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
		$subcomments[] =  array ('subid' => $row['subid'], 'text' => $row['subcomment'], 'date' => $row['subcommentdate'], 'subauthorname' => $row['subauthorname'],
								'subidauthor' => $row['subidauthor']);
	}
	
	include 'subcomment.html.php';
	exit();
}