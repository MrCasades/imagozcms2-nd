<?php
/*Вывод новостей в правую панель*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT n.id, n.newstitle, n.newsdate, n.imghead, c.categoryname
			FROM newsblock n 
			INNER JOIN category c ON idcategory = c.id  
			WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 6';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
	$headMain = 'Ошибка данных!';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Ошибка вывода новостей на главной странице ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	include 'error.html.php';
	exit();
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$newsInRs[] =  array ('id' => $row['id'], 'newstitle' =>  $row['newstitle'], 'newsdate' =>  $row['newsdate'], 'categoryname' =>  $row['categoryname'],
						'imghead' =>  $row['imghead']);
}
	
include 'newsblockinrightside.inc.html.php';